<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain\Users\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    // El nombre y la firma del comando
    protected $signature = 'create:admin-user';

    // La descripción del comando
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Enter the name of the admin user');
        $email = $this->ask('Enter the email of the admin user');
        $password = $this->secret('Enter the password for the admin user');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Asumiendo que estás utilizando spatie/laravel-permission para roles y permisos
        $user->assignRole('admin');

        $this->info('Admin user created successfully!');

        return 0;
    }
}
