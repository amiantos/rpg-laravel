<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Room;
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
        // Character::factory(10)->create();
        // $my_characters = Character::factory(5)->create(["user_id" => $me]);

        // foreach ($my_characters as $my_character) {
        //     $room = Room::factory()->create([
        //         "user_id" => $me->id,
        //         "character_id" => $my_character->id,
        //     ]);
        //     $my_character->current_room_id = $room->id;
        //     $my_character->save();
        // }

        
    }
}
