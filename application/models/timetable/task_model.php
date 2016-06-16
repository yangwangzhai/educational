<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 作业
include_once 'content_model.php';
class task_model extends content_model
{
    function __construct()
    {
        parent::__construct ();
        $this->table = 'fly_task';
    }

    public function rows_query()
    {
        $schoolid=$this->schoolid;
        $school_type=$this->school_type;
        $query = $this->db->query("SELECT * FROM $this->table WHERE schoolid=$schoolid AND school_type=$school_type");
        return $query->num_rows();
    }

    public function copy_table($column,$table,$where,$term){
        $table_message=$this->task_model->get_column($column,$table,$where);//获取要复制的信息,二维数组
        //更改字段term的值为新表的值
        foreach($table_message as $key=>$value){
            $value['term']=$term;
            unset($value['id']);    //销毁id，添加时候会自动生成
            $this->task_model->db_insert_table($table,$value);
        }

    }














}