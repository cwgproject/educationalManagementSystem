<?php
namespace app\announcement\controller;

class Announcement extends Common
{// 这个是公告管理的控制器
    public function announce_add(){
        $id=input('param.id');
        $ndate =date("Y-m-d");
        if($this->request->isPost()){ // 实现修改
            $addnew=input('post.addnew');
            if ($addnew=="1" ){
                $add_dat=array();
                $add_dat['id']=input('post.id');
                $add_dat['name']=input('post.name');
                $add_dat['announceDate']=input('post.announcedate');                
                $add_dat['fileRote']=input('post.filerote');
                $add_dat['content']=input('post.content');

                $res=db('Announcement')->insert($add_dat);
                $this->success('操作成功！');
            }
        }
        $str=$this->makecode3(); //
        $this->assign('str',$str); //
        $this->assign('id',$id);
        $this->assign('ndate',$ndate);
        return view();
    }


    public function upfile(){
        $Result=input('param.Result');
        if($this->request->isPost()){ 
            $exname=strtolower(substr($_FILES['upfile']['name'],(strrpos($_FILES['upfile']['name'],'.')+1)));//获取文件名去掉.jpg之类的东西
            $uploadfile = $this->getname($exname);
            if (move_uploaded_file($_FILES['upfile']['tmp_name'], $uploadfile['r1'])) {  //通过move_uploaded_file函数把文件移动到$uploadfile['r1']的位置，即/public/static/uploadfile/目录下
                echo "<font color=#ff0000>成功</font>"; 
                echo "<input name='CopyPath' type='button' class='button' value='拷贝路径'  onclick=CopyPath('uploadfile/{$uploadfile['r2']}','".$Result."')>";
            }
        }
 
        $this->assign('Result',$Result);
        return view();
    }

    public function getname($exname){ 
        $dir = ROOT_PATH."/public/static/uploadfile/"; //获取服务器根目录下的路径
        $i=1;
        $str = "0123456789abcdefghijklmnopqrstuvwxyz";   //   输出字符集
        $n = 4;   //   输出串长度
        $len = strlen($str)-1; 
        $s='';
        for($i=0 ; $i<$n; $i++){
            $s .=  $str[rand(0,$len)];  //把str[]合并到s的尾部
        }
        $timestamp=time();
        $res=array();
        $res['r1']=$dir.$timestamp.$s.".".$exname;//生成路径+时间+字符 . +参数 的值
        $res['r2']=$timestamp.$s.".".$exname;//时间+字符+ . +参数 的值
        return $res; 
    }

    public function announce_list(){
        $db=db('Announcement');
        $data=array();
        $data['paixu']=input('post.paixu')?input('post.paixu'):'id';
        $data['px']=input('post.px')?input('post.px'):'desc';
        $data['db']=$db;
        $data['pagelarge']=10; //每页行数;
        $data['pagecurrent']=input('param.pagecurrent')?input('param.pagecurrent'):1; //当前页数;


        $data['field']=array();
        $id=input('post.id');
        $data['field']['id']=array('like',"%$id%");
        $name=input('post.name');
        $data['field']['name']=array('like',"%$name%");

        $data['field_dat']=array();
        $data['field_dat']['id']=input('post.id');
        $data['field_dat']['name']=input('post.name');

        $dat=$this->get_list($data);

        $this->assign('data',$dat);

        return view();
    }



    public function announce_detail(){
        $id=input('param.id');
        $dat=db('Announcement')->where('id',$id)->find();
        $this->assign('dat',$dat);
        return view();
    }

    public function fannounce_list(){
        $db=db('Announcement');
        $data=array();
        $data['paixu']=input('post.paixu')?input('post.paixu'):'id';
        $data['px']=input('post.px')?input('post.px'):'desc';
        $data['db']=$db;
        $data['pagelarge']=10; //每页行数;
        $data['pagecurrent']=input('param.pagecurrent')?input('param.pagecurrent'):1; //当前页数;


        $data['field']=array();
        $id=input('post.id');
        $data['field']['id']=array('like',"%$id%");
        $name=input('post.name');
        $data['field']['name']=array('like',"%$name%");

        $data['field_dat']=array();
        $data['field_dat']['id']=input('post.id');
        $data['field_dat']['name']=input('post.name');

        $dat=$this->get_list($data);

        $this->assign('data',$dat);

        return view();
    }
 

    
    public function download(){
        $id = input('param.id');
        $file = db('Announcement')->find($id);
        $file_path = $file['fileRote'];
        $file_dir = ROOT_PATH . 'public' . DS . 'static/' . $file_path;    // 下载文件存放目录
        echo "fileanme is " . $file_path;
        echo "file path is ". $file_dir;
        // 检查文件是否存在
        if (! file_exists($file_dir) ) {
            $this->error('文件未找到');
        }else{
            // 打开文件
            $file1 = fopen($file_dir, "r");
            // 输入文件标签
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length:".filesize($file_dir));
            Header("Content-Disposition: attachment;filename=" . $file_dir);
            ob_clean();     // 重点！！！
            flush();        // 重点！！！！可以清除文件中多余的路径名以及解决乱码的问题：
            //输出文件内容
            //读取文件内容并直接输出到浏览器
            echo fread($file1, filesize($file_dir));
            fclose($file1);
            exit();
        }


    }
}
