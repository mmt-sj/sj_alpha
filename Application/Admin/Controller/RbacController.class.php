<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 16/9/13
 * Time: 下午5:17
 */

namespace Admin\Controller;


use Think\Controller;
use Think;
class RbacController extends Controller
{
    public function index(){

        $role=D('role');
        $count=$role->count();
        $p=new Think\Page($count,10);
        $show=$p->show();
        $list=$role->limit($p->firstRow,$p->listRows)->select();
        $this->assign('title','角色管理');
        $this->assign('alist',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function add(){
        $role=D('role');
        if($res=$role->create()){
            $res['create_time']=date("Y-m-d H:i:s",time());
            if($role->add($res)){
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

    public function del(){
        $role=D('role');
        if(isset($_POST['id'])){
            $id=$_POST['id'];
            if($id==1){
                $data['status']='false';
                $data['result']='超级管理员不能删除';
                $this->ajaxReturn($data,'json',0);
            }else{
                if($role->where("id=$id")->delete()){
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
            $data['result']='没有找到';
            $this->ajaxReturn($data,'json',0);
        }
    }

    public function edit(){
        $role=D('role');
        if(isset($_POST['id'])){
            $id=$_POST['id'];
            if($id==1){
                $data['status']='false';
                $data['result']='超级管理员不能修改';
                $this->ajaxReturn($data,'json',0);
            }else{
                if($role->create()){
                    if($role->save()){
                        $data['status']='true';
                        $data['result']='修改成功';
                        $this->ajaxReturn($data,'json',1);
                    }else{
                        $data['status']='false';
                        $data['result']='修改失败';
                        $this->ajaxReturn($data,'json',0);
                    }
                }else{
                    $data['status']='false';
                    $data['result']='创建修改失败';
                    $this->ajaxReturn($data,'json',0);
                }
            }
        }else{
            $data['status']='false';
            $data['result']='不存在';
            $this->ajaxReturn($data,'json',0);
        }
    }

    public function setPermissions(){

    }
}