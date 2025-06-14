<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('@Admin1_$$')
            ]
        );
        $admin->assignRole('admin');
        // Regular user
         $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('@User1_$$')
            ]
        );
         $user->assignRole('user');
        
        DB::statement("INSERT INTO `oauth_clients` (`id`, `owner_type`, `owner_id`, `name`, `secret`, `provider`, `redirect_uris`, `grant_types`, `revoked`, `created_at`, `updated_at`) VALUES
('01976e3b-bcb5-7305-9ef5-908ef797584f', NULL, NULL, 'user1', '$2y$12\$joXBbMbqSAt/pTxjQRjXk.ntn9STeX1ROoIoh3aU7lDYlRGWhPnXC', 'users', '[]', '[\"password\",\"refresh_token\"]', 0, '2025-06-14 08:38:18', '2025-06-14 08:38:18');
");
    }
}
