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

        // Pembuatan Website
        DB::table('services')->insert([
            'id' => 1,
            'category_id' => 1,
            'name' => 'Landing Page',
            'description' => '-',
            'price' => 649000,
            'created_at' => Carbon::now(),
        ]);
        DB::table('services')->insert([
            'id' => 2,
            'category_id' => 1,
            'name' => 'Professional',
            'description' => '-',
            'price' => 4499000,
            'created_at' => Carbon::now(),
        ]);
        DB::table('services')->insert([
            'id' => 3,
            'category_id' => 1,
            'name' => 'Business',
            'description' => '-',
            'price' => 7499000,
            'created_at' => Carbon::now(),
        ]);

        // Kelola Sosial Media
        DB::table('services')->insert([
            'id' => 4,
            'category_id' => 2,
            'name' => 'Paket Tall',
            'description' => '7 Feeds + 4 Stories + 1 Reels',
            'price' => 500000,
            'created_at' => Carbon::now(),
        ]);
        DB::table('services')->insert([
            'id' => 5,
            'category_id' => 2,
            'name' => 'Paket Grande',
            'description' => '15 Feeds + 6 Stories + 2 Reels',
            'price' => 750000,
            'created_at' => Carbon::now(),
        ]);
        DB::table('services')->insert([
            'id' => 6,
            'category_id' => 2,
            'name' => 'Paket Venti',
            'description' => '30 Feeds + 8 Stories + 4 Reels',
            'price' => 1250000,
            'created_at' => Carbon::now(),
        ]);
    }
}
