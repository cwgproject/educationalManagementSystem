<?php
namespace app\teacher\model;

use think\Model;

class Academy extends Model
{
    protected $table = 'unacademy';

    public function Teacher()
    {
        return $this->hasMany("Teacher", "academy_id", "academy_id");

    }

}


