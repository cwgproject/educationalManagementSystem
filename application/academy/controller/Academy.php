<?php
namespace app\academy\controller;

use app\academy\model\Academy as AcademyModel;


class Academy 
{
    public function form()
    {
        $list = AcademyModel::paginate(5);
        return view('form',['list'=>$list]);
    } 
}