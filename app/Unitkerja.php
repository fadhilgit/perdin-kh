<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unitkerja extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    function subunitkerja()
    {
        return $this->hasMany(Subunitkerja::class);
    }

    function users()
    {
        return $this->hasMany(User::class, 'unitkerja_id');
    }
}
