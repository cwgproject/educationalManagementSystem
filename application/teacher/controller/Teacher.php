<?php
namespace app\teacher\controller;
use think\Loader;
use think\facade\Cookie;
use think\Db;
use think\Controller;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

use app\teacher\model\Teacher as TeacherModel;


class Teacher extends \app\common\controller\Common
{
    public function form()
    {
        $list = TeacherModel::paginate(5);
        return view('form',['list'=>$list]);
    }

    public function Teach1(){   
        //教师选课
        $authority = $this->get_auth_state();
        if($authority[5]['auth_state'] == 0){
            $this->success('尚未开启该权限','');
        }else{
            $id=Cookie::get('tea_id');
            $course=db('un_course')->select();
            if($this->request->isPost()){ // 实现修改
                $addnew=input('post.addnew');
                if ($addnew=="1" ){
                    $add_dat=array();
                    $add_dat['course_id']=input('course');
                    $add_dat['tea_id']=$id;
                    
                    if ($add_dat['course_id']!="" ){//可能有误?
                        $TeachCourse = [];
                        $check1 = [];
                        $TeachCourse['tea_id'] = $add_dat['tea_id'];
                        $TeachCourse['course_id'] = $add_dat['course_id'];
                        $check1['t.tea_id'] =  $add_dat['tea_id'];
                        $check1['mc.course_id'] = $add_dat['course_id'];
                         
                        $check = Db::table('un_teacher')-> alias('t')
                        ->join('un_academy a','t.academy_id = a.academy_id')
                        ->join('un_major m','m.academy_id = a.academy_id')
                        ->join('un_major_course mc','mc.major_id = m.major_id')                                   
                        ->field('t.tea_id as id, mc.course_id as cid, a.academy_name as academy')
                        ->where($check1) 
                        ->select(); 
                        dump($check); //查看数组
                        if($check == null){
                            $this->error('对不起，您不能选择教授此课，请选择您学院的课程!','teach1');
                        }else{
                            $res_dat=db('un_teacher_course')->where($TeachCourse)->find();
                            if($res_dat){
                                $this->error('对不起，您已选择教授此课，请重试!','teach1');
                            }else{
                                $dat=db('un_teacher_course')->insert($add_dat);
                                // session('synchronization_insert', 0);//同步状态：NO
                                $this->success('操作成功');
                            }
                        }

                        
                    }else{
                        $this->error('请输入完整！');
                        die;
                    }
                }
            }
            
            $res = [];
            $res = Db::table('un_teacher_course')
            -> alias('tc')
            ->join('un_course c','tc.course_id = c.course_id') 
            ->field('c.course_id, c.course_name, c.course_score, c.course_hour') 
            ->where('tc.tea_id',$id) ->select();
            // dump($res); //查看数组
            $course=db('un_course')->select();
            $this->assign('res',$res);
            $this->assign('course',$course);
            // dump($sub); //查看数组
            return view();
        }
        
    }


    public function Teach2(){
        //查看评教
        $id=Cookie::get('tea_id');
        $res = Db::table('un_student_course')-> alias('sc')
        ->join('un_course c','sc.course_id = c.course_id') 
        ->field('sc.course_id as CId, c.course_name as name, avg(sc.judge) as Judge') 
        ->where('tea_id',$id) 
        ->group("sc.course_id")->select();
        $this->assign('res',$res);
        return view();
    }
}