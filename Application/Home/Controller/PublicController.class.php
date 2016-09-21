<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 16/9/9
 * Time: 下午2:34
 */

namespace Home\Controller;


use Think\Controller;

class PublicController extends  Controller
{
    public function success()
    {
        if(isset($_GET['message'])){
            $message=$_GET['message'];
            $this->assign('message',$message);
        }
        $this->display();
    }

}