<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    public function room() {
        return $this->hasOne(Room::class, 'id', 'current_room_id');
    }

    public function user() {
        return $this->hasOne(User::class);
    }
}
