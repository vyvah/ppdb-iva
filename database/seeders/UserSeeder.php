<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // default role user
        DB::table('users')->insert([
            'name' => 'User Satu',
            'email' => 'usersatu@gmail.com', // email diperbaiki agar valid
            'role' => 'user',                // tambahkan role jika kolom ini wajib
            'password' => Hash::make('password123'),
        ]);

        // default admin
        DB::table('users')->insert([
            'name' => 'Admin Satu',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
