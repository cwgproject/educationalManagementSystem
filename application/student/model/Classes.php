<?php
namespace app\student\model;

use think\Model;

class Classes extends Model
{
    protected $table = 'un_class';

    public function Student() {

        return $this->hasMany('Student','class_id','class_id');

    }
}
