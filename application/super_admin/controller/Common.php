<?php
namespace app\super_admin\controller;
use think\Controller;
use think\Db;
use think\Loader;
use think\Session;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

class Common extends Error
{ // 这是公共控制器

	public function del(){ //删除
	    $id=input('param.id');
	    $tablename=input('param.tablename');
	    $url=input('param.url');
	    $res=db($tablename)->where('id',$id)->delete();
	    $this->success('删除成功！', $url);
	}
	public function get_auth_state(){
		$res = [];
		$res = Db::table('un_authority') ->select();
		return $res;
	}
	


}
