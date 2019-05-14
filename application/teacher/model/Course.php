<?php
namespace app\teacher\model;

use think\Model;

class Course extends Model
{
    protected $table = 'uncourse';

    public function Teacher()
    {
        return $this->hasMany("Teacher", "course_id", "course_id");

    }

}


