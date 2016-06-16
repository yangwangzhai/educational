<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 作业
include_once 'content_model.php';
class course_plan_model extends content_model
{
    function __construct()
    {
        parent::__construct ();
        $this->table = 'fly_course_plan';
    }

    function teacher_name($classname,$course){
        $sql="SELECT m.truename FROM fly_member m,fly_teacher t WHERE m.id=t.id AND (manage_class LIKE '%$classname%' OR teach_class LIKE '%$classname%') AND
                 course LIKE '%$course%'";
        $query=$this->db->query($sql);
        return $query->result_array();
    }

    //插入的是二维数组
    function insert_plan($data)
    {
        foreach($data as $value){
            $this->db->insert($this->table, $value);
        }
        return 1;

    }

    function update_plan($data)
    {
        foreach($data as $key=>$value){
            $this->db->where('id', $value['id']);
            $this->db->update($this->table, $value);
        }
        return 1;
    }













}