<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $fillable = [
        "id", // <-- ADD "id" HERE
        "name", "type", "type2", "height", "weight", "hp", "attack", "defense", 
        "speed", "special-attack", "special-defense", "official_artwork"
    ];
}