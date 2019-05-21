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
class addgrade extends \app\common\controller\Common{
    
    public function addgrade(){
        //$id=Cookie::get('tea_id');
        //成绩录入  
        $authority = $this->get_auth_state();
        if($authority[1]['auth_state'] == 0){
            $this->success('尚未开启该权限','');
        }else{
            $id=Cookie::get('tea_id');
            if($this->request->isPost()){ // 实现修改
                // $keys = array('id', 'identity', 'password', 'registerDate');
                $excel_array = parent::addexcel(); 
                unset($excel_array[0]);              
                $data = [];             
                foreach($excel_array as $k=>$v) {  
                    $data[$k]['courseId']   = $v[0];  
                    $data[$k]['stuId'] = $v[2];  
                    $data[$k]['mark'] = $v[4];   
                    
                    $update = array();
                    $update['course_id']   = $v[0];
                    $update['stu_id'] = $v[2];
                    $update['mark'] = $v[4];
                    //$update['tea_id'] = $id;
                    Db::table('un_mark')->insert($update);
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
        $id=Cookie::get('tea_id');
        header("Content-Type: application/vnd.ms-execl");   
        header("Content-Disposition: attachment; filename=选课表信息.xls");   
        header("Pragma: no-cache");   
        header("Expires: 0");
        $teacher = [];
        $teacher['tea_id'] = $id;
        $data = [];
        $data = Db::table('un_student_course')
        ->alias('sc')
        ->join('un_student s','s.stu_id = sc.stu_id')
        ->join('un_course c','c.course_id = sc.course_id')
        ->field('s.stu_id stuid, s.stu_name stuname, c.course_id courseid, c.course_name coursename, sc.grade grade') 
        ->where($teacher)->select();
        $this->assign('dat',$data);
        return view();
    }
}