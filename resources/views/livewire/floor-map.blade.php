<div>
    @php
        $room_coords = [
            "00",
            "10",
            "20",
            "30",
            "40",
            "50",
            "60",

            "01",
            "11",
            "21",
            "31",
            "41",
            "51",
            "61",

            "02",
            "12",
            "22",
            "32",
            "42",
            "52",
            "62",

            "03",
            "13",
            "23",
            "33",
            "43",
            "53",
            "63",

            "04",
            "14",
            "24",
            "34",
            "44",
            "54",
            "64",

            "05",
            "15",
            "25",
            "35",
            "45",
            "55",
            "65",

            "06",
            "16",
            "26",
            "36",
            "46",
            "56",
            "66",
        ];
        $rooms = [];
        $current_coord = strval($current_room->x) . strval($current_room->y);

        foreach ($all_rooms as $room) {
            $rooms[strval($room->x) . strval($room->y)] = $room;
        }
    @endphp
    <div class="grid grid-cols-7 gap-0 relative float-right border-2 border-black">
        @foreach ($room_coords as $coord)
            <div class='flex w-5 h-5 border-black 
            @if ($coord == $current_coord)
                bg-red-500
            @endif
            @if ($rooms[$coord]->visited)
                bg-gray-500 
                @if (is_null($rooms[$coord]->north))
                    border-t
                @endif
                @if (is_null($rooms[$coord]->south))
                    border-b
                @endif
                @if (is_null($rooms[$coord]->east))
                    border-r
                @endif
                @if (is_null($rooms[$coord]->west))
                    border-l
                @endif
            @else
                bg-gray-400 
            @endif
            '></div>
        @endforeach
    </div>
</div>
