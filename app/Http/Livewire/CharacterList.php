<?php

namespace App\Http\Livewire;

use App\Models\Character;
use Illuminate\Http\Request;
use Livewire\Component;

class CharacterList extends Component
{
    public $characters;
    public $newCharacterName = "";

    public function render()
    {
        return view('livewire.character-list');
    }

    public function createCharacter(Request $request) {
        $user = $request->user();
        $character = new Character;
        $character->name = $this->newCharacterName;
        $character->user_id = $user->id;
        $character->save();
        
        $this->characters = $user->characters;
        $this->newCharacterName = "";
    }
}
