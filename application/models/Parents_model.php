<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 监护人
include_once 'content_model.php';
class Parents_model extends content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_parents';
    }
    /**
     * 为一组信息 加上家长的信息用于编辑
     *
     * @param $ids array
     * @return array
     */
    function append_item($list) {
        if (isset ($list['uid'])) {
                $this->db->select('username');
                $this->db->where('id',$list['uid']);
                $query=$this->db->get($this->table);
                $result = $query->row_array ();
                if($result)
                {
                    $list ['username']=$result['username'];
                }
                else
                {
                    $list ['username']='';
                }
            }

        return $list;
    }
    /**
     * 为一组信息 加上家长的姓名
     *
     * @param $ids array
     * @return array
     */
    function append_list($list) {
        if (isset ( $list [0] ['uid'] )) {
            foreach ( $list as &$r ) {
                $this->db->select('username');
                $this->db->where('id',$r['uid']);
                $query=$this->db->get($this->table);
                $result = $query->row_array ();
                if($result)
                {
                    $r ['username']=$result['username'];
                }
                else
                {
                    $r ['username']='';
                }
            }
        }
        return $list;
    }
    /**
     * 检测手机号码是否存在,存在返回真
     *
     * @param string tel
     * @param int $uid
     * @return bool
     */
    public function is_tel_exist($tel, $id=0) {
        if($id) {
            $count  = $this->counts("tel='$tel' AND id!=$id");
        } else {
            $count  = $this->counts("tel='$tel'");
        }

        return boolval ($count);
    }

    /**
     *根据学生id返回所以父母信息
     * @param studentid
     * return array
     */
    public function get_parents_by_studentid($studentid)
    {
        $this->db->select('username,relatives,tel,company');
        $this->db->where('studentid',$studentid);
        $query=$this->db->get($this->table);
        return $query->result_array ();
    }
    /*
     * 家长关系统计
     * @param $schoolid
     */
    function statistic_relatives($where)
    {
        if($where) $where="WHERE $where";
        $sql = "SELECT COUNT(*) AS num,relatives FROM $this->table $where GROUP BY relatives";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
     * 家长配合度统计
     * @param $schoolid
     */
    function statistic_fit($where)
    {
        if($where) $where="WHERE $where";
        $sql = "SELECT COUNT(*) AS num,fit FROM $this->table $where GROUP BY fit";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
     * 家长育儿经验统计
     * @param $schoolid
     */
    function statistic_experience($where)
    {
        if($where) $where="WHERE $where";
        $sql = "SELECT COUNT(*) AS num,experience FROM $this->table $where GROUP BY experience";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
     * 家长家庭环境经验统计
     * @param $schoolid
     */
    function statistic_environment($where)
    {
        if($where) $where="WHERE $where";
        $sql = "SELECT COUNT(*) AS num,environment FROM $this->table $where GROUP BY environment";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
     * 家长家庭环境经验统计
     * @param $schoolid
     */
    function statistic_transport($where)
    {
        if($where) $where="WHERE $where";
        $sql = "SELECT COUNT(*) AS num,transport FROM $this->table $where GROUP BY transport";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
     * 家长学历统计
     * @param $schoolid
     */
    function statistic_degrees($where)
    {
        if($where) $where="WHERE $where";
        $sql = "SELECT COUNT(*) AS num,degrees FROM $this->table $where GROUP BY degrees";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /**
     *根据学生id返回所以父母信息
     * @param studentid
     * return array

    public function get_parents_by_volunteer($volunteer,$schoolid)
    {
        $this->db->select('*');
        $this->db->where('schoolid',$schoolid);
        $query=$this->db->get($this->table);
        $resule= $query->result_array ();
        foreach($resule as $val)
        {
            if(!empty($val['volunteer'])) {
                $volunteer_data = @unserialize($val['volunteer']);
                foreach ($volunteer as $v) {
                    if (in_array($v['id'], $volunteer_data)) {
                        $rel[]=$val;
                        break;
                    }
                }
            }
        }
        return $rel;
    }*/
}
