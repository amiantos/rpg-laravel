<div>
    <h1>Room #{{$room->id}}</h1>
    <div>
        {{ $room->description }}
    </div>

    @php
    $weapon_count = $room->weapons->count();
    @endphp
    @if ($weapon_count > 0)
    <div>
        {{ $weapon_count >= 3 ? "In a pile on the floor, you see a " : "There's a " }}
        @foreach ($room->weapons as $weapon)
            {{$loop->last && $loop-> count > 1 ? ' and a ' : '' }}<button wire:click="fetchWeapon({{$weapon->id}})">{{ $weapon->name }}</button> [{{$weapon->damage}}/{{$weapon->durability}}/{{$weapon->weight}}]{{ !$loop->last ? ',' : '' }}
        @endforeach
        {{ $weapon_count >= 3 ? "." : ($weapon_count >= 2 ? "on the floor." : "lying on the floor.") }}
    </div>
    @endif

    <div>
    @foreach ($room->chests as $chest)
        <P>There is a {{ $chest->name }} here. <button wire:click="openChest({{$chest->id}})">Open it?</button>
    @endforeach
    </div>

    @if ($room->north)
        <button wire:click="changeRoom({{$room->north}})">North</button>
    @endif

    @if ($room->south)
        <button wire:click="changeRoom({{$room->south}})">South</button>
    @endif

    @if ($room->east)
        <button wire:click="changeRoom({{$room->east}})">East</button>
    @endif

    @if ($room->west)
        <button wire:click="changeRoom({{$room->west}})">West</button>
    @endif

    @if ($room->below)
        <button wire:click="changeRoom({{$room->below}})">Stairs Down</button>
    @endif

    @if ($room->above)
        <button wire:click="changeRoom({{$room->above}})">Stairs Up</button>
    @endif
</div>
