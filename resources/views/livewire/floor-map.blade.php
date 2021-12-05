<div>
    @php
        $room_coords = [
            "2-2",
            "2-1",
            "20",
            "21",
            "22",

            "1-2",
            "1-1",
            "10",
            "11",
            "12",

            "0-2",
            "0-1",
            "00",
            "01",
            "02",

            "-1-2",
            "-1-1",
            "-10",
            "-11",
            "-12",

            "-2-2",
            "-2-1",
            "-20",
            "-21",
            "-22",
        ];
        $rooms = [];
        $current_coord = strval($current_room->x) . strval($current_room->y)
    @endphp

    @foreach ($all_rooms as $room)
    
        {{ $rooms[] = strval($room->x) . strval($room->y) }}
        
    @endforeach

    @foreach ($rooms as $room_num)
        {{$room_num}}
    @endforeach

    <div class="grid grid-cols-5 w-25 h-25 gap-1 relative float-right">
        @foreach ($room_coords as $coord)
            <div class='flex w-5 h-5
            @if ($coord == $current_coord)
                bg-red-500
            @elseif (in_array($coord, $rooms))
                bg-black
            @endif
            '></div>
        @endforeach
    </div>
</div>
