<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timezones = [
            [
                'settings_timezone_name' => 'GMT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'settings_timezone_name' => 'BST',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($timezones as $timezone) {
            DB::table('settings_timezones')->insert($timezone);
        }
    }
}
