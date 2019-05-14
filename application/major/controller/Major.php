<?php
namespace app\major\controller;

use app\major\model\Major as MajorModel;


class Major 
{
    public function form()
    {
        $list = MajorModel::paginate(5);
        return view('form',['list'=>$list]);
    }
}