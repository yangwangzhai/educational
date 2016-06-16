<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 资源分类控制器
 * @author qcl 2016-01-11
 */
include_once 'content_model.php';
class Resource_type_model extends Content_model
{

    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_resource_type';
    }
    /**
     *递归分类列表
     */
    public function get_array($array,$pid=0)
    {
        $arr=array();
        $item=array();
        foreach ($array as $v) {
            if($v['pid']==$pid)
            {
                $item=$this->get_array($array,$v['id']);
                $item && $v['son']=$item;
                $arr[]=$v;
            }
        }
        return $arr;
    }
}
