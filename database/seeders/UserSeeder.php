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
            ('019769c8-b92a-7071-a334-fc651301f25e', NULL, 2, 'test2', '$2y$12$4CQG6xJKiizh3r3osaXfIOhwthVCSrwBebdNAlh3MvKlGdYGp6hBG', NULL, '[\"http:\\/\\/localhost\\/auth\\/callback\"]', '[\"authorization_code\",\"refresh_token\",\"urn:ietf:params:oauth:grant-type:device_code\",\"password\"]', 0, '2025-06-13 11:54:11', '2025-06-13 11:54:11')");
        DB::statement("INSERT INTO `oauth_clients` (`id`, `owner_type`, `owner_id`, `name`, `secret`, `provider`, `redirect_uris`, `grant_types`, `revoked`, `created_at`, `updated_at`) VALUES
            ('01976b67-c10f-7221-bc8e-beb5cac47658', NULL, 1, 'test3', '$2y$12$/Yz//IA1LlV6/aNfUAvLF.3WsPG/ioEWuaoFpZ1F1Zfx/CBgbdza2', 'users', '[]', '[\"password\",\"refresh_token\"]', 0, '2025-06-13 11:59:01', '2025-06-13 11:59:01')");
    }
}
