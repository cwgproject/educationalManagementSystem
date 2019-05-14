<?php
namespace app\course\controller;

use app\course\model\Course as CourseModel;


class Course 
{
    public function form()
    {
        $list = CourseModel::paginate(5);
        return view('form',['list'=>$list]);
    }
}