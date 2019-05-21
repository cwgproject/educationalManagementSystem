<?php
namespace app\update\controller;
use think\Loader;
use think\facade\Cookie;
use think\Db;
use think\Controller;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
class Student2 extends \app\common\controller\Common{
    public function main(){
        $id = '';        
        $res = [];
        $aca = '';
        if(Cookie::get('stu_id') != null){
            $id = Cookie::get('stu_id');
                // echo $id;
            $res = Db::table('un_student')-> alias('s')
            ->join('un_user u','s.stu_rollno = u.user_name') 
            ->join('un_academy a','s.academy_id = a.academy_id')
            ->join('un_major m','s.major_id = m.major_id')
            ->join('un_class c','s.class_id = c.class_id')             
            ->field('u.user_id as id, u.register_date as rdate,
             s.stu_sex as sex, c.class_name as class, s.stu_name as name, s.stu_address as tel,
             m.major_name as subject,
             a.academy_name as academy')
            ->where('s.stu_id',$id) 
            ->select();                        
            if($res != null){
                $this->assign('res',$res);                
            }else{
                $res = Db::table('un_student')-> alias('s')
                ->join('un_user u','s.stu_rollno = u.user_name')                           
                ->field('u.user_id as id, u.rec_date as rdate,
             s.stu_sex as sex, s.class_id as class, s.stu_name as name, s.stu_address as tel,
             s.major_id as subject,
             s.academy_id as academy')
                ->where('s.stu_id',$id) 
                ->select();                 
                $this->assign('res',$res);
            }                                
        }                        
        return view();



    }

    public function update_info(){  
        $authority = $this->get_auth_state();
        if($authority[6]['auth_state'] == 0){
            $this->success('尚未开启该权限','');
        }else{
            $id = Cookie::get('stu_id');

        if($this->request->isPost()){ // 实现修改
            $addnew=input('post.addnew');
            if ($addnew=="1" ){
                $upt_dat=array();
                $upt_dat['stu_id'] = $id;                
                $upt_dat['stu_sex']=input('post.sex');
                $upt_dat['stu_name']=input('post.name');
                $upt_dat['tel']=input('post.tel');
                $upt_dat['stu_class']=input('post.class');
                $upt_dat['stu_major']=input('post.subject');                 
                $upt_dat['stu_academy']=input('post.academy');                
                
                $check1 = [];
                $check1['major_id'] = input('post.subject');
                $check1['academy_id']=input('post.academy');
                $check = [];
                $check = Db::table('un_major')->where($check1)->select();
                if($check == null){
                    $this->error('对不起，您选择的专业不属于您选择的学院!','update_info');
                }else{
                    db('un_student')->where('stu_id',$id)->update($upt_dat);
                    $this->success('修改成功');
                }
                
            }
        }

        $dat=db('un_student')->where('stu_id',$id)->find();
        $stusub = db('un_major')->where('major_id',$dat['major_id'])->find();  
        $stuaca = db('un_academy')->where('academy_id',$dat['academy_id'])->find();       

        $sub=db('un_major')->select();
        $aca=db('un_academy')->select();
        // dump($aca); //查看数组
        $this->assign('aca',$aca);
        $this->assign('sub',$sub);
        $this->assign('dat',$dat);
        $this->assign('stusub',$stusub);
        $this->assign('stuaca',$stuaca);
        $this->assign('id',$id);
        return view();
        }  
        
    }


    public function check_grade(){ //查看成绩
        $id=Session::get('id');
        $stu = [];
        $stu['stuId'] = $id;
        $res = [];
        $res = Db::table('choose_course')
        ->alias('ch')
        ->join('course c','c.id = ch.CId')
        ->field('c.id courseid, c.name coursename, c.score score, c.subtime subtime, ch.grade grade') 
        ->where($stu)->select();
        // dump($res); //查看数组
        $course=db('Course')->select();
        $this->assign('res',$res);
        // dump($sub); //查看数组
        return view();
    }


    
}