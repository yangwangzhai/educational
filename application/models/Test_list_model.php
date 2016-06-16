<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 考试成绩控制器
 * @author qcl 2016-01-11
 */
include_once 'content_model.php';
class Test_list_model extends content_model
{

    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_test_list';
    }
    /**
     * 获取学生奖罚信息
     * @param
     *          多个参数
     * @return array 二维数组
     */

    function get_score($where = '', $offset = 0, $limit = 20)
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
    function count_test_list($where){
        $sql = "SELECT COUNT(*) AS num FROM $this->table WHERE $where";
        $query = $this->db->query ( $sql );
        $value = $query->row_array ();
        return $value ['num'];
    }

    function db_insert_table($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function db_update_table($table, $data, $where=array())
    {
        if (is_numeric($where)) {
            $this->db->where('id', $where);
        } else{
            $this->db->where($where);
        }
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function rows_query($table)
    {
        $query = $this->db->query("SELECT * FROM $table ");
        return $query->num_rows();
    }


}
