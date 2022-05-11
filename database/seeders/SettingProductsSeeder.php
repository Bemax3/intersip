<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'settings_product_code' => 'cash',
                'settings_product_name' => 'Cash Transfer',
                'settings_product_desc' => 'Cash Transfer Product',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'settings_product_code' => 'airtime',
                'settings_product_name' => 'Airtime Transfer',
                'settings_product_desc' => 'Airtime Transfer Product',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        foreach ($products as $product) {
            DB::table('settings_products')->insert($product);
        }
    }
}
