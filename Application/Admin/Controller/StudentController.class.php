<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 16/9/11
 * Time: 下午5:13
 */

namespace Admin\Controller;

use Admin\Model;
use Think;
use Think\Controller;
class StudentController extends Controller
{
    public function studentTemp($method=''){
        //查询student_temp表和department表
        $studentTempView=D('StudentTempView');
        $count=$studentTempView->count();
        $p=new Think\Page($count,10);
        $show=$p->show();
        if($method=='examine'){
            $wheres['status']=1;
        }
        if($method=='unaudited'){
            $wheres['status']=0;
        }
        if(isset($wheres)){
            $list = $studentTempView->where($wheres)->limit($p->firstRow, $p->listRows)->select();
        }else{
            $list = $studentTempView->limit($p->firstRow, $p->listRows)->select();
        }

        $this->assign('alist',$list);
        $this->assign('page',$show);
        $this->assign('title','成员审核');
        $this->display();
    }
    /*
     * 审核处理函数
     *
     * !!!!!!!!!!注意 加入审核人 操作者的id 注意!!!!!!!!!!
     */
    public function setStudentTemp(){
        if(isset($_POST['data'])&&isset($_POST['method'])){
            $studentTemp=D('StudentTemp');
            $str=$_POST['data'];
            $method=$_POST['method'];
            $arr=explode(',',$str);
            if($method=='examine'){
                //审核操作
                //数组循环操作
                foreach ($arr as $value){
                    $da['status']='1';
                    if(!$res=$studentTemp->where("student_id=$value")->save($da)){
                        $data['error']=$res+',';
                    }
                }
                $data['status']='true';
                $data['result']='审核成功';
                $this->ajaxReturn($data,'json',1);
            }
            if($method=='unaudited'){
                //取消审核操作
                //数组循环操作
                foreach ($arr as $value){
                    $da['status']='0';
                    if(!$res=$studentTemp->where("student_id=$value")->save($da)){
                        $data['error']=$res+',';
                    }
                }
                $data['status']='true';
                $data['result']='取消成功';
                $this->ajaxReturn($data,'json',1);
            }
        }//判断提交数据是否讯在结束
    }//setStudentTemp()方法结束
}//类结束