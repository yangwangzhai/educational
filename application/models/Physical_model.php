<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 体质健康模型
 * @author qcl 2016-01-11
 */
include_once 'content_model.php';
class Physical_model extends Content_model
{

    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_physical';
    }
    /**
     * 获取学生的体检的信息
     * @param
     *          多个参数
     * @return array 二维数组
     */

    function get_physical($where = '', $offset = 0, $limit = 20)
    {
        if($where) $where = " AND $where";
        $sql = "SELECT a.*,b.name,b.gender,b.birthday,b.classid FROM $this->table a ,fly_student b where a.studentid=b.id $where ORDER BY a.pubdate DESC limit $offset,$limit";
        $query = $this->db->query ( $sql );
        return $query->result_array ();
    }
    /**
     * 获取学生的体检的信息
     * @param $id
     *
     * @return array 数组
     */

    function get_physical_by_id($id)
    {
        $sql = "SELECT a.*,b.thumb,b.gender,b.name,b.birthday,b.nation,b.classid,b.place FROM $this->table a ,fly_student b where a.studentid=b.id AND a.id=$id ";
        $query = $this->db->query ( $sql );
        return $query->row_array ();
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
