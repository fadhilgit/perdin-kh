<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerdinSubjectDiscussion extends Model
{
    protected $fillable = [
        'perdin_id',
        'subject_discussion',
        'followup_plan',
        'user_executor',
        'completion_target',
        'image_name'
    ];


    function perdin() {
        return $this->hasOne(Perdin::class);
    }

    function perdinSubSubjectDiscussion()
    {
        return $this->hasMany(PerdinSubSubjectDiscussion::class, 'perdin_subject_discussion_id');
    }

    function perdinSubjectImages() {
        return $this->hasMany(PerdinSubjectImage::class);
    }
}
