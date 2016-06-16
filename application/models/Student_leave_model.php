<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 学生请假模型
 * @author qcl 2016-01-12
 */
include_once 'content_model.php';
class Student_leave_model extends Content_model
{

    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_student_leave';
    }
}
