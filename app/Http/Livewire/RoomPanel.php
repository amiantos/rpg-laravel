<?php

namespace App\Http\Livewire;

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
            $next_room->visited = True;
            $next_room->save();
        }

        $this->room = $next_room;

        $this->emit('roomChanged', $next_room->id);
    }
}
