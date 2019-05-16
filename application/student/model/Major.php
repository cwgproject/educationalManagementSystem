<?php
namespace app\student\model;

use think\Model;

class Major extends Model
{
    protected $table = 'un_major';

    public function Student() {

        return $this->hasMany('Student','major_id','major_id');

    }
}
