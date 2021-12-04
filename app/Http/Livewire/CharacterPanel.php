<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CharacterPanel extends Component
{

    public $character;

    protected $listeners = ['characterUpdated' => 'refreshCharacter'];

    public function render()
    {
        return view('livewire.character-panel');
    }

    public function refreshCharacter() {
        $this->character->refresh();
    }
}
