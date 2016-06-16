<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 资源附件控模型
 * @author qcl 2016-01-11
 */
include_once 'content_model.php';
class Resource_attachments_model extends Content_model
{

    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_resource_attachments';
    }
    public function update_token($token,$data)
    {
        $this->db->where('token',$token);
        $this->db->update($this->table,$data);
        $affect=$this->db->affected_rows();
        if($affect>=1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
