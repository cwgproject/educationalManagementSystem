<?php
namespace app\update\controller;
use think\Cookie;
use think\Db;
use think\Controller;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
class Student extends Controller{
    

    public function updateInfo($stu_id=null){    
        //$id=Cookie::get('stu_id');


        if($this->request->isPost()){ // 实现修改
            $addnew=input('post.addnew');
            if ($addnew=="1" ){
                $upt_dat=array();
                //$upt_dat['id'] = $id;                
                $upt_dat['stu_sex']=input('post.sex');
                $upt_dat['stu_name']=input('post.name');
                $upt_dat['stu_address']=input('post.addr');
                $upt_dat['class_id']=input('post.class');                
                $upt_dat['major_id']=input('post.subject');                

                db('un_student')->where('stu_id',$stu_id)->update($upt_dat);
                $this->success('修改成功');
            }
        }

        $dat=db('un_student')
        ->alias('a')
        ->join('un_class b', 'a.class_id=b.class_id ')
        ->where('stu_id',$stu_id)
        ->find();
        $class=db('un_class')->select();
        $stusub = db('un_major')->where('major_id',$dat['major_id'])->find();        

        $sub=db('un_major')->select();
        // dump($aca); //查看数组
        $this->assign('sub',$sub);
        $this->assign('dat',$dat);
        $this->assign('stusub',$stusub);
        $this->assign('id',$stu_id);
        $this->assign('class',$class);
        return view();
    }



    



    
}