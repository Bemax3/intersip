<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_first_name' => 'Massamba',
            'user_middle_name' => null,
            'user_last_name' => 'Niang',
            'user_user_name' => 'bemax3',
            'user_mail' => 'bemax2.ng@gmail.com',
            'user_number' => '00221781791781',
            'user_dob' => Carbon::create('1998','09','16'),
            'user_adress'=> 'Hann Mariste',
            'country_id' => 195,
            'password' => Hash::make('password'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
