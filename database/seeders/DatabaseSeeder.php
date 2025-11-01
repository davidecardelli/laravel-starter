<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Database Seeder
 *
 * Seeds the database with initial data for development.
 * Creates roles, permissions, and demo users for each role.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Creates roles/permissions and 4 demo users (one per role).
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call(RolePermissionSeeder::class);

        // Create demo users for each role
        $this->command->info('Creating demo users...');

        $superAdmin = User::factory()->create([
            'first_name' => 'Marco',
            'last_name' => 'Rossi',
            'phone' => '+39 333 1234567',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $admin = User::factory()->create([
            'first_name' => 'Giulia',
            'last_name' => 'Bianchi',
            'phone' => '+39 334 2345678',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        $manager = User::factory()->create([
            'first_name' => 'Luca',
            'last_name' => 'Verdi',
            'phone' => '+39 335 3456789',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
        ]);
        $manager->assignRole('manager');

        $user = User::factory()->create([
            'first_name' => 'Sara',
            'last_name' => 'Neri',
            'phone' => '+39 336 4567890',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');

        $this->command->info('✅ Demo users created successfully!');
        $this->command->newLine();
        $this->command->table(
            ['First Name', 'Last Name', 'Email', 'Phone', 'Role', 'Password'],
            [
                ['Marco', 'Rossi', 'superadmin@example.com', '+39 333 1234567', 'super-admin', 'password'],
                ['Giulia', 'Bianchi', 'admin@example.com', '+39 334 2345678', 'admin', 'password'],
                ['Luca', 'Verdi', 'manager@example.com', '+39 335 3456789', 'manager', 'password'],
                ['Sara', 'Neri', 'user@example.com', '+39 336 4567890', 'user', 'password'],
            ]
        );
        $this->command->newLine();
        $this->command->warn('⚠️  Remember to change these passwords in production!');
    }
}
