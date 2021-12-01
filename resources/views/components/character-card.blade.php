@props(['character'])

<div class="bg-gray-300 p-3 rounded-lg shadow-lg mb-5 flex justify-between">
    <div>{{ $character->name }}</div>
    <div class="text-gray-500 text-right">
        Level {{ $character->level }}
    </div>
    <div>
        Health {{ $character->health }}/{{ $character->max_health }}
    </div>
    <div>
        Exp {{ $character->experience_to_next_level }}/{{ $character->experience }}
    </div>
</div>