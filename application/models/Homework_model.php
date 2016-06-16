<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 作业成绩控制器
 * @author qcl 2016-01-11
 */
include_once 'content_model.php';
class Homework_model extends Content_model
{

    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_homework';
    }
    /**
     * 获取学生奖罚信息
     * @param
     *          多个参数
     * @return array 二维数组
     */

    function get_homework($where = '', $offset = 0, $limit = 20)
    {
        if($where) $where = " AND $where";
        $sql = "SELECT a.*,b.name,b.classid FROM $this->table a ,fly_student b where a.studentid=b.id $where ORDER BY a.id DESC limit $offset,$limit";
        $query = $this->db->query ( $sql );
        return $query->result_array ();
    }
    /**
     *  查询记录条数
     *
     * @param string $where
     * @return array 二维数组
     */
    function counts($where='') {
        if($where) {
            $where = " AND $where";
        }

        $sql = "SELECT COUNT(*) AS num FROM $this->table a, fly_student b where a.studentid=b.id $where";
        $query = $this->db->query ( $sql );
        $value = $query->row_array ();
        return $value ['num'];
    }
}
