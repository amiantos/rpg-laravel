<?php

namespace App\Http\Livewire;

use App\Models\Room;
use Livewire\Component;

class FloorMap extends Component
{
    public $all_rooms;
    public $current_room;

    protected $listeners = ['roomChanged' => 'roomChanged'];

    public function render()
    {
        return view('livewire.floor-map');
    }

    public function roomChanged(Room $room) {
        $this->current_room = $room;
        $this->all_rooms = Room::where('character_id', $room->character_id)->where('z', $room->z)->get();
    }
}
