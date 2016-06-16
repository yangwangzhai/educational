<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 作业
include_once 'content_model.php';
class rule_model extends content_model
{
    function __construct()
    {
        parent::__construct ();
        $this->table = 'fly_rule';
    }

    function update($rule,$data)
    {
        foreach($rule as $key=>$value){
            $sql="update fly_rule set rule_value=$data[$key] WHERE rule_key='$value'";
            $query=$this->db->query($sql);
        }
        return 1;
    }



















}