<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
/*
 * 主管教学测评
 * @author qcl 2016-01-06
 */
include_once 'content_model.php';
class Classroom_manage_model extends Content_model
{

    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_classroom_check';
    }

    public function rows_query()
    {
        $table='fly_classroom_check';
        $query = $this->db->query("SELECT * FROM $table ");
        return $query->num_rows();
    }
















}