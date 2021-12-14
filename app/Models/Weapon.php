<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;

    public function generate($level) {
        // TODO: Randomization
        // $level = $level + rand(-1, 1);
        // $level = $level < 1 ? 1 : $level;

        $this->level = $level;

        $this->damage = 20 + (($level - 1) * 1.5);
        $this->weight = 8 + (($level - 1) * 0.3);
        $this->max_durability = 45 + (($level - 1) * 1);
        $this->durability = $this->max_durability;

        $material_name = "Copper ";
        $this->material = 1;
        $quality_name = "Unbalanced ";
        $this->quality = 1;

        /* Randomly Select Kind of Weapon */
        $rand_number = rand(1,2);
        if ($rand_number == 1) { $weapon_kind = 'Sword'; }
        if ($rand_number == 2) { $weapon_kind = 'Axe'; }

        /* Build Weapon Name */
        $weapon_name = $quality_name.$material_name.$weapon_kind;

        $this->name = $weapon_name;
        $this->short_name = $weapon_kind;
    }
}
