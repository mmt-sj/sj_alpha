<?php
namespace Admin\Model;
use Think\Model\ViewModel;

/**
 * Created by PhpStorm.
 * User: ly
 * Date: 16/9/11
 * Time: 下午6:07
 */
class studentTempViewModel extends ViewModel
{
    public $viewFields=array(
        'student_temp'=>array('student_id','student_name','student_sex','student_number','phone','argument','create_time','status'),
        'department'=>array('department_name','_on'=>'student_temp.department_id=department.department_id'),
    );
}