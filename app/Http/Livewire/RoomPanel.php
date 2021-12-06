<?php

namespace App\Http\Livewire;

use App\Models\Floor;
use App\Models\Room;
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
            $unvisited_room_count = Room::where('z', $next_room->z)->where('character_id', $character->id)->where('visited', False)->count();
            if ($unvisited_room_count == 1) {
                $floor = new Floor();
                $floor->character_id = $character->id;
                $floor->user_id = $character->user_id;
                $floor->z = $next_room->z+1;
                $floor->save();

                $floor->generate($next_room->x,$next_room->y,$floor->z);
                $next_room->below = $floor->first_room->id;
                $floor->first_room->above = $next_room->id;
                $floor->first_room->save();
            }
            $next_room->visited = True;
            $next_room->save();
        }

        $this->room = $next_room;

        $this->emit('roomChanged', $next_room->id);
    }
}
