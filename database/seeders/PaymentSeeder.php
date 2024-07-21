<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            'id' => 1,
            'name' => 'Dana',
            'logo' => 'dana.png',
            'account_number' => '083818062960',
            'created_at' => Carbon::now(),
        ]);

        DB::table('payment_methods')->insert([
            'id' => 2,
            'name' => 'Gopay',
            'logo' => 'gopay.png',
            'account_number' => '083818062960',
            'created_at' => Carbon::now(),
        ]);

        DB::table('payment_methods')->insert([
            'id' => 3,
            'name' => 'BCA',
            'logo' => 'bca.png',
            'account_number' => '083818062960',
            'created_at' => Carbon::now(),
        ]);

        DB::table('payment_methods')->insert([
            'id' => 4,
            'name' => 'BRI',
            'logo' => 'bri.png',
            'account_number' => '083818062960',
            'created_at' => Carbon::now(),
        ]);
    }
}
