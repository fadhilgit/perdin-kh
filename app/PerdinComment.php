<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerdinComment extends Model
{
    protected $fillable = [
        'comment_id',
        'perdin_id',
        'user_id',
        'comment',
        'rule'
    ];

    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    function perdin()
    {
        return $this->hasOne(Perdin::class);
    }
}
