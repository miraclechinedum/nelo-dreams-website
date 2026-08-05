<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:user
                            {email? : The sign-in email address}
                            {--name= : Display name}
                            {--password= : Password (you will be prompted if omitted)}';

    protected $description = 'Create an admin account for the media panel, or reset an existing one’s password';

    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Email address');
        $existing = User::where('email', $email)->first();

        $name = $this->option('name')
            ?: $existing?->name
            ?: $this->ask('Display name', 'Nelo Dreams Admin');

        $password = $this->option('password') ?: $this->secret('Password');

        $validator = Validator::make(
            ['email' => $email, 'name' => $name, 'password' => $password],
            [
                'email' => ['required', 'email', 'max:160'],
                'name' => ['required', 'string', 'max:120'],
                'password' => ['required', Password::min(10)],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password)]
        );

        $this->info($user->wasRecentlyCreated
            ? "Admin account created for {$email}."
            : "Password reset for {$email}.");

        $this->line('Sign in at '.url('/admin/login'));

        return self::SUCCESS;
    }
}
