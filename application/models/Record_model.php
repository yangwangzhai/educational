<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 管理员
include_once 'content_model.php';
class Record_model extends content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_record';
    }
}
