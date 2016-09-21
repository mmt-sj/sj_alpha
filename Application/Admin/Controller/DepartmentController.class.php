<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 16/9/10
 * Time: 下午3:53
 */

namespace Admin\Controller;

use Think\Controller;
use Think;


class departmentController extends Controller
{
    /*
   * 院系管理
   * 增删改查
   * 名称
   * 操作,增删改
   */
    public function index(){

        $department=D('Department');
        $count=$department->count();
        //分页
        $p=new Think\Page($count,10);
        $show=$p->show();
        $list=$department->limit($p->firstRow,$p->listRows)->select();
        $this->assign('alist',$list);//赋值数据集
        $this->assign('page',$show);//赋值分页输出
        $this->display();
    }
    //删除
    function del(){
        $department=D('Department');
        if(isset($_POST['department_id'])){
            $id=$_POST['department_id'];
            $studentTemp=D('StudentTemp');
            if ($studentTemp->where("department_id=$id")->find()){
                $data['result']='该院系有学生使用不能删除';
                $data['status']='false';
                $this->ajaxReturn($data,'json',0);
            }
            if($vo=$department->delete($id)){
                $data['result']=$vo;
                $data['status']='true';
                $this->ajaxReturn($data,'json',1);
            }else{
                $this->ajaxReturn(0,'json',0);
            }
        }else{
            //echo $this->error($department->getError());
        }
    }
    //增加
    function add(){
        $department=D('Department');
        if($vo=$department->create()){
            $vo['create_time']= date("Y-m-d H:i:s",time());
            if($res=$department->add($vo)){
                $data['department_id']=$res;
                $data['status']='true';
                $this->ajaxReturn($data,'json',1);
            }else{
                $this->ajaxReturn(0,'json',0);
            }
        }else{
            //echo $this->error($department->getError());
        }
    }
    //编辑
    function update(){
        $department=D('Department');
            if($vo=$department->create()){
                if($lineNum=$department->save()){
                    $data['status']='true';
                   $this->ajaxReturn($data,'json',1);
                }else{
                    $this->ajaxReturn(0,'修改失败',0);
                }
            }else{
                //echo $this->error($department->getError());
            }
    }
    function issetDepartmentName(){
        if(IS_POST){
            $department=D('Department');
            $departmentName=$_POST['department_name'];
            //find this student_number
            $where['department_name']=$departmentName;
            $result=$department->where($where)->select();
            if(!$result){
                echo '{"valid":true}';
            }else{
                echo '{"valid":false}';
            }
        }
    }
}