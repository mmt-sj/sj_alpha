<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
        if(IS_POST){
            $this->assign('jumpUrl',U('Home/Public/success'));
            $this->success('操作');
        }
    }

    /**
     * this is method will show a join us form page (go to View/Index/jpin.html)
     */
    public function join(){

        $this->assign('title','欢迎加入我们');

        $department=D('Department');
        $list=$department->select();
        $this->assign('alist',$list);
        $this->display();
        if(IS_POST){
            $studentTemp=M('StudentTemp');
            $studentNumber=$_POST['student_number'];
            //find this student_number
            $where['student_number']=$studentNumber;
            $result=$studentTemp->where($where)->select();
            if(!$result){
                if($datas=$studentTemp->create()){
                    $datas['create_time']= date("Y-m-d H:i:s",time());
                    $studentTemp->add($datas);
                    $data['status']='true';
                    $this->ajaxReturn($data,'json',1);
                }else{
                    $data['status']='false';
                    $this->ajaxReturn(0,'json',0);
                }
            }else{
                $data['status']='false';
                $this->ajaxReturn(0,'json',0);
            }
        }
    }
    /*
     * 判断
     */
    public function existStudentNumber(){
        if(IS_POST){
            $studentTemp=M('StudentTemp');
            $studentNumber=$_POST['student_number'];
            //find this student_number
            $where['student_number']=$studentNumber;
            $result=$studentTemp->where($where)->select();
            if(!$result){
                echo '{"valid":true}';
            }else{
                echo '{"valid":false}';
            }
        }
    }
}