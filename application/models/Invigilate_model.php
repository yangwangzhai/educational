<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
/*
 * 主管教学测评
 * @author qcl 2016-01-06
 */
include_once 'content_model.php';
class Invigilate_model extends Content_model
{
    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_invigilate';
    }

    public function rows_query()
    {
        $table='fly_invigilate_list';
        $query = $this->db->query("SELECT * FROM $table ");
        return $query->num_rows();
    }












}