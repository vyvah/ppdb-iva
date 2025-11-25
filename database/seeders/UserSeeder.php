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
            'email' => '@gmausersatuil.com',
            'password' => Hash::make('password123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Admin Satu',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
