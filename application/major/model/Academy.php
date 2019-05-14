<?php
namespace app\major\model;

use think\Model;

class Academy extends Model
{
    protected $table = 'unacademy';

    public function Major()
    {
        return $this->hasMany("Major", "academy_id", "academy_id");

    }

}


