<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subunitkerja extends Model
{
    protected $fillable = [
        'name',
        'description',
        'unitkerja_id'
    ];

    function unitkerja()
    {
        return $this->belongsTo(Unitkerja::class);
    }

    function users()
    {
        return $this->hasMany(User::class, 'subunitkerja_id');
    }
}
