<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'telegram_id' => 1977820584,
            'language_id' => 1,
            'command' => 'start',
            'first_name' => 'admin',
            'last_name' => null,
            'email' => 'admin@localhost',
            'password' => Hash::make('password'),
        ]);
    }
}
