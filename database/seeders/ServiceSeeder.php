<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_services')->insert([
            'id' => 1,
            'name' => 'Software Development',
            'images' => 'images/0ba819fa-a8db-4585-9b24-cda39d22de14.jpg',
            'kode' => 1,
            'created_at' => Carbon::now(),
        ]);

        DB::table('category_services')->insert([
            'id' => 2,
            'name' => 'Digital Marketing',
            'images' => 'images/0ba819fa-a8db-4585-9b24-cda39d22de14.jpg',
            'kode' => 2,
            'created_at' => Carbon::now(),
        ]);
    }
}
