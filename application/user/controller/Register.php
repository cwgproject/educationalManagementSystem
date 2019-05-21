<?php
namespace app\user\controller;

use think\Controller;
use think\Loader;
use think\Db;
use think\facade\Cookie;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

class Register extends \app\common\controller\Common
{// 这个是注册类别的控制器    

    public function Loger_batch(){//批量注册  //x需要提示日期格式与数据库保持一致
        $authority = $this->get_auth_state();
        if($authority[2]['auth_state'] == 0){
            $this->success('尚未开启该权限','');
        }else{
            if($this->request->isPost()){ // 实现修改
                $keys = array('user_name', 'role_id', 'user_password', 'register_date');
                $excel_array = parent::addexcel();     
                // unset($excel_array[0]);
                $arr  = reset($excel_array);
                $data = [];  
    
                $i=0;  
                foreach($excel_array as $k=>$v) {  
                    $data[$k][$arr[0]] = $v[0];  
                    $data[$k][$arr[1]] = $v[1];  
                    $data[$k][$arr[2]] = md5($v[2]);  
                    $data[$k][$arr[3]] = $v[3];  
                    $i++;  
                }
                array_shift($data);  //删除第一个数组(标题);
    
                $res = Db::table('un_user')->insertAll($data);
                if($res > 0){//待修改
                    var_dump($res);
                    session('synchronization_insert', 'no');//同步状态：NO
                    $this->synchronization_insert();
                    // $this->success('上传成功');     
                    // return view();
                }else{//
                    $this->error('对不起，您输入的表格有错误，请重试!','Loger_batch');
                    // dump($excel_array); //查看数组
                    // dump($data); //查看数组
                    var_dump($res);
                }
                
            }
            return view();
        }
        
    }

    public function EpSt_indi(){ //待修改
        $authority = $this->get_auth_state();
        if($authority[2]['auth_state'] == 0){
            $this->success('尚未开启该权限','');
        }else{
            $ndate =date("Y-m-d");
        $addnew=input("post.addnew");
        if($this->request->isPost()){ // 实现修改
            if ($addnew=="1" ){
                $add_dat=array();
                $add_dat['user_name']=input('userid');
                $add_dat['user_password']=input('password');
                $add_dat['register_date']=$ndate;
                $add_dat['role_id']=input('identity');
                if ($add_dat['user_name']!="" && $add_dat['user_password']!="" && $add_dat['role_id']!=""){//可能有误?
                    $res_dat=db('un_user')->where('user_name',$add_dat['user_name'])->find();
                    if($res_dat){
                        $this->error('对不起，您输入的人员已经存在，请重试!','EpSt_indi');
                    }else{
                        $dat=db('un_user')->insert($add_dat);
                        session('synchronization_insert', 0);//同步状态：NO
                        $this->synchronization_insert();
                        // $this->success('操作成功');
                    }
                }else{
                    $this->error('请输入完整！');
                    die;
                }
   
            }
        }
        $this->assign('ndate',$ndate);
        $this->assign('addnew',$addnew);
        return view();
        }
        
    }

    public function synchronization_insert(){
        $state = '';
        if(session('synchronization_insert') == 1) $state = '已同步';
        else $state = '未同步';
        if($this->request->isPost()){
            $addnew=input('post.addnew');
            if($addnew=="1"){
                $req = Db::query('select user_name,role_id from un_user;');
                // dump($req);
                $count = count($req);
                    
                for($i = 0; $i < $count; $i++){
                    if($req[$i]['role_id'] == 3){
                        $res_dat=db('un_student')->where('stu_rollno',$req[$i]['user_name'])->find();
                        if($res_dat)continue;
                        else
                            Db::table('un_student') ->data(['stu_rollno' => $req[$i]['user_name']]) -> insert();            
                    }else{
                    $res_dat=db('un_teacher')->where('tea_rollno',$req[$i]['user_name'])->find();
                    if($res_dat)continue;
                    else
                        Db::table('un_teacher') ->data(['tea_rollno' => $req[$i]['user_name']]) -> insert();
                    }
                    $i++;
                }
                session('synchronization_insert', 1);//同步状态：YES
                $this->success('同步成功');
            }
        }
        $this->assign('state',$state);
        return view();
    }

    public function mod(){
        if($this->request->isPost()){
            $addnew=input('post.addnew');
            if($addnew=="1"){
                $id=Cookie::get('user_name');
                $pwd=input('post.xmm1');
                $pwdy=input('post.ymm');
                $rowscount=db('un_user')->where('user_name',cookie('user_name'))->find();
                if($rowscount>0){
                    if($rowscount["user_password"]==md5($pwdy)){
                        $res=db('un_user')->where('user_name',$rowscount['user_name'])->update(array('user_password'=>md5($pwd)));
                        $this->success('修改成功！');
                        die;
                    }else{
                        $this->error('对不起,原密码不正确！');
                        die;
                    }
                }else{
                    $this->error('对不起,原密码不正确！');
                    die;
                }
            }
        }
        return view();
    }
}


