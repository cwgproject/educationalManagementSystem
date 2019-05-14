<?php
namespace app\student\model;

use think\Model;

class Academy extends Model
{
    protected $table = 'unacademy';

    public function Student() {

        return $this->hasMany('Student','academy_id','academy_id');

    }
}
