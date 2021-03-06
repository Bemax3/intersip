<?php

namespace App\Modules\Contacts\database\seeders;

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
            ContactListsSeeder::class
        ]);
    }
}
