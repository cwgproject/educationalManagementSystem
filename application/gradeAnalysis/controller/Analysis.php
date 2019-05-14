<?php
namespace app\gradeAnalysis\controller;

use think\Controller;
use think\request;
use think\Db;

class Analysis extends Controller
{
    public function gradeAnalysis ($course_id = '1', $class_id  = '1', $stu_id = '1')
    {
        $class = Db::table('unclass')->select();
        $course = Db::table('uncourse')->select();
        $student = Db::table('unstudent')->select();
        $this->assign('course_id', $course_id);
        $this->assign('class_id', $class_id);
        $this->assign('stu_id', $stu_id);

        if ($course_id !== '0') {
            $where['f.course_id'] = $course_id;
        }
        if ($class_id !== '0') {
            $where['b.class_id'] = $class_id;
        }


        $amgrade = Db::table('unmark')
        ->alias('a')
        ->join('unstudent b', 'a.stu_id=b.stu_id ')
        ->join('untest c', 'a.test_id = c.test_id')
        ->join('unteacher d', ' c.tea_id =d.tea_id')
        ->join('unmajor e', 'b.major_id =e.major_id')
        ->join('uncourse f', 'c.course_id =f.course_id')
        ->join('unqbank_type g', 'c.test_type =g.qbank_no')
        ->join('unclass h', 'b.class_id =h.class_id')
        ->field('b.class_id, avg(a.mark) as avg, max(a.mark) as max')
        ->where('f.course_id', $course_id)
        ->group("b.class_id")
        ->select();

        // $max = Db::table('unmark')
        // ->alias('a')
        // ->join('unstudent b', 'a.stu_id=b.stu_id ')
        // ->join('untest c', 'a.test_id = c.test_id')
        // ->join('unteacher d', ' c.tea_id =d.tea_id')
        // ->join('unmajor e', 'b.major_id =e.major_id')
        // ->join('uncourse f', 'c.course_id =f.course_id')
        // ->join('unqbank_type g', 'c.test_type =g.qbank_no')
        // ->join('unclass h', 'b.class_id =h.class_id')
        // ->field('b.class_id, max(a.mark) as max')
        // ->where('f.course_id', $course_id)
        // ->group("b.class_id")
        // ->select();

        // halt($amgrade);
        // halt(json_encode($amgrade));
        if (count($amgrade) !== 0){
            foreach ($amgrade as $key => $val){
                $avg[$key] = $val['avg'];
                $max[$key] = (int)$val['max'];
            }
            $avg1 = array('name' => '平均分', 'data' => $avg);
            $max1 = array('name' => '最高分', 'data' => $max);
            $avgmax = json_encode(array($avg1, $max1));
        }
        else{
            $this->error('没有查到相应成绩！');
        }
        
        // halt(json_encode($avgmax));
        // $avg = array($amgrade[0]['avg'],$amgrade[1]['avg']);
        // halt($avg);


        $ccgrade1 = Db::table('unmark')
        ->alias('a')
        ->join('unstudent b', 'a.stu_id=b.stu_id ')
        ->join('untest c', 'a.test_id = c.test_id')
        ->join('unteacher d', ' c.tea_id =d.tea_id')
        ->join('unmajor e', 'b.major_id =e.major_id')
        ->join('uncourse f', 'c.course_id =f.course_id')
        ->join('unqbank_type g', 'c.test_type =g.qbank_no')
        ->join('unclass h', 'b.class_id =h.class_id')
        ->where($where)
        ->where('a.mark', '<', '60')
        ->count();

        $ccgrade2 = Db::table('unmark')
        ->alias('a')
        ->join('unstudent b', 'a.stu_id=b.stu_id ')
        ->join('untest c', 'a.test_id = c.test_id')
        ->join('unteacher d', ' c.tea_id =d.tea_id')
        ->join('unmajor e', 'b.major_id =e.major_id')
        ->join('uncourse f', 'c.course_id =f.course_id')
        ->join('unqbank_type g', 'c.test_type =g.qbank_no')
        ->join('unclass h', 'b.class_id =h.class_id')
        ->where($where)
        ->where('a.mark', 'between', [60, 70])
        ->count();

        $ccgrade3 = Db::table('unmark')
        ->alias('a')
        ->join('unstudent b', 'a.stu_id=b.stu_id ')
        ->join('untest c', 'a.test_id = c.test_id')
        ->join('unteacher d', ' c.tea_id =d.tea_id')
        ->join('unmajor e', 'b.major_id =e.major_id')
        ->join('uncourse f', 'c.course_id =f.course_id')
        ->join('unqbank_type g', 'c.test_type =g.qbank_no')
        ->join('unclass h', 'b.class_id =h.class_id')
        ->where($where)
        ->where('a.mark', '>', '70')
        ->where('a.mark', '<', '85')
        ->count();

        $ccgrade4 = Db::table('unmark')
        ->alias('a')
        ->join('unstudent b', 'a.stu_id=b.stu_id ')
        ->join('untest c', 'a.test_id = c.test_id')
        ->join('unteacher d', ' c.tea_id =d.tea_id')
        ->join('unmajor e', 'b.major_id =e.major_id')
        ->join('uncourse f', 'c.course_id =f.course_id')
        ->join('unqbank_type g', 'c.test_type =g.qbank_no')
        ->join('unclass h', 'b.class_id =h.class_id')
        ->where($where)
        ->where('a.mark', '>=', '85')
        ->count();

        $total = $ccgrade1 + $ccgrade2 + $ccgrade3 + $ccgrade4;
        if ($total !== 0){
            $grade1 = $ccgrade1*100/$total;
            $grade2 = $ccgrade2*100/$total;
            $grade3 = $ccgrade3*100/$total;
            $grade4 = $ccgrade4*100/$total;
        }
        else{
            $this->error('没有查到相应成绩！');
        }
        // halt($grade4);

        $stugrade = Db::table('unmark')
        ->alias('a')
        ->join('unstudent b', 'a.stu_id=b.stu_id ')
        ->join('untest c', 'a.test_id = c.test_id')
        ->join('unteacher d', ' c.tea_id =d.tea_id')
        ->join('unmajor e', 'b.major_id =e.major_id')
        ->join('uncourse f', 'c.course_id =f.course_id')
        ->join('unqbank_type g', 'c.test_type =g.qbank_no')
        ->join('unclass h', 'b.class_id =h.class_id')
        ->field('h.class_name, b.stu_name, b.stu_rollno, f.course_name, a.mark')
        ->where('b.stu_id', $stu_id)
        ->select();


        $this->assign('class', $class);
        $this->assign('course', $course);
        $this->assign('student', $student);
        $this->assign('avgmax', $avgmax);
        $this->assign('grade1', $grade1);
        $this->assign('grade2', $grade2);
        $this->assign('grade3', $grade3);
        $this->assign('grade4', $grade4);
        $this->assign('stugrade', $stugrade);
        return $this->fetch();
    }
}