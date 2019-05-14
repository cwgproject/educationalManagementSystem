<?php
namespace app\major\model;

use think\Model;

class Major extends Model
{
    protected $table = 'unmajor';

    public function Academy()
    {
        return $this->belongsTo("Academy", "academy_id", "academy_id");
    }
}


