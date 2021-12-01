<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\User;
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
        $me = User::create([
            'name' => 'amiantos',
            'email' => 'bradroot@me.com',
            'password' => bcrypt('password')
        ]);
        Character::factory(10)->create();
        Character::factory(5)->create(["user_id" => $me]);
    }
}
