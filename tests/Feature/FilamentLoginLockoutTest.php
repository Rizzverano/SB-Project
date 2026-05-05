<?php

namespace Tests\Feature;

use App\Filament\Pages\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentLoginLockoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_sent_to_challenge_after_login_lockout_expires(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => User::ADMIN,
            'is_active' => true,
        ]);

        $component = Livewire::test(Login::class);

        foreach (range(1, 3) as $attempt) {
            $component
                ->set('data.email', $user->email)
                ->set('data.password', 'wrong-password')
                ->call('authenticate')
                ->assertHasErrors(['data.email']);
        }

        $this->assertGuest();
        $this->assertTrue(session('login_needs_challenge'));
        $this->assertSame($user->email, session('login_challenge_email'));
        $this->assertNotNull(session('login_lockout_until'));

        $component
            ->set('data.email', $user->email)
            ->set('data.password', 'password123')
            ->call('authenticate')
            ->assertHasErrors(['data.email']);

        $this->assertGuest();

        $this->travel(61)->seconds();

        Livewire::test(Login::class)
            ->set('data.email', $user->email)
            ->set('data.password', 'password123')
            ->call('authenticate')
            ->assertRedirect('/admin/login-challenge');

        $this->assertGuest();
    }

    public function test_three_wrong_challenge_answers_send_user_back_to_locked_login(): void
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
            ]),
        ]);

        $session = [
            'login_needs_challenge' => true,
            'login_challenge_email' => 'admin@example.com',
            'challenge_num1' => 2,
            'challenge_num2' => 3,
            'challenge_answer' => 5,
        ];

        $this->withSession($session)
            ->post('/admin/login-challenge', [
                'answer' => '0',
                'token' => 'valid-token',
            ])
            ->assertSessionHasErrors(['answer']);

        $this->post('/admin/login-challenge', [
            'answer' => '0',
            'token' => 'valid-token',
        ])->assertSessionHasErrors(['answer']);

        $this->post('/admin/login-challenge', [
            'answer' => '0',
            'token' => 'valid-token',
        ])
            ->assertRedirect('/admin/login')
            ->assertSessionHasErrors(['data.email']);

        $this->assertTrue(session('login_needs_challenge'));
        $this->assertNotNull(session('login_lockout_until'));
    }
}
