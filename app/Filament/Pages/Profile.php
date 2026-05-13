<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use App\Mail\UserAccountStatusMail;
use Illuminate\Support\Facades\Mail;
use Throwable;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.pages.profile';
    protected static ?string $navigationLabel = 'Profile';
    protected static ?string $title = 'My Profile';
    protected static ?int $navigationSort = 999;
    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public bool $awaitingProfileOtp = false;

    public function mount(): void
    {
        $this->awaitingProfileOtp = session()->has($this->profileOtpSessionKey());

        $this->form->fill([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'profile_otp' => '',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(50)
                    ->minLength(3)
                    ->regex('/^[a-zA-Z\s]+$/')
                    ->validationMessages([
                        'required' => 'Name is required.',
                        'min' => 'Name must be at least 3 characters.',
                        'regex' => 'Name must only contain letters and spaces.',
                    ]),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->minLength(5)
                    ->maxLength(255)
                    ->regex('/^\S*$/')
                    ->unique(table: 'users', column: 'email', ignorable: auth()->user())
                    ->validationMessages([
                        'required' => 'Email is required.',
                        'email' => 'Enter a valid email address.',
                        'unique' => 'This email is already taken.',
                        'regex' => 'Email must not contain spaces.',
                    ]),

                TextInput::make('current_password')
                    ->label('Current Password')
                    ->password()
                    ->revealable()
                    ->required(fn($get) => filled($get('password')))
                    ->rules([
                        fn() => function ($attribute, $value, $fail) {
                            if (filled($value) && !Hash::check($value, auth()->user()->password)) {
                                $fail('Current password is incorrect.');
                            }
                        },
                    ]),

                TextInput::make('password')
                    ->label('New Password')
                    ->password()
                    ->revealable()
                    ->nullable()
                    ->minLength(8)
                    ->maxLength(255)
                    ->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])\S+$/')
                    ->same('password_confirmation')
                    ->helperText(str('
                        <div class="grid grid-cols-2 gap-x-6 gap-y-1 mt-2 text-xs text-gray-400">
                            <span>• At least 8 characters</span>
                            <span>• One uppercase letter</span>
                            <span>• One lowercase letter</span>
                            <span>• One number</span>
                            <span>• One symbol (! @ # $ % ^ & *)</span>
                        </div>
                    ')->toHtmlString())
                    ->validationMessages([
                        'min'       => 'Password must be at least 12 characters.',
                        'same'      => 'Passwords do not match.',
                        'regex'     => 'Password must have at least 12 characters, one uppercase letter, one lowercase letter, one number, and one symbol (! @ # $ % ^ & *).',
                    ]),

                TextInput::make('password_confirmation')->label('Confirm Password')->password(),

                TextInput::make('profile_otp')
                    ->label('OTP Verification Code')
                    ->numeric()
                    ->length(6)
                    ->visible(fn () => $this->awaitingProfileOtp)
                    ->dehydrated(false)
                    ->validationMessages([
                        'numeric' => 'OTP must contain numbers only.',
                        'length' => 'OTP must be 6 digits.',
                    ]),
            ])
            ->statePath('data');
    }

    public function update(): void
    {
        if ($this->awaitingProfileOtp && session()->has($this->profileOtpSessionKey())) {
            $this->verifyOtpAndUpdateProfile();
            return;
        }

        $this->sendOtpBeforeProfileUpdate();
    }

    protected function sendOtpBeforeProfileUpdate(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        if (!empty($data['password'])) {
            if (empty($data['current_password']) || !Hash::check($data['current_password'], $user->password)) {
                Notification::make()->title('Current password is incorrect!')->danger()->send();
                return;
            }
        }

        $pendingChanges = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => !empty($data['password']) ? Hash::make($data['password']) : null,
        ];

        $otp = (string) random_int(100000, 999999);

        if (! $this->sendProfileOtpEmail($user->email, $user->name, $otp)) {
            return;
        }

        session([
            $this->profileOtpSessionKey() => [
                'otp_hash' => Hash::make($otp),
                'expires_at' => now()->addMinutes(10)->timestamp,
                'pending_changes' => $pendingChanges,
            ],
        ]);

        $this->awaitingProfileOtp = true;
        $this->data['profile_otp'] = '';

        Notification::make()
            ->title('OTP sent')
            ->body('A verification code was sent to your email. Enter it to save your profile changes.')
            ->success()
            ->send();
    }

    protected function verifyOtpAndUpdateProfile(): void
    {
        $otp = (string) ($this->data['profile_otp'] ?? '');
        $sessionData = session($this->profileOtpSessionKey());

        if (! $sessionData || now()->timestamp > ($sessionData['expires_at'] ?? 0)) {
            $this->clearProfileOtpSession();

            Notification::make()
                ->title('OTP expired')
                ->body('Please save your profile changes again to receive a new OTP.')
                ->danger()
                ->send();

            return;
        }

        if (! preg_match('/^\d{6}$/', $otp) || ! Hash::check($otp, $sessionData['otp_hash'])) {
            Notification::make()
                ->title('Invalid OTP')
                ->body('The verification code you entered is incorrect.')
                ->danger()
                ->send();

            return;
        }

        $pendingChanges = $sessionData['pending_changes'];
        $user = Auth::user();

        $user->name = $pendingChanges['name'];
        $user->email = $pendingChanges['email'];

        if (! empty($pendingChanges['password'])) {
            $user->password = $pendingChanges['password'];
        }

        $user->save();
        $this->clearProfileOtpSession();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
            'profile_otp' => '',
        ]);

        Notification::make()->title('Profile updated successfully!')->success()->send();
    }

    protected function sendProfileOtpEmail(string $email, string $name, string $otp): bool
    {
        try {
            Mail::to($email)->send(new UserAccountStatusMail(
                $name,
                "Your OTP verification code is {$otp}. This code will expire in 10 minutes. Your profile changes will only be saved after this code is verified.",
                'Profile Update OTP Verification',
            ));

            return true;
        } catch (Throwable $exception) {
            report($exception);

            Notification::make()
                ->title('OTP email not sent')
                ->body('Your profile changes were not saved because the OTP email could not be sent.')
                ->danger()
                ->send();

            return false;
        }
    }

    protected function profileOtpSessionKey(): string
    {
        return 'profile_update_otp.'.Auth::id();
    }

    protected function clearProfileOtpSession(): void
    {
        session()->forget($this->profileOtpSessionKey());
        $this->awaitingProfileOtp = false;
        $this->data['profile_otp'] = '';
    }
}
