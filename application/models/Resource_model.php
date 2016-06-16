<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 教师教学资源模型
 * @author qcl 2016-01-12
 */
include_once 'content_model.php';
class Resource_model extends content_model {


    function __construct() {
        parent::__construct ();

        $this->table = 'fly_resource';
    }
}
