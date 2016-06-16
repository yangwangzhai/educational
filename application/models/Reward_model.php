<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 奖罚信息模型
 * @ author qcl 2016-01-07
 */
include_once 'content_model.php';
class Reward_model extends content_model
{

    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_reward';
    }
}
