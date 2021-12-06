<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    public function floors() {
        return $this->hasMany(Floor::class);
    }

    public function first_room() {
        return $this->hasOne(Room::class, 'id', 'room_id');
    }

    public function generate($start_x, $start_y, $z) {
        $maze_size = 4;
        $maze = $this->generateMaze($maze_size);

        $rooms = [];
        for ($x=0; $x < $maze_size; $x++) {
            for ($y=0; $y < $maze_size; $y++) {
                $new_room = new Room;
                $new_room->z = $z;
                $new_room->x = $x;
                $new_room->y = $y;
                $new_room->description = $new_room->createDescription();
                $new_room->character_id = $this->character_id;
                $new_room->user_id = $this->user_id;
                $new_room->floor_id = $this->id;
                $new_room->save();

                $rooms[$x][$y] = $new_room;
            }
        }

        $this->room_id = $rooms[$start_x][$start_y]->id;

        $this->save();

        for ($x=0; $x < $maze_size; $x++) {
            for ($y=0; $y < $maze_size; $y++) {
                $maze_room = $maze[$x][$y];
                $floor_room = $rooms[$x][$y];

                if ($maze_room['walls_types']['up'] == 0) {
                    $floor_room->north = $rooms[$x][$y-1]->id;
                }

                if ($maze_room['walls_types']['down'] == 0) {
                    $floor_room->south = $rooms[$x][$y+1]->id;
                }

                if ($maze_room['walls_types']['right'] == 0) {
                    $floor_room->east = $rooms[$x+1][$y]->id;
                }

                if ($maze_room['walls_types']['left'] == 0) {
                    $floor_room->west = $rooms[$x-1][$y]->id;
                }

                $floor_room->save();
            }
        }

    }

    private function generateMaze($maze_size) {
        // Stolen from https://github.com/Pacjonek/maze-generator/blob/master/index.php

        $maze_width = $maze_size;
        $maze_height = $maze_size;
        $types_of_squares = 1;
        $types_of_walls = 1;
        
        $maze = [];
        for($x = 0; $x < $maze_width; $x++){
            for($y = 0; $y < $maze_height; $y++) {
                $maze[$x][$y] = [
                    'square_type' => rand(0, $types_of_squares - 1), 
                    'walls_types'=>[
                        'up' => rand(1, $types_of_walls),
                        'right' => rand(1, $types_of_walls),
                        'down' => rand(1, $types_of_walls),
                        'left' => rand(1, $types_of_walls)
                    ],
                    'visited' => false
                ];
            };
        }
        
        $x_history = [];
        $y_history = [];
        $x_next = -1;
        $y_next = -1;
        $x = rand(0,$maze_width - 1);
        $y = rand(0,$maze_height - 1);
        $maze_size = $maze_width * $maze_height;
        
        $visited_rows = 0;
        $backtrack_steps = 0;
        while($visited_rows < $maze_size){
            $available_directions = [];
            if($y - 1 >= 0 && !$maze[$x][$y - 1]['visited']) array_push($available_directions, 'up');
            if($x + 1  < $maze_width && !$maze[$x + 1][$y]['visited']) array_push($available_directions, 'right');
            if($y + 1  < $maze_height && !$maze[$x][$y + 1]['visited']) array_push($available_directions, 'down');
            if($x - 1 >= 0 && !$maze[$x - 1][$y]['visited']) array_push($available_directions, 'left');
        
            $count_available_directions = count($available_directions);
            if($maze[$x][$y]['visited'] === false) $visited_rows++;
            $maze[$x][$y]['visited'] = true;
            if($count_available_directions === 0){
                $x = $x_history[count($x_history) - 1 - $backtrack_steps];
                $y = $y_history[count($y_history) - 1 - $backtrack_steps];
                $backtrack_steps ++;
                continue;
            } else $backtrack_steps = 0;
            
            $decision = $available_directions[rand(0, count($available_directions) - 1)];
            if($decision === 'up'){
                $x_next = $x;
                $y_next = $y - 1;
                $maze[$x][$y]['walls_types']['up'] = 0;
                $maze[$x_next][$y_next]['walls_types']['down'] = 0;
            }
            elseif($decision === 'right'){
                $x_next = $x + 1;
                $y_next = $y;
                $maze[$x][$y]['walls_types']['right'] = 0;
                $maze[$x_next][$y_next]['walls_types']['left'] = 0;
            }
            elseif($decision === 'down'){
                $x_next = $x;
                $y_next = $y + 1;
                $maze[$x][$y]['walls_types']['down'] = 0;
                $maze[ $x_next][$y_next]['walls_types']['up'] = 0;
            }
            elseif($decision === 'left'){
                $x_next = $x - 1;
                $y_next = $y;
                $maze[$x][$y]['walls_types']['left'] = 0;
                $maze[$x_next][$y_next]['walls_types']['right'] = 0;
            }
            array_push($x_history,$x);
            array_push($y_history,$y);
            $x = $x_next;
            $y = $y_next;
        }
        $squares = [];
        for($x = 0;$x < $maze_width; $x++){
            for($y = 0;$y < $maze_height; $y++){
                array_push($squares, ['type' =>$maze[$x][$y]['square_type'], 'walls' => [
                    $maze[$x][$y]['walls_types']['up'],
                    $maze[$x][$y]['walls_types']['right'],
                    $maze[$x][$y]['walls_types']['down'],
                    $maze[$x][$y]['walls_types']['left']
                ]]);
            }
        }

        return $maze;
    }

}
