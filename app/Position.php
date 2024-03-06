<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name'
    ];


    function users() {
        return $this->hasMany(Position::class);
    }
}
