<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user (avoids duplicates if run multiple times)
        if (!Admin::where('username', 'admin')->exists()) {
            Admin::create([
                'nama_admin' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('admin'), // Change in production!
                // id_admin is auto-incremented
            ]);
        }
    }
}
