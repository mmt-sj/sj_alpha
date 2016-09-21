<?php
/**
 * Created by PhpStorm.
 * User: ly
 * Date: 16/9/18
 * Time: 下午3:52
 */

namespace Admin\Model;


use Think\Model;

class AdminViewModel extends Model\ViewModel
{
    public $viewFields=array(
        'admin'=>array('id','name','account','password','status','update_time','role_id','client_ip','login_count'),
        'role'=>array('name'=>'role_name','_on'=>'admin.role_id=role.id'),
    );
}