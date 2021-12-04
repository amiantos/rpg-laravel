<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $attributes = [
        'x' => 0,
        'y' => 0,
        'z' => 1,
    ];

    public function character() {
        return $this->hasOne(Character::class, 'current_room_id');
    }

    public function user() {
        return $this->hasOne(User::class);
    }

    public function populate($user, $character) {
        if ($this->filled) {
            return;
        }

        $direction_diffs = [
            "north" => [1, 0],
            "south" => [-1, 0],
            "east" => [0, 1],
            "west" => [0, -1]
        ];

        // Find Existing Connecting Rooms
        $directions_to_generate = ["north", "south", "east", "west"];
        foreach ($directions_to_generate as $direction) {
            // Don't generate rooms for directions that have rooms already
            if (
                ($direction == "north" && !is_null($this->north)) ||
                ($direction == "south" && !is_null($this->south)) ||
                ($direction == "east" && !is_null($this->east)) ||
                ($direction == "west" && !is_null($this->west))
                ) {
                continue;
            }


            // Search out for existing rooms at room destinations
            $x_to_search = $this->x + $direction_diffs[$direction][0];
            $y_to_search = $this->y + $direction_diffs[$direction][1];

            $new_room = Room::where('x', $x_to_search)->where('y', $y_to_search)->where('z', $this->z)->where('character_id', $this->character->id)->first();

            if (is_null($new_room)) {
                continue;
            }

            switch ($direction) {
                case "north":
                    $this->north = $new_room->id;
                    $new_room->south = $this->id;
                    break;
                case "south":
                    $this->south = $new_room->id;
                    $new_room->north = $this->id;
                    break;
                case "east":
                    $this->east = $new_room->id;
                    $new_room->west = $this->id;
                    break;
                case "west":
                    $this->west = $new_room->id;
                    $new_room->east = $this->id;
                    break;
            }

            $new_room->save();
           
        }

        $room_count = Room::where('z', $this->z)->where('character_id', $this->character->id)->count();
        if ($room_count >= 10) {
            $directions_to_generate = [];
        } else {
            // Generate more rooms if needed?
            $number_of_exits = rand(2, 4);

            $exits_to_go = $room_count - 10;
            $number_of_exits = $exits_to_go > $number_of_exits ? $exits_to_go : $number_of_exits;
            
            if (!is_null($this->north)) { 
                unset($directions_to_generate[0]);
                --$number_of_exits;
            }
            if (!is_null($this->south)) { 
                unset($directions_to_generate[1]);
                --$number_of_exits;
            }
            if (!is_null($this->east)) { 
                unset($directions_to_generate[2]);
                --$number_of_exits;
            }
            if (!is_null($this->west)) { 
                unset($directions_to_generate[3]);
                --$number_of_exits;
            }

            if ($number_of_exits < 1) {
                $directions_to_generate = [];
            } else {
                while (count($directions_to_generate) > $number_of_exits) {
                    unset($directions_to_generate[array_rand($directions_to_generate)]);
                }
            }
        }

        // Generate new rooms if needed
        foreach ($directions_to_generate as $direction) {
            $new_room = new Room;
            $new_room->description = "This is an auto-generated off-shoot room.";
            $new_room->z = $this->z;
            $new_room->x = $this->x + $direction_diffs[$direction][0];
            $new_room->y = $this->y + $direction_diffs[$direction][1];
            $new_room->character_id = $character->id;
            $new_room->user_id = $user->id;
            $new_room->save();

            switch ($direction) {
                case "north":
                    $this->north = $new_room->id;
                    $new_room->south = $this->id;
                    break;
                case "south":
                    $this->south = $new_room->id;
                    $new_room->north = $this->id;
                    break;
                case "east":
                    $this->east = $new_room->id;
                    $new_room->west = $this->id;
                    break;
                case "west":
                    $this->west = $new_room->id;
                    $new_room->east = $this->id;
                    break;
            }

            $new_room->save();
           
        }

        $this->filled = True;
        $this->description = $this->createDescription();
        $this->save();
    }

    public function createDescription() {
        /* Introductory Statement On Room */
        $what = rand(1, 3);
        if ($what == 1) { $intro = "The air here is hot, and you can feel it in your lungs; whatever it is floating in the air, it is inside you. ";}
        if ($what == 2) { $intro = "You see your breath in the air before you even have a chance to shiver. You try rubbing the cold out of your arms, but it's already cut you to the bone. ";}
        if ($what == 3) { $intro = "This room is filled with a thick cloud of swirling sand, being pushed by a wind you can't find the source of. You have to put a cloth over your mouth to breathe, and squint at your surroundings through pinched fingers. ";}

        /* On The Floors */
        $what = rand(0, 3);
        if ($what == 0) { $floor = "The ground under your feet feels moist and sticky. You think that falling down here would turn into a messy ordeal. ";}
        if ($what == 1) { $floor = "With every step you take, cockroaches crunch under your feet; countless others race away into the dark corners. ";}
        if ($what == 2) { $floor = "If you stand in place too long, the sand all over the floor begins to swallow your feet. If you keep moving, you should be fine. ";}
        if ($what == 3) { $floor = "The ground under your feet is slick with a clear substance. It glistens in what little light there is. It appears to be the trails of several giant snails, but how they came into, and slipped out of, the room isn't apparent to you.";}

        /* On The Walls */
        $what = rand(0, 3);
        if ($what == 0) { $wall = "Adorning the walls of this room are enormous engravings, depicting the fallen heroes of civilizations long forgotten. ";}
        if ($what == 1) { $wall = "Hanging on one of the walls of this room is large painting of a horse. The horse is screaming. ";}
        if ($what == 2) { $wall = "The walls of this room are covered in a beautiful mosaic. The tiles of turquoise, amethyst, and quartz form an elaborate scene of a bustling market place in the city, which stands in sharp contrast to the desolation around you. When you look closer, however, you see that the wears on display in the market are actually desiccated pieces of dismembered corpses.  ";}
        if ($what == 3) { $wall = "Before you, large blood red tapestries hang from the walls, adorned with a strange crest you've never seen before. ";}

        /* Over Your Head */
        $what = rand(0, 3);
        if ($what == 0) { $head = "Suspended over your head by chains, the bodies of the long dead and forgotten sway, as if jostled by someone else who was here just before you. ";}
        if ($what == 1) { $head = "At first you think the ceiling is pulsating, but you realize that it is home to hundreds of bats. You decide it's best not to disturb them. ";}
        if ($what == 2) { $head = "From above you can hear the sound of something slowly chewing on something else, but the ceiling is too high and all you can see is darkness. Whatever it is making that sound, you hope it's friendly, or at least totally distracted already. ";}
        if ($what == 3) { $head = "The sound of chains clinking together fills the chamber as you move through it, pushing away the variety of hooks hanging down from above. ";}

        /* Special Mythical Features */
        $what = rand(0, 3);
        if ($what == 0) { $special = "Coming from a hole in the base of one of the walls, a small stream cuts its way through the center of this room. The pebbles at the bottom of the stream have been worn smooth by decades of tumbling water. ";}
        if ($what == 1) { $special = "Though you can't fathom why, a small crack in the ceiling exposes a little of what must be sunlight. You can feel the warmth of it on your face; taking a moment to enjoy it, you remember something you had forgotten long ago. ";}
        if ($what == 2) { $special = "You only saw it for a moment when you entered, but you swear there was a faery hovering in the middle of the room, only to vanish into a crack in the wall when it noticed you come in. ";}
        if ($what == 3) { $special = "A stream of water falls from a hole in the ceiling and into a hole in the floor. Both holes are too precise to be natural. Where is this water going? Where is it from? ";}

        $strings = [$intro, $floor, $wall, $head, $special];
        
        return $strings[array_rand($strings)];
    }
}
