<?php
namespace app\course\model;

use think\Model;

class Major extends Model
{
    protected $table = 'un_major';

    public function Course()
    {
        return $this->hasMany("Course", "major_id", "major_id");

    }

}


