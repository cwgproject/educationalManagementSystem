<?php
namespace app\login\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    public function login()
    {
        
        return $this->fetch();
    }

    // 处理登录逻辑
    public function doLogin()
    {
    	$param = input('post.');
    	if(empty($param['userid'])){
    		
    		$this->error('用户名不能为空');
    	}
    	
    	if(empty($param['password'])){
    		
    		$this->error('密码不能为空');
    	}
    	
    	// 验证用户名
    	$has = db('buemployee')->where('employee_name', $param['userid'])->find();
    	if(empty($has)){
    		
    		$this->error('用户名不存在');
    	}
		
		// if(!session('?count')){
		// 	session('count',3);//可输入次数
		// }
		
		//验证帐号状态
		if($has['employee_status'] == 1){
			$etime = ceil(30-((time() - $has['time_last_error'])/60));
			if((time() - $has['time_last_error']) > 1800){
				$now['employee_status'] = 0;  //若超过锁定时间，帐号恢复正常  （status-0)
				Db::table('buemployee')->where('employee_id', $has['employee_id'])->update($now);
			}
			else{
				$this->error('您的帐号已锁定,请'.$etime.'分钟之后登录！');
			}
		}

    	// 验证密码
    	if($has['employee_password'] != md5($param['password'])){
		// if($has['employee_password'] !== $param['password']){
			if($has['employee_count'] > 1){
				$now['employee_count'] = $has['employee_count'] - 1;
				Db::table('buemployee')->where('employee_id', $has['employee_id'])->update($now);
				$this->error('密码输入错误,您还能输入'.$now['employee_count'].'次');
			}
			else{
				$now['employee_status'] = 1;
				$now['time_last_error'] = time();
				$now['employee_count'] = 3;
				Db::table('buemployee')->where('employee_id', $has['employee_id'])->update($now);
				$this->error('密码错误超过3次,帐号已锁定，请30分钟之后登录！');
			}
			
			//session('error_time',time());
			//dump(session('count'));
    		
    	}
		
		function GetBrowser()
		{
			$browser = "其他";

			//判断是否是myie
			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"myie")){
				$browser = "myie";
			}
			
			//判断是否是Netscape
			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"netscape"))
			{
				$browser = "netscape";
			}

			//判断是否是Opera
			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"opera")){
				$browser = "opera";
			}

			//判断是否是netcaptor
			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"netcaptor")) {
				$browser = "netCaptor";
			}

			//判断是否是TencentTraveler
			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"tencenttraveler")) {
				$browser = "TencentTraveler";
			}

			//判断是否是Firefox
			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"firefox")) {
				$browser = "Firefox";
			}

			//判断是否是ie
			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"msie")) {
				$browser = "ie";
			}
			
			//判断是否是chrome内核浏览器
			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"chrome")) {
				$browser = "google";
			}

		return $browser;
		}

        // 记录用户登录信息
        cookie('employee_id', $has['employee_id'], 3600);// 一个小时有效期
        cookie('employee_name', $has['employee_name'], 3600);
		cookie('department_id', $has['department_id'], 3600);
		cookie('role_id', $has['role_id'], 3600);
		cookie('rec_time', $has['rec_time'], 3600);
		cookie('rec_address', $has['rec_address'], 3600);
		//重置账户状态
		$now['employee_status'] = 0;
		$now['employee_count'] = 3;
		$now['rec_address'] = $this->request->ip();//获取ip地址,但全为0.0.0.0
		$now['rec_time'] = date("Y-m-d H:i:s");//获取系统时间
		$now['rec_useraent'] = GetBrowser();//获取浏览器信息
		Db::table('buemployee')->where('employee_id', $has['employee_id'])->update($now);

	
    	// if($has['role_id'] == 1){
        //     $this->redirect(url('index/admin'));
        // }
        // else if($has['role_id'] == 2){
        //     $this->redirect(url('index/manager'));
        // }
        // else{
		// 	$this->redirect(url('index/employee'));
		// }

		$this->redirect(url('index/admin'));
        
    }
     
    // 退出登录
    public function loginOut()
    {
    	cookie('employee_id', null);
    	cookie('employee_name', null);
    	
    	$this->redirect(url('index/login'));
	}

	public function admin()
    {
        return $this->fetch();
	} 


}

