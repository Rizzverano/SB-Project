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

    public function mount(): void
    {
        $this->form->fill([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
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
                    ->minLength(12)
                    ->maxLength(255)
                    ->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])\S+$/')
                    ->same('password_confirmation')
                    ->helperText(str('
                        <div class="grid grid-cols-2 gap-x-6 gap-y-1 mt-2 text-xs text-gray-400">
                            <span>• At least 12 characters</span>
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
            ])
            ->statePath('data');
    }
    public function update(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        if (!empty($data['password'])) {
            if (empty($data['current_password']) || !Hash::check($data['current_password'], $user->password)) {
                Notification::make()->title('Current password is incorrect!')->danger()->send();
                return;
            }
            $user->password = Hash::make($data['password']);
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        Notification::make()->title('Profile updated successfully!')->success()->send();
    }
}
