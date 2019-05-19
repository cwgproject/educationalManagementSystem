<?php
namespace app\teacher\controller;
use app\teacher\model\Teacher as TeacherModel;
use think\Controller;
use think\Db;
use think\facade\Cookie;

class person extends Controller
{
    public function person()
    {
        $id=Cookie::get('tea_id');
        $list = TeacherModel::where('tea_id',$id)->find();
        
        
        // $list = Db::table('un_teacher')
        // ->field('tea_id,tea_name,tea_rollno,tea_title,tea_desc,tea_photo')
        // ->where('tea_id', $id)
        // ->find();
        $this->assign("tea",$list);
        return $this->fetch();
    }
}
