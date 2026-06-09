<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SpectatorSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'wyaneb712@gmail.com'],
            [
                'name' => 'Spectator User',
                'password' => Hash::make('password123'),
                'role' => User::SPECTATOR,
            ]
        );
    }
}
