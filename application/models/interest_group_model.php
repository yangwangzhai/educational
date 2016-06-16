<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 兴趣小组模型
 * @author qcl 2016-01-12
 */
include_once 'content_model.php';
class Interest_group_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_interest_group';
    }
}
