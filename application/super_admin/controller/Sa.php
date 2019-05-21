<?php
namespace app\super_admin\controller;

use think\Controller;
use think\Loader;
use think\Db;
use think\Session;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

class Sa extends Common{
    //超级管理员 ：SuperAdministrator 简称 Sa
    public function main(){
        $res = [];
        $res = $this->get_auth_state();
        // dump($res); //查看数组

        $upinfostate = '';
        if($res[6]['auth_state'] == 1) $upinfostate = '<font color="green">已开启</font>';
        else $upinfostate = '<font color="red">已关闭</font>';
        
        $tcstate = '';
        if($res[5]['auth_state'] == 1) $tcstate = '<font color="green">已开启</font>';
        else $tcstate = '<font color="red">已关闭</font>';
        
        $scstate = '';
        if($res[4]['auth_state'] == 1) $scstate = '<font color="green">已开启</font>';
        else $scstate = '<font color="red">已关闭</font>';
        
        $judgestate = '';
        if($res[3]['auth_state'] == 1) $judgestate = '<font color="green">已开启</font>';
        else $judgestate = '<font color="red">已关闭</font>';
        
        $insertinfostate = '';
        if($res[2]['auth_state'] == 1) $insertinfostate = '<font color="green">已开启</font>';
        else $insertinfostate = '<font color="red">已关闭</font>';
        
        $gradestate = '';
        if($res[1]['auth_state'] == 1) $gradestate = '<font color="green">已开启</font>';
        else $gradestate = '<font color="red">已关闭</font>';
        
        $delinfostate = '';
        if($res[0]['auth_state'] == 1) $delinfostate = '<font color="green">已开启</font>';
        else $delinfostate = '<font color="red">已关闭</font>';

       
        $this->assign('upinfostate',$upinfostate);
        $this->assign('tcstate',$tcstate);
        $this->assign('scstate',$scstate);
        $this->assign('judgestate',$judgestate);
        $this->assign('gradestate',$gradestate);
        $this->assign('delinfostate',$delinfostate);
        $this->assign('insertinfostate',$insertinfostate);
        return view();
    }

    

    public function up_info(){        //更改权限                    
        $res = $this->get_auth_state();
        $auth_name = 'up_info';                        
        if($res[6]['auth_state'] == 1){            
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 0;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：No
            $this->success('已关闭','main');
        }          
        else{
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 1;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：yes
            $this->success('已开启','main');
        }                          
    }



    public function teacher_course(){ //教师选课权限
        $res = $this->get_auth_state();
        $auth_name = 'teacher_course';                        
        if($res[5]['auth_state'] == 1){            
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 0;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：No
            $this->success('已关闭','main');
        }          
        else{
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 1;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：yes
            $this->success('已开启','main');
        } 
    }



    public function student_course(){ //学生选课权限
        $res = $this->get_auth_state();
        $auth_name = 'student_course';                        
        if($res[4]['auth_state'] == 1){            
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 0;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：No
            $this->success('已关闭','main');
        }          
        else{
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 1;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：yes
            $this->success('已开启','main');
        } 
    }



    public function judge(){ //评教权限
        $res = $this->get_auth_state();
        $auth_name = 'judge';                        
        if($res[3]['auth_state'] == 1){            
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 0;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：No
            $this->success('已关闭','main');
        }          
        else{
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 1;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：yes
            $this->success('已开启','main');
        } 
    }

    public function insert_info(){        //更改权限                    
        $res = $this->get_auth_state();
        $auth_name = 'insert_info';                        
        if($res[2]['auth_state'] == 1){            
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 0;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：No
            $this->success('已关闭','main');
        }          
        else{
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 1;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：yes
            $this->success('已开启','main');
        }                          
    }

    public function grade(){ //输入成绩权限
        $res = $this->get_auth_state();
        $auth_name = 'grade';                        
        if($res[1]['auth_state'] == 1){            
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 0;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：No
            $this->success('已关闭','main');
        }          
        else{
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 1;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：yes
            $this->success('已开启','main');
        }
    }

    public function del_info(){        //注销权限  
        $res = $this->get_auth_state();
        $auth_name = 'del_info';                        
        if($res[0]['auth_state'] == 1){            
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 0;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：No
            $this->success('已关闭','main');
        }          
        else{
            $upt_dat['auth_name']= $auth_name;
            $upt_dat['auth_state']= 1;
            db('un_authority')->where('auth_name',$auth_name)->update($upt_dat);//修改信息：yes
            $this->success('已开启','main');
        }                           
    }



}