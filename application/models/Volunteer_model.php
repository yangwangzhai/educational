<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 义工
include_once 'content_model.php';
class Volunteer_model extends content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_volunteer';
    }
    public function get_volunteer_by_type($schoolid)
    {
        $data=array();
        foreach(config_item('volunteer_type') as $k=>$v)
        {
            $this->db->where('schoolid',$schoolid);
            $this->db->where('volunteer_type',$k);
            $query=$this->db->get($this->table);
            $data[$k]=$query->result_array();
        }
        return $data;
    }
}
