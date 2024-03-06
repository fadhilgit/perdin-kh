<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Perdin extends Model
{

    protected $fillable = [
        'id',
        'user_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'project',
        'agenda',
        'place',
        'no_voucher',
        'personel_kwarsa',
        'personel_other',
        'attachment',
        'status'
    ];

    protected $casts = [
        'id' => 'string'
    ];


    function user() {
        return $this->belongsTo(User::class);
    }

    function perdinSubjectDiscussions()
    {
        return $this->hasMany(PerdinSubjectDiscussion::class, 'perdin_id');
    }

    function perdinComment()
    {
        return $this->hasMany(PerdinComment::class, 'perdin_id');
    }
}
