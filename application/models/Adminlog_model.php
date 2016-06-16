<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 管理员登录日志
 * @author qcl 2016-01-06
 */
include_once 'content_model.php';
class Adminlog_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_adminlog';
    }
}
