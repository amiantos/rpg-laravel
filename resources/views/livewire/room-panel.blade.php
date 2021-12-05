<div>
    <h1>Room #{{$room->id}}</h1>
    <div>
        {{ $room->description }}
    </div>
    <div>
        {{ $room->x }},{{ $room->y }}
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
</div>
