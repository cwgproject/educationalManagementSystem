<?php
namespace app\course\model;

use think\Model;

class Course extends Model
{
    protected $table = 'un_course';

    public function Major()
    {
        return $this->belongsTo("Major", "major_id", "major_id");

    }
}


