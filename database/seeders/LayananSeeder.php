<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            'id' => 1,
            'category_id' => 1,
            'name' => 'Landing Page',
            'description' => 'Test',
            'price' => 2000000,
            'created_at' => Carbon::now(),
        ]);

        DB::table('services')->insert([
            'id' => 2,
            'category_id' => 2,
            'name' => 'Kelola Sosial Media',
            'description' => 'Test',
            'price' => 1000000,
            'created_at' => Carbon::now(),
        ]);
    }
}
