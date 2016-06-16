<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 教训培训经历模型
 * @author qcl 2016-01-05
 */
include_once 'content_model.php';
class History_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_history';
    }

    /**根据教师ID返回教师的教育、工作信息
     * @param int $uid
     */
    function get_history_by_teacherid($teacherid)
   {
       $this->db->where('teacherid',$teacherid);
       $query = $this->db->get ( $this->table, 1 );
       return $query->row_array ();
   }

}
