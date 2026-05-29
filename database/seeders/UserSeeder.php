<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🛡️ HANYA ADMIN UTAMA YANG DI-SEEDER
        User::create([
            'username' => 'admin_mahameru',
            'name'     => 'Admin Utama Mahameru',
            'email'    => 'admin@mahameru.com',
            'password' => Hash::make('admin123'), // Password masuk admin
            'role'     => 'admin',
        ]);
    }
}
