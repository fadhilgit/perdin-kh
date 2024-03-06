<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerdinSubSubjectImage extends Model
{
    protected $fillable = [
        'perdin_sub_subject_discussion_id',
        'image_name'
    ];

    function perdin_sub_subject_discussion() {
        return $this->hasOne(PerdinSubSubjectDiscussion::class);
    }
}
