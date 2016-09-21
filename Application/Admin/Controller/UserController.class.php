<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 16/9/18
 * Time: 上午10:47
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Page;
class UserController extends Controller
{
    public function index(){
        //初始化数据
        $adminView=D('AdminView');
        $count=$adminView->count();
        $p=new Page($count,10);
        $show=$p->show();
        $list=$adminView->order('id')->limit($p->firstRow,$p->lastRows)->select();


        $this->assign('alist',$list);
        $this->assign('page',$show);
        $this->assign('title','管理员管理');
        $this->display();
    }
    public function del(){
        $admin=D('Admin');
        //有操作记录的管理员不能删除
        if(isset($_POST['id'])){
            $id=$_POST['id'];
            if($id==1){
                $data['status']='false';
                $data['result']='超级管理员不能被删除';
                $this->ajaxReturn($data,'json',0);
            }else{
                if($admin->where("id=$id")->delete()){
                    $data['status']='true';
                    $data['result']='删除成功';
                    $this->ajaxReturn($data,'json',1);
                }else{
                    $data['status']='false';
                    $data['result']='删除失败';
                    $this->ajaxReturn($data,'json',0);
                }
            }
        }else{
            $data['status']='false';
            $data['result']='不存在';
            $this->ajaxReturn($data,'json',0);
        }
    }
    public function add(){
        $role=D('Role');
        $roles=$role->where('status=1')->select();
        $this->assign('rolelist',$roles);
        $this->display();
    }
    public function add_post(){
        $admin=D('Admin');
        if($getData=$admin->create()){
            $getData['password']=md5($getData['password']);
            if($admin->add($getData)){
                $data['status']='true';
                $data['result']='添加成功';
                $this->ajaxReturn($data,'json',1);
            }else{
                $data['status']='false';
                $data['result']='添加失败';
                $this->ajaxReturn($data,'json',0);
            }
        }else{
            $data['status']='false';
            $data['result']='创建失败';
            $this->ajaxReturn($data,'json',0);
        }
    }
    public function edit(){
        if(isset($_GET['id'])){
            $id=$_GET['id'];
            $role=D('Role');
            $roles=$role->where('status=1')->select();
            $this->assign('rolelist',$roles);
            $admin=D('Admin');
            if($res=$admin->where("id=$id")->find()){
                $this->assign('alist',$res);
                $this->display();
            }else{
                $this->error('访问出错');
            }
        }else{

        }
    }
    public function edit_post(){
        if(IS_POST){
            $id=$_POST['id'];
            $mydata['name']=$_POST['name'];
            $mydata['status']=$_POST['status'];
            $mydata['role_id']=$_POST['role_id'];
            if(strlen($_POST['password'])>5){
                $mydata['password']=md5($_POST['password']);
            }
            $admin=D('Admin');
            if($admin->where("id=$id")->save($mydata)){
                $data['status']='true';
                $data['result']='修改成功';
                $this->ajaxReturn($data,'json',1);

            }else{
                $data['status']='false';
                $data['result']='修改失败';
                $this->ajaxReturn($data,'json',1);
            }

        }
    }

    public function issetAccount(){
        if(isset($_POST['account'])){
            $account=$_POST['account'];
            $admin=D('Admin');
            $wheres['account']=$account;
            if(!$admin->where($wheres)->find()){
                echo '{"valid":true}';
            }else{
                echo '{"valid":false}';
            }
        }
    }


}