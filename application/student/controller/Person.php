<?php
namespace app\student\controller;
use think\Controller;
use think\Db;

class person extends Controller
{
    public function person($stu_id=null)
    {
        $list = Db::table('unstudent')
        ->field('stu_name,stu_rollno,stu_sex,stu_birth,stu_address')
        ->where('stu_id', "$stu_id")
        ->find();
        $this->assign("stu",$list);
        return $this->fetch();
    }
}
