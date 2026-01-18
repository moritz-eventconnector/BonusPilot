<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'app:create-admin {--name=} {--email=} {--password=}';
    protected $description = 'Create or update an admin user.';

    public function handle(): int
    {
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');

        if (! $name || ! $email || ! $password) {
            $this->error('Name, email, and password are required.');
            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        $this->info("Admin user ready: {$user->email}");

        return self::SUCCESS;
    }
}
