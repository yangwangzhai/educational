<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// timetable
include_once 'content_model.php';
class warning_model extends content_model {

    function __construct() {
        parent::__construct ();
        $this->table = 'fly_warning';
    }

    function get_warning($section,$week,$grade,$classname,$schoolid,$term,$school_type)
    {
        $sql="select warning_mession from $this->table WHERE section=$section AND week=$week AND grade='$grade' AND classname='$classname' AND schoolid=$schoolid AND term=$term AND school_type=$school_type";
        $query=$this->db->query($sql);
        return $query->result_array();
    }

    function delete_warning($section,$week,$classname,$schoolid,$term,$school_type)
    {
        $sql="delete from $this->table WHERE section=$section AND week=$week AND classname=$classname AND schoolid=$schoolid AND term=$term AND school_type=$school_type";
        return $query=$this->db->query($sql);
    }





}
