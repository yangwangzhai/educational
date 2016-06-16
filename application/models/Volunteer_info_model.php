<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 义工
include_once 'content_model.php';
class Volunteer_info_model extends content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_volunteer_info';
    }
    /**
     * 获取一组信息,整理后，可通过id 获取 班级名称
     *
     * @param $schoolid
     *        	多个参数
     * @return array 二维数组
     */
    function get_field($schoolid,$parentid) {
        $list = $this->get_list('volunteer_id',"schoolid=$schoolid AND parentid=$parentid");
        $result = array();
        foreach($list as $key=>$value) {
            $result[$key] = $value['volunteer_id'];
        }
        return $result;
    }
    function delete_by_parentid($parentid)
    {
        $this->db->where('parentid', $parentid);
        $this->db->delete($this->table);
        return $this->db->affected_rows ();
    }
    function get_volunteer_info($where, $offset = 0, $limit = 20)
    {
        if($where) {
            $where = "where $where";
        }
        $sql = "SELECT COUNT(*) AS num,parentid FROM $this->table $where GROUP BY parentid ORDER BY num desc limit $offset,$limit";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }

    function get_volunteer_info_count($schoolid)
    {
        $sql = "SELECT COUNT(*) AS num,parentid FROM $this->table WHERE schoolid=$schoolid GROUP BY parentid";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return count($value);
    }
    /**
     * 为一组信息 加上家长的姓名
     *
     * @param $ids array
     * @return array
     */
    function append_list($list) {
        if (isset ( $list [0] ['id'] )) {
            foreach ( $list as &$r ) {
                $this->db->select('volunteer_id');
                $this->db->where('parentid',$r['id']);
                $query=$this->db->get($this->table);
                $result = $query->result_array ();
                $re=array();
                foreach($result as $k=>$item)
                {
                    $this->db->select('title');
                    $this->db->where('id',$item['volunteer_id']);
                    $query=$this->db->get('fly_volunteer');
                    $re[$k]= $query->row_array ()['title'];
                }
                $r['volunteer']=implode(',',$re);
            }
        }
        return $list;
    }
}
