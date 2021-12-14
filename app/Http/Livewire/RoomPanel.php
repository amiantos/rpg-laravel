<?php

namespace App\Http\Livewire;

use App\Models\Chest;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Weapon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RoomPanel extends Component
{
    public $room;

    public function render()
    {
        return view('livewire.room-panel');
    }

    public function changeRoom($id) {
        $character = $this->room->character;
        $character->room_id = $id;
        $character->save();

        $next_room = Room::findOrFail($id);
        if (!$next_room->visited) {
            // Are there any other unvisited rooms?
            $unvisited_rooms = Room::where('character_id', $character->id)->where('z', $next_room->z)->where('visited', False)->get();
            if (count($unvisited_rooms) <= 4) {
                $floor = Floor::where('character_id', $character->id)->where('z', $next_room->z+1)->first();
                if (is_null($floor)) {
                    $stair_room = $unvisited_rooms->random();
                    $floor = new Floor();
                    $floor->character_id = $character->id;
                    $floor->user_id = $character->user_id;
                    $floor->z = $stair_room->z+1;
                    $floor->save();

                    $floor->generate($stair_room->x,$stair_room->y,$floor->z);
                    $stair_room->below = $floor->first_room->id;
                    $floor->first_room->above = $stair_room->id;
                    $floor->first_room->save();
                    $stair_room->save();
                }
            }
            $next_room->visited = True;
            $next_room->save();
            $next_room->refresh();
        }

        $this->room = $next_room;

        $this->emit('roomChanged', $next_room->id);
    }

    public function openChest($id) {
        $chest = Chest::findOrFail($id);

        if ($chest->type == "entry") {
            for ($i = 1; $i <= 3; $i++) {
                $new_weapon = new Weapon;
                $new_weapon->character_id = $chest->character_id;
                $new_weapon->user_id = $chest->user_id;
                
                $new_weapon->in_room_id = $chest->room_id;

                $new_weapon->generate(1);
                $new_weapon->save();
            }
        } else {
            // Do basic chest things
        }

        $chest->delete();

        $this->room->refresh();
    }
}
