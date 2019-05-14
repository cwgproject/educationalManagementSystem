<?php
namespace app\teacher\controller;

use app\teacher\model\Teacher as TeacherModel;


class Teacher 
{
    public function form()
    {
        $list = TeacherModel::paginate(5);
        return view('form',['list'=>$list]);
    }
}