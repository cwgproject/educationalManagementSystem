<?php
namespace app\index\controller;

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
		
		//验证码
		if($param['yzm'] != session('regsession_code')){
			$this->error('请输入正确验证码！');
			die;
		}
    	
    	// 验证用户名
    	$has = db('un_user')->where('user_name', $param['userid'])->find();
    	if(empty($has)){
    		
    		$this->error('用户名不存在');
    	}
		
		// if(!session('?count')){
		// 	session('count',3);//可输入次数
		// }
		
		//验证帐号状态
		if($has['user_status'] == 1){
			$etime = ceil(30-((time() - $has['time_last_error'])/60));
			if((time() - $has['time_last_error']) > 1800){
				$now['user_status'] = 0;  //若超过锁定时间，帐号恢复正常  （status-0)
				Db::table('un_user')->where('user_id', $has['user_id'])->update($now);
			}
			else{
				$this->error('您的帐号已锁定,请'.$etime.'分钟之后登录！');
			}
		}

    	// 验证密码
    	if($has['user_password'] != md5($param['password'])){
		// if($has['user_password'] !== $param['password']){
			if($has['user_count'] > 1){
				$now['user_count'] = $has['user_count'] - 1;
				Db::table('un_user')->where('user_id', $has['user_id'])->update($now);
				$this->error('密码输入错误,您还能输入'.$now['user_count'].'次');
			}
			else{
				$now['user_status'] = 1;
				$now['time_last_error'] = time();
				$now['user_count'] = 3;
				Db::table('un_user')->where('user_id', $has['user_id'])->update($now);
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
        cookie('role_id', $has['role_id'], 3600);
		cookie('user_name', $has['user_name'], 3600);
		cookie('rec_time', $has['rec_time'], 3600);
		cookie('rec_address', $has['rec_address'], 3600);
		//重置账户状态
		$now['user_status'] = 0;
		$now['user_count'] = 3;
		$now['rec_address'] = $this->request->ip();//获取ip地址
		$now['rec_time'] = date("Y-m-d H:i:s");//获取系统时间
		$now['rec_useraent'] = GetBrowser();//获取浏览器信息
		Db::table('un_user')->where('user_id', $has['user_id'])->update($now);

	
    	if($has['role_id'] == 1){
            $this->redirect(url('index/main'));
        }
        else if($has['role_id'] == 2){
			$userinfo = db('un_user,un_teacher')
			->where('un_user.user_name = un_teacher.tea_rollno')->where('tea_rollno', $param['userid'])->find();
			cookie('tea_id', $userinfo['tea_id'], 3600);// 一个小时有效期
			cookie('tea_name', $userinfo['tea_name'], 3600);
            $this->redirect(url('index/main'));
        }
        else{
			$userinfo = db('un_user,un_student')
			->where('un_user.user_name = un_student.stu_rollno')->where('stu_rollno', $param['userid'])->find();
			// halt($userinfo);
			cookie('stu_id', $userinfo['stu_id'], 3600);// 一个小时有效期
			cookie('stu_name', $userinfo['stu_name'], 3600);
			$this->redirect(url('index/main'));
        }
        
        
    }
     
    // 退出登录
    public function logOut()
    {
		if(cookie('role_id') == 1){
            cookie('user_id', null);
		}
		else if(cookie('role_id') == 2){
			cookie('tea_id', null);
			cookie('tea_name', null);
		}
		else{
			cookie('stu_id', null);
			cookie('stu_name', null);
        }
    	cookie('user_id', null);
    	cookie('user_name', null);
    	
    	$this->redirect(url('index/login'));
	}

	
	public function student()
    {
        return $this->fetch();
	} 
	public function teacher()
	{
		return $this->fetch();
    }
    
    public function left()
    {
        return $this->fetch();
    } 
    public function top(){
    	return view();
    }
    public function sy(){
        $this->assign('time',date("Y-m-d",time()));
        $this->assign('php_uname',php_uname());
        return view();
    }
    public function main(){
    	return view();
    }

	public function code(){ //生成验证码
		$code=array("width"=>50,"height"=>25,	"len"=>4,			 
			"char"=>1,"imx"=>8,"imy"=>6,"cookie"=>"regsession_code",
			"value"=>""
		);

		if($code["char"]==1){
		$char=array(0,1,2,3,4,5,6,7,8,9);
		}elseif($code["char"]==2){
		$char=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
		}elseif($code["char"]==3){
			$char=array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
		}
		for($i=0;$i<$code["len"];$i++){
			$code["value"].=$char[rand(0,count($char)-1)];
		}

		session('regsession_code',$code["value"]);
		@header("Content-Type:image/png");

		$im=imagecreate($code["width"],$code["height"]);
		$back=imagecolorallocate($im,0xff,0xff,0xff);	//背景色
		$pix=imagecolorallocate($im,221,241,251);	//模糊点颜色
		$font=imagecolorallocate($im,23,162,231);	//字体色
		for($i=0;$i<1000;$i++){
			imagesetpixel($im,rand(0,$code["width"]),rand(0,$code["height"]),$pix);
		}
		 
		imagestring($im,5,$code["imx"],$code["imy"],$code["value"],$font);
		imagerectangle($im,0,0,$code["width"]-1,$code["height"]-1,$font);
		imagepng($im);
		imagedestroy($im);
	}


}

