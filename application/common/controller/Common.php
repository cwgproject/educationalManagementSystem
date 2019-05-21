<?php
namespace app\common\controller;
use think\Controller;
use think\Db;
use think\Loader;
use think\facade\Cookie;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

class Common extends Error
{ // 这是公共控制器
	public function _initialize(){
		if(!cookie('role_id')){
			$this->error('请先登录！', 'index/index');
			die();
		}
		$this->assign('role_id',cookie('role_id'));
	}

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

	public function addexcel()
    {
    	vendor("PHPExcel.PHPExcel"); //获取PHPExcel类 
        $excel = new \PHPExcel();  
 
        $file = request()->file('file');  
        $info = $file->validate(['size'=>15678,'ext'=>'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'excel');
 
 
        if($info){
        	$exclePath = $info->getSaveName();  //获取文件名  
            $file_name = ROOT_PATH . 'public' . DS . 'excel' . DS . $exclePath;   //上传文件的地址  
            $objReader =\PHPExcel_IOFactory::createReader('Excel2007');  
            $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8  
            echo "<pre>";  
            $excel_array=$obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式  
            // array_shift($excel_array);  //删除第一个数组(标题);  
            
            // unset($excel_array[0]);
     
            return $excel_array;
            
        }
	}
	

	// public function synchronization_insert(){
    //     $state = '';
    //     if(session('synchronization_insert') == 1) $state = '已同步';
    //     else $state = '未同步';
    //     if($this->request->isPost()){
    //         $addnew=input('post.addnew');
    //         if($addnew=="1"){
    //             $req = Db::query('select id,identity from Loger;');
    //             dump($req);
    //             $count = count($req);
                    
    //             for($i = 0; $i < $count; $i++){
    //                 if($req[$i]['identity'] == '学生'){
    //                     $res_dat=db('Students')->where('id',$req[$i]['id'])->find();
    //                     if($res_dat)continue;
    //                     else
    //                         Db::table('Students') ->data(['id' => $req[$i]['id']]) -> insert();            
    //                     }else{
    //                     $res_dat=db('Employees')->where('id',$req[$i]['id'])->find();
    //                     if($res_dat)continue;
    //                     else
    //                         Db::table('Employees') ->data(['id' => $req[$i]['id']]) -> insert();
    //                 }
    //                 $i++;
    //             }
    //             session('synchronization_insert', 1);//同步状态：YES
    //             $this->success('同步成功');
    //         }
    //     }
    //     $this->assign('state',$state);
    //     // return view();
	// }
	
	public function get_auth_state(){
		$res = [];
		$res = Db::table('un_authority') ->select();
		return $res;
	}
	

}
