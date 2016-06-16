<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 学生
include_once 'content_model.php';
class Student_model extends content_model
{

    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_student';
    }
    /**
     * 为一组信息 加上学生的姓名、班级
     *
     * @param $ids array
     * @return array
     */
    function append_list($list) {
        if (isset ( $list [0] ['studentid'] )) {
            foreach ( $list as &$r ) {
                $this->db->select('name,classid');
                $this->db->where('id',$r['studentid']);
                $query=$this->db->get($this->table);
                $result = $query->row_array ();
                if($result)
                {
                    $r ['studentname']=$result['name'];
                    $r ['classid']=$result['classid'];
                }
                else
                {
                    $r ['studentname']='';
                }
            }
        }
        return $list;
    }
    /**
     * 为一组信息 加上学生的信息用于编辑
     *
     * @param $ids array
     * @return array
     */
    function append_item($list) {
        if (isset ( $list['studentid'] )) {
            $this->db->select('name,classid');
            $this->db->where('id',$list['studentid']);
            $query=$this->db->get($this->table);
            $result = $query->row_array ();
            if($result)
            {
                $list ['studentname']=$result['name'];
                $list ['classid']=$result['classid'];
            }
        }
        return $list;
    }
    /**
     *根据班级id获取学生的信息
     * @param int $classid
     * return array
     */
    function get_student_by_classid($classid)
    {
        $this->db->select('id,name');
        $this->db->where('classid',$classid);
        $this->db->order_by('name','asc');
        $query=$this->db->get($this->table);
        return $query->result_array();
    }
    function get_ids_by_classid($classid)
    {
        $this->db->select('id');
        $this->db->where('classid',$classid);
        $query=$this->db->get($this->table);
        $result=$query->result_array();
        foreach($result as $item)
        {
            $ids[]=$item['id'];
        }
        return $ids;
    }
    /**
     *根据班级id获取学生的信息
     * @param int $name
     * return array
     */
    function get_student_by_name($name)
    {
        $this->db->select('id,name,classid');
        $this->db->where('name',$name);
        $query=$this->db->get($this->table);
        return $query->row_array();
    }
    /*
    * 幼儿择园原因统计
    * @param $schoolid
    */
    function statistic_reason($where)
    {
        if($where) $where="WHERE $where";
        $sql = "SELECT COUNT(*) AS num,reason FROM $this->table $where  GROUP BY reason";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
    * 幼儿离园统计
    * @param $schoolid
    */
    function statistic_leaving($where)
    {
        if($where) $where="WHERE $where";
        $sql = "SELECT COUNT(*) AS num,leaving FROM $this->table $where AND `status`=2 GROUP BY leaving";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
}
