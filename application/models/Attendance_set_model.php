<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 考勤休息天设置模型
 * @author qcl 2016-01-06
 */
include_once 'content_model.php';
class Attendance_set_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_attendance_set';
    }
    /**
     * 获取一条信息
     *
     * @param int $uid
     * @param $meal
     * @param $pubdate
     * @return array 一维数组
     */
    function get_one_set($teacherid,$set_title,$dodate) {
        $this->db->where ('teacherid', $teacherid );
        $this->db->where ( 'set_title', $set_title);
        $this->db->where ( 'dodate', $dodate);
        $query = $this->db->get ( $this->table, 1 );
        return $query->row_array ();
    }
    /**
     * 获取一条信息
     *
     * @param int $uid
     * @param $dodate
     * @return array 一维数组
     */
    function get_set_by_teacherid($teacherid,$dodate) {
        $this->db->where ('teacherid', $teacherid );
        $this->db->where ( 'dodate', $dodate);
        $this->db->order_by('set_title');
        $query = $this->db->get ( $this->table);
        return $query->result_array ();
    }
}
