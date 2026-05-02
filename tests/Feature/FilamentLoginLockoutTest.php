<?php

namespace Tests\Feature;

use App\Filament\Pages\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentLoginLockoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_locked_out_for_thirty_seconds_after_three_failed_login_attempts(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // ✅ FIXED (hashed)
            'role' => User::ADMIN,
            'is_active' => true,
        ]);

        $component = Livewire::test(Login::class);

        // ❌ 3 failed attempts
        foreach (range(1, 3) as $attempt) {
            $component
                ->set('data.email', $user->email)
                ->set('data.password', 'wrong-password')
                ->call('authenticate')
                ->assertHasErrors(['data.email']);
        }

        // 🚫 Attempt correct login during lockout (should still fail)
        $component
            ->set('data.email', $user->email)
            ->set('data.password', 'password123')
            ->call('authenticate')
            ->assertHasErrors(['data.email']); // ✅ ensure still blocked

        $this->assertGuest(); // still not logged in

        // ⏳ Travel beyond lockout duration
        $this->travel(31)->seconds();

        // ✅ Now login should succeed
        Livewire::test(Login::class)
            ->set('data.email', $user->email)
            ->set('data.password', 'password123')
            ->call('authenticate');

        $this->assertAuthenticatedAs($user);
    }
}
