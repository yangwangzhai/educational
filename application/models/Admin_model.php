<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 管理员模型
 * @author qcl 2016-01-06
 */
include_once 'content_model.php';
class Admin_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_admin';
    }

    /**
     * 获取根据管理员名字管理信息
     * @param $username
     * @return mixed
     */

    function get_admin_by_username($username)
    {
        $this->db->where('username',$username);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
    /**
     * 为一组信息 加上管理员的姓名，用于教师请教
     *
     * @param $ids array
     * @return array
     */
    function append_list($list) {
        if (isset ( $list [0] ['aid'] )) {
            foreach ( $list as &$r ) {
                $this->db->select('truename');
                $this->db->where('id',$r['aid']);
                $query=$this->db->get($this->table);
                $result = $query->row_array ();
                if($result)
                {
                    $r ['adminname']=$result['truename'];
                }
               else
               {
                   $r ['adminname']='自己';
               }

            }
        }
        return $list;
    }

    function get_notice_list($column,$table,$where=''){
        $query = $this->db->query ( "select $column from $table  $where" );
        return $value = $query->result_array();

    }



}
