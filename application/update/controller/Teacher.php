<?php
namespace app\update\controller;
use think\Loader;
use think\facade\Cookie;
use think\Db;
use think\Controller;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
class Teacher extends \app\common\controller\Common{
    public function main(){
        $id = '';        
        $res = [];
        $aca = '';
        if(Cookie::get('tea_id') != null){
            $id = Cookie::get('tea_id');
            $res = Db::table('un_teacher')-> alias('t')
            ->join('un_user u','t.tea_rollno = u.user_name') 
            ->join('un_academy a','t.academy_id = a.academy_id')
            ->join('un_role r','r.role_id = u.role_id')             
            ->field('u.user_id as id, r.role_name as identity, u.register_date as rdate,t.tea_sex as sex,
             t.tea_title as position, t.tea_name as name,a.academy_name as academy') 
            ->where('t.tea_id',$id) 
            ->select();            
            // dump($res); //查看数组
            if($res != null){
                $this->assign('res',$res);                
            }else{
                $id = Cookie::get('tea_id');
                $res = Db::table('un_teacher')-> alias('t')
                ->join('un_user u','t.tea_rollno = u.user_name') 
                ->join('un_role r','r.role_id = u.role_id')             
                ->field('u.user_id as id, r.role_name as identity, u.register_date as rdate,t.tea_sex as sex,
                 t.tea_title as position, t.tea_name as name,t.academy_id as academy') 
                ->where('t.tea_id',$id) 
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
            $id = Cookie::get('tea_id');
            $identity = Cookie::get('role_id');
    
            if($this->request->isPost()){ // 实现修改
                $addnew=input('post.addnew');
                if ($addnew=="1" ){
                    $upt_dat=array();
                    $upt_dat['tea_id'] = $id;                
                    $upt_dat['tea_title']=input('post.position');
                    // $upt_dat['sex']=input('post.sex');
                    $upt_dat['tea_name']=input('post.name');
                    $upt_dat['tea_tel']=input('post.tel');
                    $upt_dat['academy_id']=input('post.academy');                
    
                    db('un_teacher')->where('tea_id',$id)->update($upt_dat);
                    $this->success('修改成功');
                }
            }
    
            $dat=db('un_teacher')->where('tea_id',$id)->find();
            $Empaca = db('un_academy')->where('academy_id',$dat['academy_id'])->find();
    
            $aca=db('un_academy')->select();
            // dump($aca); //查看数组
            $this->assign('aca',$aca);
            $this->assign('dat',$dat);
            $this->assign('Empaca',$Empaca);
            $this->assign('id',$id);
            return view();
        }

    }

    public function Teach1(){   
        //教师选课
        $authority = $this->get_auth_state();
        if($authority[5]['auth_state'] == 0){
            $this->success('尚未开启该权限','');
        }else{
            $id=Session::get('id');
            $course=db('course')->select();
                        
            if($this->request->isPost()){ // 实现修改
                $addnew=input('post.addnew');
                if ($addnew=="1" ){
                    $add_dat=array();
                    $add_dat['CId']=input('course');
                    $add_dat['teacherId']=$id;
                    
                    if ($add_dat['CId']!="" ){//可能有误?
                        $TeachCourse = [];
                        $check1 = [];
                        $TeachCourse['teacherId'] = $add_dat['teacherId'];
                        $TeachCourse['CId'] = $add_dat['CId'];
                        $check1['e.id'] =  $add_dat['teacherId'];
                        $check1['sc.CId'] = $add_dat['CId'];
                         
                        $check = Db::table('employees')-> alias('e')
                        ->join('Academy a','e.academy = a.id')
                        ->join('subjects s','s.academy = a.id')                         
                        ->join('Sub_Course sc','sc.subId = s.id')             
                        ->field('e.id as id, sc.CId as cid, a.name as academy')
                        ->where($check1) 
                        ->select(); 
                        dump($check); //查看数组
                        if($check == null){
                            $this->error('对不起，您不能选择教授此课，请选择您学院的课程!','teach1');
                        }else{
                            $res_dat=db('teach_course')->where($TeachCourse)->find();
                            if($res_dat){
                                $this->error('对不起，您已选择教授此课，请重试!','teach1');
                            }else{
                                $dat=db('TeachCourse')->insert($add_dat);
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
            $res = Db::table('teach_course')
            -> alias('t')
            ->join('Course c','t.CId = c.id') 
            ->field('c.id, c.name, c.score, c.subtime') 
            ->where('t.teacherId',$id) ->select();
            // dump($res); //查看数组
            $course=db('Course')->select();
            $this->assign('res',$res);
            $this->assign('course',$course);
            // dump($sub); //查看数组
            return view();
        }
        
    }


    public function Teach2(){
        //查看评教
        $id = Session::get('id');
        $res = Db::table('Choose_Course')-> alias('ch')
        ->join('Course c','ch.CId = c.id') 
        ->field('ch.CId as CId, c.name as name, avg(ch.Judge) as Judge') 
        ->where('teacherId',$id) 
        ->group("CId")->select();
        $this->assign('res',$res);
        return view();
    }



    public function addgrade(){
        //成绩录入        
        $authority = $this->get_auth_state();
        if($authority[1]['auth_state'] == 0){
            $this->success('尚未开启该权限','');
        }else{
            $id=Session::get('id');
            if($this->request->isPost()){ // 实现修改
                // $keys = array('id', 'identity', 'password', 'registerDate');
                $excel_array = parent::addexcel(); 
                unset($excel_array[0]);              
                $data = [];             
                foreach($excel_array as $k=>$v) {  
                    $data[$k]['CId']   = $v[0];  
                    $data[$k]['stuId'] = $v[2];  
                    $data[$k]['grade'] = $v[4];   
                    
                    $upadte = array();
                    $upadte['CId']   = $v[0];
                    $upadte['stuId'] = $v[2];
                    $upadte['teacherId'] = $id;
                    Db::table('choose_course')->where($upadte)->update(['grade' => $v[4]]);
                }
                    $this->success('上传成功');  
                dump($data); //查看数组
    
                // array_shift($data);  //删除第一个数组(标题);
    
                // $res = Db::table('Loger')->insertAll($data);
                // if($res > 0){//待修改
                //     var_dump($res);
                //     session('synchronization_insert', 'no');//同步状态：NO
                //     $this->success('上传成功');     
                //     // return view();
                // }else{//
                //     $this->error('对不起，您输入的表格有错误，请重试!','Loger_batch');
              
                // }
                
            }
            return view();
        }

    }


    public function gradelistxls(){
        $id=Session::get('id');
        header("Content-Type: application/vnd.ms-execl");   
        header("Content-Disposition: attachment; filename=选课表信息.xls");   
        header("Pragma: no-cache");   
        header("Expires: 0");
        $teacher = [];
        $teacher['teacherId'] = $id;
        $data = [];
        $data = Db::table('choose_course')
        ->alias('ch')
        ->join('students s','s.id = ch.stuId')
        ->join('course c','c.id = ch.CId')
        ->field('s.id stuid, s.name stuname, c.id courseid, c.name coursename, ch.grade grade') 
        ->where($teacher)->select();
        $this->assign('dat',$data);
        return view();
    }
}