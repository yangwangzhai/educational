<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 管理员
include_once 'content_model.php';
class Train_model extends content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_train';
    }
    /**
 * 为一组信息 加上培训的名称
 *
 * @param $ids array
 * @return array
 */
    function append_list($list) {
        if (isset ( $list [0] ['train_id'] )) {
            foreach ( $list as &$r ) {
                $r ['begintime']='';
                $r ['title']='';
                if($r['train_id']!='')
                {
                    $this->db->select('title,begintime');
                    $this->db->where('id',$r['train_id']);
                    $query=$this->db->get($this->table);
                    $result = $query->row_array ();
                    if($result)
                    {
                        $r ['begintime']=$result['begintime'];
                        $r ['title']=$result['title'];
                    }
                }
            }
        }
        return $list;
    }
}
