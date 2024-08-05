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
            'name' => 'Pembuatan Website',
            'images' => 'pembuatan_website.jpg',
            'kode' => 1,
            'created_at' => Carbon::now(),
        ]);

        DB::table('category_services')->insert([
            'id' => 2,
            'name' => 'Kelola Sosial Media',
            'images' => 'kelola_sosmed.jpg',
            'kode' => 2,
            'created_at' => Carbon::now(),
        ]);
    }
}
