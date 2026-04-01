<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'free@example.com'],
            [
                'name' => 'Free User',
                'password' => Hash::make('password123'),
                'plan' => 'free',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pro@example.com'],
            [
                'name' => 'Pro User',
                'password' => Hash::make('password123'),
                'plan' => 'pro',
            ]
        );

        User::updateOrCreate(
            ['email' => 'team@example.com'],
            [
                'name' => 'Team User',
                'password' => Hash::make('password123'),
                'plan' => 'team',
            ]
        );
    }
}
