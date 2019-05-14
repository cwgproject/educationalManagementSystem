<?php
namespace app\student\controller;

use app\student\model\Student as StudentModel;
use think\Controller;

class Student 
{

    public function form()
    {
        $list = StudentModel::paginate(5);
        return view('form',['list'=>$list]);
    }



}