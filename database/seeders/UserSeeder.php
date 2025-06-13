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
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('@Admin1_$$')
        ]);

        // Regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('@User1_$$')
        ]);
        
        DB::statement("INSERT INTO `oauth_clients` (`id`, `owner_type`, `owner_id`, `name`, `secret`, `provider`, `redirect_uris`, `grant_types`, `revoked`, `created_at`, `updated_at`) VALUES
            ('019769c8-b92a-7071-a334-fc651301f25e', NULL, 1, 'test2', '$2y$12$4CQG6xJKiizh3r3osaXfIOhwthVCSrwBebdNAlh3MvKlGdYGp6hBG', NULL, '[\"http:\\/\\/localhost\\/auth\\/callback\"]', '[\"authorization_code\",\"refresh_token\",\"urn:ietf:params:oauth:grant-type:device_code\",\"password\"]', 0, '2025-06-13 11:54:11', '2025-06-13 11:54:11')");
        DB::statement("INSERT INTO `oauth_clients` (`id`, `owner_type`, `owner_id`, `name`, `secret`, `provider`, `redirect_uris`, `grant_types`, `revoked`, `created_at`, `updated_at`) VALUES
            ('019769cd-23b5-714b-a6b6-de75f9bf8ede', NULL, 2, 'test3', '$2y$12$/Yz//IA1LlV6/aNfUAvLF.3WsPG/ioEWuaoFpZ1F1Zfx/CBgbdza2', 'users', '[]', '[\"password\",\"refresh_token\"]', 0, '2025-06-13 11:59:01', '2025-06-13 11:59:01')");
    }
}
