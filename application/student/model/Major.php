<?php
namespace app\student\model;

use think\Model;

class Major extends Model
{
    protected $table = 'unmajor';

    public function Student() {

        return $this->hasMany('Student','major_id','major_id');

    }
}
