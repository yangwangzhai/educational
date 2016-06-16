<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 班级表模型
 * @author qcl 2016-01-07
 */
include_once 'content_model.php';
class Classroom_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_classroom';
    }

    /**
     * 为一组信息 加上班级的名字
     *
     * @param $ids array
     * @return array
     */
    function append_list($list) {
        if (isset ( $list [0] ['classid'] )) {
            foreach ( $list as &$r ) {
                $r ['classname']='';
                $r ['nickname']='';
                if($r['classid']!='')
                {
                    $this->db->select('classname,nickname');
                    $this->db->where('id',$r['classid']);
                    $query=$this->db->get($this->table);
                    $result = $query->row_array ();
                    if($result)
                    {
                        $r ['classname']=$result['classname'];
                        $r ['nickname']=$result['nickname'];
                    }
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
        if (isset ( $list['classid'] )) {
            $this->db->select('classname,nickname');
            $this->db->where('id',$list['classid']);
            $query=$this->db->get($this->table);
            $result = $query->row_array ();
            if($result)
            {
                $list ['classname']=$result['classname'];
                $list ['nickname']=$result['nickname'];
            }
            else
            {
                $list ['classname']='';
                $list ['nickname']='';
            }
        }
        return $list;
    }
    /**
     *根据学校id获取所在学校的所有班级
     * @param $schoolid
     * return array
     */
    function get_class_by_school_id($field = '*',$schoolid)
    {
        $this->db->select($field);
        $this->db->where('schoolid',$schoolid);
        $this->db->order_by('grade','DESC');
        $this->db->order_by('classname','ASC');
        $query=$this->db->get($this->table);
        return $query->result_array();
    }
    /**
     *根据班级昵称获取班级信息
     * @param $nickname
     * return array
     */
    function get_class_by_nickname($nickname)
    {
        $this->db->where('nickname',$nickname);
        $query=$this->db->get($this->table);
        return $query->row_array();
    }
    /**
     *根据班级名获取班级信息
     * @param $nickname
     * return array
     */
    function get_class_by_classname($classname)
    {
        $this->db->where('classname',$classname);
        $query=$this->db->get($this->table);
        return $query->row_array();
    }
    /**
     *根据多个班级id获取班级名
     * @param $classname
     * return array
     */
    function get_classname_by_ids($ids)
    {
        $str='';
        if($ids=='')
        {
            return $str;
        }
        $arr=explode(',',$ids);
        if(!empty($arr))
        {
            foreach($arr as $k=>$val)
            {
                $this->db->select('classname');
                $this->db->where('id',$val);
                $query=$this->db->get($this->table);
                $re=$query->row_array();
                if($k>=1)
                {
                    $str.= ',';
                }
                $str.=$re['classname'];
            }
        }
        return $str;
    }
    /**
     * 检测班级名称是否存在,存在返回真
     *
     * @param string $tel
     * @param int $id
     * @return bool
     */
    public function is_classname_exist($classname,$schoolid,$grade,$id=0) {
        if($id) {
            $count  = $this->counts("classname='$classname' AND id!=$id AND schoolid=$schoolid AND grade=$grade");
        } else {
            $count  = $this->counts("classname='$classname' AND schoolid=$schoolid AND grade=$grade");
        }
        return boolval ($count);
    }
    /**
     * 获取一组信息,整理后，可通过id 获取 班级名称
     *
     * @param $schoolid
     *        	多个参数
     * @return array 二维数组
     */
    function get_field($schoolid) {
        $list = $this->get_class_by_school_id('id,classname',$schoolid);
        $result = array();
        foreach($list as $value) {
            $result[$value['id']] = $value['classname'];
        }
        return $result;
    }
}
