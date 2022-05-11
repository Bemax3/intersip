<?php

namespace Database\Seeders;

use App\Modules\Contacts\database\seeders\ContactListsSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            TimezonesSeeder::class,
            SettingProductsSeeder::class,
            UsersSeeder::class,
            ContactListsSeeder::class
        ]);

    }
}
