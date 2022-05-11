<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'role_code' => 'root',
                'role_name' => 'root',
                'role_description' => 'Root Privileges',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'role_code' => 'admin',
                'role_name' => 'admin',
                'role_description' => 'Admin Privileges',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ]
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }


    }
}
