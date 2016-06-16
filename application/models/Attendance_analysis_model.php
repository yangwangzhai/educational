<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 管理员
include_once 'content_model.php';
class Attendance_analysis_model extends content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_attendance_analysis';
    }
    /**
     * 获取教师薪酬的信息
     * @param
     *          多个参数
     * @return array 二维数组
     */

    function get_attendance_analysis($teacherid,$date, $where = '')
    {
        if($where) $where = " AND $where";
        $sql = "SELECT count(state) AS num,state,teacherid FROM $this->table  where teacherid=$teacherid AND '$date' = date_format(pubdate, '%Y-%m' ) $where GROUP BY `state` ORDER BY state ASC ";
        $query = $this->db->query ( $sql );
        return $query->result_array ();
    }
    /**
     *  统计今天当前时间上个月的考勤记录 写入分析表
     * @param $date
     * @return mixed
     */
    function get_analysis_by_date($date,$where='')
    {
        if($where) $where = " where $where";
        $sql = "SELECT * FROM $this->table $where AND '$date' = date_format( pubdate, '%Y-%m' )";
        $query = $this->db->query ($sql );
        return $query->row_array ();

    }
    /**
     * 获取一条信息
     *
     * @param int $uid
     * @param $meal
     * @param $pubdate
     * @return array 一维数组
     */
    function get_one_analysis($teacherid,$set_title,$pubdate) {
        $this->db->where ('teacherid', $teacherid );
        $this->db->where ( 'set_title', $set_title);
        $this->db->where ( 'pubdate', $pubdate);
        $query = $this->db->get ( $this->table );
        return $query->result_array ();
    }
    /**
     *  统计今天当前时间上个月的考勤记录 写入分析表
     * @param $date
     * @return mixed
     */
    function delete_analysis_by_date($date,$where='')
    {
        if($where) $where = " where $where";
        $sql = "DELETE FROM $this->table $where AND '$date' = date_format( pubdate, '%Y-%m' )";
        $this->db->query ($sql );
        return $this->db->affected_rows ();
    }
}
