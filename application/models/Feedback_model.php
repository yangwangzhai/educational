<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 家长反馈模型
 * @author qcl 2016-01-05
 */
include_once 'content_model.php';
class Feedback_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_feedback';
    }
    /*
    * 教师部门统计
    * @param $schoolid
    */
    function statistic($schoolid,$date)
    {
        $sql = "SELECT COUNT(*) AS num,feedback_type FROM $this->table WHERE schoolid=$schoolid AND DATE_FORMAT(feedback_date,'%Y-%m')='$date' GROUP BY feedback_type";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
}
