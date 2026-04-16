<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SystemInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking database connection...');

        try {
            DB::connection()->getPdo();
        } catch (\Throwable $exception) {
            $this->error('Could not connect to the database: '.$exception->getMessage());

            return static::FAILURE;
        }

        $this->info('Database connection OK. Running migrations...');

        try {
            $this->call('migrate', [
                '--force' => true,
            ]);
        } catch (\Throwable $exception) {
            $this->error('Database migration failed: '.$exception->getMessage());

            return static::FAILURE;
        }

        $this->info('Migrations complete. Seeding database...');

        try {
            $this->call('db:seed', [
                '--force' => true,
            ]);
        } catch (\Throwable $exception) {
            $this->error('Database seeding failed: '.$exception->getMessage());

            return static::FAILURE;
        }

        $this->info('Database seeded. Configure the first super user.');

        $superUserRole = Role::query()->where('name', 'su')->first();

        if (! $superUserRole) {
            $this->error('Super user role (name: su) not found. Ensure RoleSeeder has been run correctly.');

            return static::FAILURE;
        }

        if (User::query()->where('role_id', $superUserRole->id)->exists()) {
            $this->info('A super user already exists. Skipping super user creation.');

            return static::SUCCESS;
        }

        $name = $this->ask('Super user first name');
        $surname = $this->ask('Super user surname');
        $email = $this->ask('Super user email address');

        $password = $this->secret('Super user password');
        $passwordConfirmation = $this->secret('Confirm super user password');

        if ($password !== $passwordConfirmation) {
            $this->error('Passwords do not match. Please run the command again to retry.');

            return static::FAILURE;
        }

        if (User::query()->where('email', $email)->exists()) {
            $this->error('A user with this email already exists. Please run the command again with a different email.');

            return static::FAILURE;
        }

        User::query()->create([
            'role_id' => $superUserRole->id,
            'school_id' => null,
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'status' => 1,
            'tutor_approved' => false,
        ]);

        $this->info('Super user created successfully.');

        $this->info('System initialization completed successfully.');

        return static::SUCCESS;
    }
}
