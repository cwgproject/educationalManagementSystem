<?php
namespace app\announcement\controller;

class Common extends Error
{ // 这是公共控制器
	

	public function del(){ //删除
	    $id=input('param.id');
	    $tablename=input('param.tablename');
	    $url=input('param.url');
	    $res=db($tablename)->where('id',$id)->delete();
	    $this->success('删除成功！', $url);
	}

	public function get_list($data){	//获取列表
		$search_dat=$data['field'];
		$count=$data['db']->where($search_dat)->count();//获取查询总行数

		$pagelarge=$data['pagelarge']?$data['pagelarge']:10;//每页行数;

		if($count%$pagelarge==0){ // 总页数
			$pagecount=$count/$pagelarge;
		}else{
			$pagecount=intval($count/$pagelarge)+1;
		}

		$list=$data['db']->where($search_dat)->order("{$data['paixu']} {$data['px']}")->page($data['pagecurrent'],$pagelarge)->select();		

		$res=array();
		$res['list']=$list;
		$res['count']=$count;
		$res['pagecount']=$pagecount;
		$res['pagelarge']=$data['pagelarge'];
		$res['pagecurrent']=$data['pagecurrent'];

		$res['field']=$data['field_dat'];
		unset($data['db']); //释放
		$res['dat']=$data;

		return $res;
	}

	

	public function makecode3(){  //公告
		$i=1; 
		$str = "0123456789";   //   输出字符集
		$n = 5;   //   输出串长度
		$len = strlen($str)-1;
		$s='';
		for($i=0 ; $i<$n; $i++){
			$s .=  $str[rand(0,$len)];
		}
		$timestamp=time(); 
		return ''.$s; 
	} 

	
}
