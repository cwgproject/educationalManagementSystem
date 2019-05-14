<?php
namespace app\teacher\model;

use think\Model;

class Teacher extends Model
{
    protected $table = 'unteacher';

    public function Course()
    {
        return $this->belongsTo("Course", "course_id", "course_id");

    }

    public function Academy()
    {
        return $this->belongsTo("Academy", "academy_id", "academy_id");

    }
}


