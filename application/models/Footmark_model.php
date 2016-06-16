<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 成长记录
 * @author qcl 2016-01-12
 */
include_once 'content_model.php';
class Footmark_model extends Content_model
{

    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_footmark';
    }
    /**
     * 获取学生的学期表现的信息
     * @param
     *          多个参数
     * @return array 二维数组
     */

    function get_footmark($where = '', $offset = 0, $limit = 20)
    {
        if($where) $where = " AND $where";
        $sql = "SELECT a.*,b.name FROM $this->table a ,fly_student b where a.studentid=b.id $where ORDER BY a.addtime DESC limit $offset,$limit";
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
    /**
     * 获取某个学生的学期表现
     *
     * @param int $id
     * @return array 数组
     */
    function get_footmark_by_studentid($studentid) {
        $this->db->where ('studentid', $studentid );
        $this->db->order_by('semester','desc');
        $query = $this->db->get( $this->table);
        return $query->result_array ();
    }
}
