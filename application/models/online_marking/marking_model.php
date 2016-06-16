<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 作业
include_once '/../timetable/content_model.php';
class marking_model extends content_model
{
    function __construct()
    {
        parent::__construct ();
        $this->table = 'fly_marking';
    }

    public function rows_query()
    {
        $schoolid=$this->schoolid;
        $school_type=$this->school_type;
        $query = $this->db->query("SELECT * FROM $this->table WHERE schoolid=$schoolid AND school_type=$school_type");
        return $query->num_rows();
    }

    public function sumscore($id,$column){
        $sql="SELECT SUM($column) as score FROM fly_score WHERE id=$id";
        $query=$this->db->query($sql);
        return $query->row_array();
    }












}