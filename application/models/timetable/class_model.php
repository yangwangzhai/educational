<?php
    if (! defined ( 'BASEPATH' ))
        exit ( 'No direct script access allowed' );

    // 作业
    include_once 'content_model.php';
    class class_model extends content_model
    {
        function __construct()
        {
            parent::__construct ();
            $this->table = 'fly_class';
        }

        function update($data)
        {
            foreach($data as $key=>$value){
                if(empty($value['id'])){
                    $this->db->insert($this->table, $value);
                }else{
                    $this->db->where('id', $value['id']);
                    $this->db->update($this->table, $value);
                }

            }
            return 1;
        }

        function get_major_minor($id)
        {
            $sql="select major,minor from $this->table where id=$id";
            $query=$this->db->query($sql);
            return $query->row_array();
        }

        function get_major_one($classname)
        {
            $sql="SELECT major FROM $this->table WHERE classes LIKE '%$classname%'";
            $query=$this->db->query($sql);
            return $query->row_array();
        }




    }