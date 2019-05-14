<?php
namespace app\student\model;

use think\Model;

class Student extends Model
{
    protected $table = 'unstudent';

    public function Classes()
    {
        return $this->belongsTo("Classes", "class_id", "class_id");

    }

    public function Major()
    {
        return $this->belongsTo("Major", "major_id", "major_id");

    }

    public function Academy()
    {
        return $this->belongsTo("Academy", "academy_id", "academy_id");

    }

}

