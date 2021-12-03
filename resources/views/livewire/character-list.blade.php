<div>
    <h1 class="mb-5 font-extrabold text-2xl">Characters</h1>
    @foreach ($characters as $character)
        <x-character-card :character="$character" />
    @endforeach

    <div x-data="{ show: false }">
        <div @click="show = !show" class='bg-gray-600 p-5 font-extrabold'>
            Create Character
        </div>
        <div x-show="show" class="bg-gray-600 p-5 pt-2">
            <div class="flex items-center">
                <input id="name" name="name" type="text" wire:model="newCharacterName" value=placeholder="Character Name" class='w-full mr-5 bg-black text-white'/>
                <button wire:click="createCharacter()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
