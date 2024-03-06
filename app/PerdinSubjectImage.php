<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerdinSubjectImage extends Model
{
    protected $fillable = [
        'perdin_subject_discussion_id',
        'image_name'
    ];

    function perdinSubjectDiscussion() {
        return $this->hasOne(PerdinSubjectDiscussion::class);
    }


}
