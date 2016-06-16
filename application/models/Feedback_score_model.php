<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 教师反馈得分的模型
 * @author qcl 2016-01-05
 */
include_once 'content_model.php';
class Feedback_score_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_feedback_score';
    }
    function updata_by_feedback_id($feedback_id,$data) {
        if (empty($feedback_id))
            return false;

        $this->db->where ('feedback_id',$feedback_id);
        $this->db->update ( $this->table, $data);
        if($this->db->affected_rows ()>=1)
        {
            return true;
            exit;
        }
        return false;
    }

}
