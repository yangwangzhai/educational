<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 管理员
include_once 'content_model.php';
class Train_num_model extends content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_train_num';
    }
    /**
     * 根据train_id编辑一组信息
     *
     * @param int $train_id
     * @return boolean 二维数组
     */
    function update_by_train_num_id($train_id,$data) {
        $this->db->where ('train_id',$train_id);
        $this->db->update ( $this->table, $data);
        if($this->db->affected_rows ()>=1)
        {
            return true;
            exit;
        }
        return false;
    }
    /**
     * 根据train_id编辑一组信息
     *
     * @param int $train_id
     * @return boolean 二维数组
     */
    function delete_by_train_num_id($train_id) {
        $this->db->where ('train_id',$train_id);
        $this->db->delete($this->table);
        return $this->db->affected_rows ();
    }
    function get_train_num_by_train_id($train_id,$teacherid)
    {
        $this->db->where ('train_id',$train_id);
        $this->db->where ('teacherid',$teacherid);
        $query=$this->db->get($this->table, 1 );
		return $query->row_array ();
    }
}
