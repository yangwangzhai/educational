<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 打卡记录模型
 * @author qcl 2016-01-06
 */
include_once 'content_model.php';
class Attendance_record_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_attendance_record';
    }

    /**
     *  统计今天当前时间上个月的考勤记录 写入分析表
     * @param $uid
     * @param $date
     * @return mixed
     */
    function get_record_by_teacherid($teacherid,$date)
    {
        //$sql = "SELECT uid,checktime FROM fly_attendance_record WHERE PERIOD_DIFF( date_format('$date' , '%Y%m' ) , date_format( checktime, '%Y%m' ) ) =1";
        $sql = "SELECT uid,checktime FROM fly_attendance_record WHERE teacherid=$teacherid AND date_format('$date' , '%Y%m%d' ) = date_format( checktime, '%Y%m%d' )  ";
        $query = $this->db->query ($sql );
        $value = $query->result_array ();
        return $value;
    }
    /**
     *  统计今天当前时间上个月的考勤记录 写入分析表
     * @param $uid
     * @param $date
     * @return mixed
     */
    function get_one_record($teacherid,$date,$where)
    {
        if($where) $where = " WHERE $where";
        //$sql = "SELECT uid,checktime FROM fly_attendance_record WHERE PERIOD_DIFF( date_format('$date' , '%Y%m' ) , date_format( checktime, '%Y%m' ) ) =1";
        $sql = "SELECT uid,checktime FROM $this->table $where AND date_format('$date' , '%Y%m%d' ) = date_format( checktime, '%Y%m%d' ) AND teacherid=$teacherid ";
        $query = $this->db->query ($sql );
        $value = $query->row_array ();
        return $value;
    }
    /**
     *  统计今天当前时间上个月的考勤记录 写入分析表
     * @param $date
     * @return mixed
     */
    function get_record_by_date($date,$where='')
    {
        if($where) $where = " where $where";
        $sql = "SELECT * FROM $this->table $where AND '$date' = date_format( checktime, '%Y-%m' )";
        $query = $this->db->query ($sql );
        $value = $query->row_array ();
        return $value;
    }
}
