<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Member User',
                'password' => Hash::make('password123'),
                'role' => User::MEMBER,
            ]
        );
    }
}
