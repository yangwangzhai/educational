<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
/*
 * 教师培训附近模型
 * @author qcl 2016-01-05
 */
include_once 'content_model.php';
class Docs_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_docs';
    }
    /**
     * 根据train_id编辑一组信息
     *
     * @param int $train_id
     * @return boolean 二维数组
     */
    function update_by_train_id($train_id,$data) {
        $this->db->where ('train_id',$train_id);
        $this->db->update ( $this->table, $data);
        if($this->db->affected_rows ()>=1)
        {
            return true;
            exit;
        }
        return false;
    }
}
