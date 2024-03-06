<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerdinSubSubjectDiscussion extends Model
{
    protected $fillable = [
        'perdin_subject_discussion_id',
        'subject_discussion',
        'followup_plan',
        'user_executor',
        'completion_target',
        'image_name'
    ];


    function perdin_subject_discussion() {
        return $this->hasOne(PerdinSubjectDiscussion::class);
    }
}
