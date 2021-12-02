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
        Exp {{ $character->experience }}/{{ $character->experience_to_next_level }}
    </div>
    <div>
        <a href="{{route('play', $character->id)}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Play
        </a>
    </div>
    <div>
        <form method="POST" action="{{url('character-destroy', $character->id)}}">
            @method('DELETE')
            @csrf
            <div class="flex items-center">
                <button onclick="return confirm('Delete entry?')" type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>