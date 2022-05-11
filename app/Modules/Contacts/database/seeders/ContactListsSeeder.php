<?php

namespace App\Modules\Contacts\database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ContactListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->lists()->create([
                'contact_list_name' => 'Default List',
                'contact_list_description' => 'Default List Of Every User'
            ]);
        }
    }
}
