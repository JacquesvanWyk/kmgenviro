<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating admin users...');
        $this->command->newLine();

        // Developer Admin
        $devPassword = Str::random(16);
        User::create([
            'name' => 'Jacques van Wyk',
            'email' => 'jvw679@gmail.com',
            'password' => Hash::make($devPassword),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Developer admin created successfully!');
        $this->command->line('Email: jvw679@gmail.com');
        $this->command->warn("Password: {$devPassword}");
        $this->command->info('Please save this password securely!');
        $this->command->newLine();

        // Client Admin
        $clientPassword = Str::random(16);
        User::create([
            'name' => 'Khumbelo Marabe',
            'email' => 'marabekg@kmgenviro.co.za',
            'password' => Hash::make($clientPassword),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Client admin created successfully!');
        $this->command->line('Email: marabekg@kmgenviro.co.za');
        $this->command->warn("Password: {$clientPassword}");
        $this->command->info('Please save this password and share securely with client!');
        $this->command->newLine();

        $this->command->info('Both admin users can now log in at /admin');
    }
}