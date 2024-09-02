<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Wibi Prasetia S.T',
            'email' => 'admin@admin.com',
            'phone' => '+6283818062960',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'role' => 1, // Admin Sistem
            'avatar' => '',
            'status' => 1, // active
            'created_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Rosmawati',
            'email' => 'marketing@admin.com',
            'phone' => '+6283818062960',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'role' => 2, // Admin Sistem
            'avatar' => '',
            'status' => 1, // active
            'created_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'name' => 'Luthfi Baehaqi',
            'email' => 'pelanggan@admin.com',
            'phone' => '+6283818062960',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'role' => 3, // Admin Sistem
            'avatar' => '',
            'status' => 1, // active
            'created_at' => Carbon::now(),
        ]);
    }
}
