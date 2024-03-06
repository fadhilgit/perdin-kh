<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerdinRecipient extends Model
{
    protected $fillable = [
        'perdin_id',
        'user_id',
        'is_checked',
    ];

    function perdin()
    {
        return $this->belongsTo(Perdin::class);
    }

    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
