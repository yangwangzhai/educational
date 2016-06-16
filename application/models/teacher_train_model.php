<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 管理员
include_once 'content_model.php';
class Teacher_train_model extends content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_teacher_train';
    }

    public function rows_query($table)
    {
        $query = $this->db->query("SELECT * FROM $table ");
        return $query->num_rows();
    }









}