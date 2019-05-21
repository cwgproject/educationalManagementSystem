<?php
namespace app\student\controller;

use app\student\model\Student as StudentModel;
use think\Controller;
use think\facade\Cookie;
use think\Db;

class Student extends Controller
{

    public function form()
    {
        $list = StudentModel::paginate(5);
        return view('form',['list'=>$list]);
    }

    public function chooseCourse(){//选课
        $id=Cookie::get('stu_id');
        if($this->request->isPost()){ // 实现修改
            $addnew=input('post.addnew');
            if ($addnew=="1" ){
                $add_dat=array();
                $add_dat['course_id']=input('courseid');
                $add_dat['tea_id']=input('teacherid');
                $add_dat['stu_id'] = $id;
                if ($add_dat['course_id']!="" && $add_dat['tea_id']!=""){//可能有误?
                    $where1['tea_id'] = $add_dat['tea_id'];  $rs1=Db::table('un_teacher')->where($where1)->select();
                    $where2['course_id'] = $add_dat['course_id'];  $rs2=Db::table('un_course')->where($where2)->select();
                    dump($rs1); //查看数组                    
                    if($rs1[0]['tea_id'] != null && $rs2[0]['course_id'] != null){
                        $chooseCourse = [];
                        $chooseCourse['stu_id'] = $id;
                        $chooseCourse['tea_id'] = $add_dat['tea_id'];
                        $chooseCourse['course_id'] = $add_dat['course_id'];
                        $res_dat=db('un_student_course')->where($chooseCourse)->find();
                        if($res_dat){
                            $this->error('对不起，您已选择过此课，请重试!','chooseCourse');
                        }else{
                            $dat=db('un_student_course')->insert($add_dat);
                            $this->success('操作成功');
                        }
                    }else{
                        $this->error('输入的教师或课程不存在！','chooseCourse');
                        die;
                    }
                    
                }else{
                    $this->error('请输入完整！','chooseCourse');
                    die;
                }
            }
        }
        $stu = [];
        $stu['stu_id'] = $id;
        $res = [];
        $res = Db::table('un_student_course')
        ->alias('sc')
        ->join('un_teacher t','t.tea_id = sc.tea_id')
        ->join('un_course c','c.course_id = sc.course_id')
        ->field('t.tea_id teacherid, t.tea_name teachername, c.course_id courseid, c.course_name coursename, c.course_score score, c.course_hour subtime') 
        ->where($stu)->select();
        // dump($res); //查看数组
        $course=db('un_course')->select();
        $this->assign('res',$res);
        $this->assign('course',$course);
        // dump($sub); //查看数组
        return view();
    }

    public function choose_listxls(){
        header("Content-Type: application/vnd.ms-execl");   
        header("Content-Disposition: attachment; filename=课程表信息.xls");   
        header("Pragma: no-cache");   
        header("Expires: 0");
        $data = [];
        $data = Db::table('un_student_course')
        ->alias('sc')
        ->join('un_teacher t','t.tea_id = sc.tea_id')
        ->join('un_course c','c.course_id = sc.course_id')
        ->field('t.tea_id teacherid, t.tea_name teachername, c.course_id courseid, c.course_name coursename, c.course_score score, c.course_hour subtime')  
        ->order('course_id desc')->select();
        // $data=db('kehuxinxi')->order('id desc')->select();
        $this->assign('dat',$data);
        return view();
    }

    public function required_course_listxls(){
        header("Content-Type: application/vnd.ms-execl");   
        header("Content-Disposition: attachment; filename=必修课程表信息.xls");   
        header("Pragma: no-cache");   
        header("Expires: 0");
        $data = [];
        $data = Db::table('un_student')
        ->alias('s')
        ->join('un_major_course mc','mc.major_id = s.major_id')
        ->join('un_course c','c.course_id = mc.course_id')
        ->field('c.course_id as courseid, c.course_name as coursename, c.course_score as score, c.course_hour as subtime') 
        ->group("c.course_id")->order('c.course_id desc')->select(); 
        dump($data); //查看数组       
        $this->assign('dat',$data);
        return view();
    }

    public function judgeCourse(){ //评教
        $id=Cookie::get('stu_id');
        
        if($this->request->isPost()){ // 实现修改
            $addnew=input('post.addnew');
            if ($addnew=="1" ){
                $add_dat=array();
                $add_dat['course_id']=input('courseid');
                $add_dat['tea_id']=input('teacherid');
                $add_dat['judge']=input('judge');
                $add_dat['stu_id'] = $id;
                if ($add_dat['course_id']!="" && $add_dat['tea_id']!=""){//可能有误?
                    $where1['tea_id'] = $add_dat['tea_id'];  $rs1=Db::table('un_teacher')->where($where1)->select();
                    $where2['course_id'] = $add_dat['course_id'];  $rs2=Db::table('un_course')->where($where2)->select();
                    dump($rs1); //查看数组                    
                    if($rs1[0]['tea_id'] != null && $rs2[0]['course_id'] != null){
                        $chooseCourse = [];
                        $chooseCourse['tea_id'] = $add_dat['tea_id'];
                        $chooseCourse['course_id'] = $add_dat['course_id'];
                        $chooseCourse['stu_id'] = $add_dat['stu_id'];                        
                            Db::table('un_student_course')->where($chooseCourse)->update(['judge' => $add_dat['judge']]);
                            $this->success('操作成功');
                        
                    }else{
                        $this->error('输入的教师或课程不存在！','judgeCourse');
                        die;
                    }
                    
                }else{
                    $this->error('请输入完整！','judgeCourse');
                    die;
                }
            }
        }
        $stu = [];
        $stu['stu_id'] = $id;
        $res = [];
        $res = Db::table('un_student_course')
        ->alias('sc')
        ->join('un_teacher t','t.tea_id = sc.tea_id')
        ->join('un_course c','c.course_id = sc.course_id')
        ->field('t.tea_id teacherid, t.tea_name teachername, c.course_id courseid, c.course_name coursename, sc.judge judge') 
        ->where($stu)->select();      
        $this->assign('res',$res);
        return view();
    }

    public function check_grade(){ //查看成绩
        $id=Cookie::get('stu_id');
        $stu = [];
        $stu['stu_id'] = $id;
        $res = [];
        $res = Db::table('un_student_course')
        ->alias('sc')
        ->join('un_course c','c.course_id = sc.course_id')
        ->field('c.course_id courseid, c.course_name coursename, c.course_score score, c.course_hour subtime, sc.grade grade') 
        ->where($stu)->select();
        // dump($res); //查看数组
        $course=db('un_course')->select();
        $this->assign('res',$res);
        // dump($sub); //查看数组
        return view();
    }



}