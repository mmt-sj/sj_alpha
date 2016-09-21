<?php

/**
 * Created by PhpStorm.
 * User: ly
 * Date: 16/9/1
 * Time: 下午2:23
 */
namespace Home\Model;

use Think\Model;

class StudentTempModel extends Model
{
    protected $_validate=array(

    );//自动验证

    protected $_auto=array(
        array('create_time','time',self::MODEL_INSERT,'function'),
    );//自动填充
}