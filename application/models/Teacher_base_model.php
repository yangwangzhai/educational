<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 管理员
include_once 'content_model.php';
class Teacher_base_model extends content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_teacher_base';
    }
    /**
     * 检测手机号码是否存在,存在返回真
     *
     * @param string tel
     * @param int $id
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

    /**根据用户名获取教师的信息
     * @param $username
     * return array
     */
    public function get_teacher_by_username($username)
    {
        $this->db->select('*');
        $this->db->where('username',$username);
        $query=$this->db->get($this->table);
        return $query->row_array ();
    }

    /**
     * 为一组信息 加上教师的信息用于编辑
     *
     * @param $ids array
     * @return array
     */
    function append_item($list) {
        if (isset ( $list['teacherid'] )) {
            $this->db->select('truename');
            $this->db->where('id',$list['teacherid']);
            $query=$this->db->get($this->table);
            $result = $query->row_array ();
            if($result)
            {
                $list ['truename']=$result['truename'];
            }
            else
            {
                $list ['truename']='';
            }
        }

        return $list;
    }
    /**
     * 为一组信息 加上教师的姓名
     *
     * @param $ids array
     * @return array
     */
    function append_list($list) {
        if (isset ( $list [0] ['teacherid'] )) {
            foreach ( $list as &$r ) {
                $this->db->select('truename');
                $this->db->where('id',$r['teacherid']);
                $query=$this->db->get($this->table);
                $result = $query->row_array ();
                if($result)
                {
                    $r ['truename']=$result['truename'];
                }
                else
                {
                    $r ['truename']='';
                }
            }
        }
        return $list;
    }
    /**
     * 为一组信息 加上教师的部门
     *
     * @param $ids array
     * @return array
     */
    function append_list1($list) {
        if (isset ( $list [0] ['teacherid'] )) {
            foreach ( $list as &$r ) {
                $this->db->select('dept');
                $this->db->where('id',$r['teacherid']);
                $query=$this->db->get($this->table);
                $result = $query->row_array ();
                if($result)
                {
                    $r ['dept']=$result['dept'];
                }
                else
                {
                    $r ['dept']='';
                }
            }
        }
        return $list;
    }

    /*
     * 教师学历统计
     * @param $schoolid
     */
    function statistic_degrees($schoolid)
    {
        $sql = "SELECT COUNT(*) AS num,degrees FROM $this->table WHERE schoolid=$schoolid GROUP BY degrees";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
    * 教师男女比例统计
    * @param $schoolid
    */
    function statistic_gender($schoolid)
    {
        $sql = "SELECT COUNT(*) AS num,gender FROM $this->table WHERE schoolid=$schoolid GROUP BY gender";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
    * 教师结婚比例比例统计
    * @param $schoolid
    */
    function statistic_marry($schoolid)
    {
        $sql = "SELECT COUNT(*) AS num,marry FROM $this->table WHERE schoolid=$schoolid GROUP BY marry";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
    * 教师生日统计
    * @param $schoolid
    */
    function statistic_birthday($schoolid)
    {
        $sql = "SELECT DATE_FORMAT(birthday,'%m') months,COUNT(*) AS num FROM $this->table WHERE schoolid=$schoolid GROUP BY months";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
    * 教师部门统计
    * @param $schoolid
    */
    function statistic_dept($schoolid)
    {
        $sql = "SELECT COUNT(*) AS num,dept FROM $this->table WHERE schoolid=$schoolid GROUP BY dept";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }

    /**
     *月份考勤统计
     */
    function statistic_month($schoolid,$month)
    {
        $state=array(2=>'迟到', 3=>'早退',4=>'未打卡');
        $dept=$this->config->item('dept');
        foreach($dept as $k=>$v)
        {
            $this->db->select('id');
            $this->db->where('schoolid', $schoolid);
            $this->db->where('dept', $k);
            $query = $this->db->get($this->table);
            $value = $query->result_array();
            if($value)
            {
                foreach($value as $item)
                {
                    foreach($state as $key=>$val)
                    {
                        $list[$k][$key]['num']=0;
                        switch($key)
                        {
                            case 2:
                                $sql = "SELECT COUNT(*) AS num FROM `fly_attendance_analysis` WHERE teacherid=$item[id] AND state=2 AND DATE_FORMAT(pubdate,'%Y-%m')='$month'";
                                $quer = $this->db->query($sql);
                                $re = $quer->result_array();
                                $list[$k][$key]['num']+=$re['num'];
                                break;
                            case 3:
                                $sql = "SELECT COUNT(*) AS num FROM `fly_attendance_analysis` WHERE teacherid=$item[id] AND state=2 AND DATE_FORMAT(pubdate,'%Y-%m')='$month'";
                                $quer = $this->db->query($sql);
                                $re = $quer->result_array();
                                $list[$k][$key]['num']+=$re['num'];
                                break;
                            case 4:
                                $sql = "SELECT COUNT(*) AS num FROM `fly_attendance_analysis` WHERE teacherid=$item[id] AND state=2 AND DATE_FORMAT(pubdate,'%Y-%m')='$month'";
                                $quer = $this->db->query($sql);
                                $re = $quer->result_array();
                                $list[$k][$key]['num']+=$re['num'];
                                break;
                        }
                    }
                }
            }
        }
    }
    /*
    * 教师工龄统计
    * @param $schoolid
    */
    function statistic_joinin($schoolid)
    {
        /*$sql = "SELECT YEAR(CURDATE()) -YEAR(joinin) AS age,DATE_FORMAT(joinin,'%Y-%m') AS joinin,COUNT(*) AS num FROM $this->table
        WHERE schoolid=$schoolid group by DATE_FORMAT(joinin,'%Y-%m')";*/
        $sql="SELECT YEAR(CURDATE()) -YEAR(joinin) AS age,DATE_FORMAT(joinin,'%Y') AS joinin,COUNT(*) AS num
        FROM fly_teacher WHERE schoolid=1 GROUP BY DATE_FORMAT(joinin,'%Y')";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        /*$arr=array(
            '0'=>'0个月',
            '1'=>'1个月',
            '2'=>'2个月',
            '3'=>'3个月',
            '4'=>'4个月',
            '5'=>'5个月',
            '6'=>'6个月',
            '7'=>'7个月',
            '8'=>'8个月',
            '9'=>'9个月',
            '10'=>'10个月',
            '11'=>'11个月',
            '12'=>'12个月'
        );
        $cur_month=date('Y-m-d',time());*/
        $y=date('Y',time());
        foreach($value as $k=>$v)
        {
            if($v['joinin']!=$y)
            {
                $new_value[$k]['age']=$v['age'].'年';
                $new_value[$k]['num']=$v['num'];
            }
            else
            {
                $sql = "SELECT MONTH(CURDATE()) -MONTH(joinin) AS age,DATE_FORMAT(joinin,'%Y-%m') AS joinin,COUNT(*) AS num FROM $this->table
                WHERE schoolid=$schoolid AND DATE_FORMAT(joinin,'%Y')=$y group by DATE_FORMAT(joinin,'%Y-%m')";
                $query = $this->db->query($sql);
                $value1 = $query->result_array();
                foreach($value1 as &$val)
                {
                    if($val['age']<1)
                    {
                        $val['age']='0个月';
                    }
                    else
                    {
                        $val['age']=$val['age'].'个月';
                    }
                }
            }
        }
        /*foreach($value as &$item)
        {
            if($item['age']!=0)
                $item['age']=$item['age'].'年';
                foreach($value as $k=>$v)
                {
                    if($v!=$item AND date('Y',strtotime($item['joinin']))==date('Y',strtotime($v['joinin'])))
                    {
                        $item['num']+=1;
                       unset($value[$k]);
                    }
                }
        }
        foreach($value as $key=>&$item)
        {
            if($item['age']==0)
            {
                $month=getMonthNum($item['joinin'],$cur_month);//两个日期相差多少个月份

                if($month<1)
                {
                    $month=0;
                }
                $item['age']=$arr[$month];
            }
        }*/
        if(isset($value1) AND isset($new_value))
        {
            sort($value1);
            sort($new_value);
            return array_merge($value1,$new_value);
        }
        elseif(isset($value1))
        {
            sort($value1);
            return $value1;
        }
        else
        {
            sort($value1);
            return $value1;
        }

    }
    /**
     *根据学生classname返回所以班主任
     * @param $classname
     * return array
     */
    public function get_manage_teacher_by_classid($classid)
    {
        $teacher=$this->get_list('truename,manage_class,id',"schoolid=$this->schoolid",0,100);
        $data=array();
        foreach($teacher as $item)
        {
            $arr=explode(',',$item['manage_class']);
            if(in_array($classid,$arr))
            {
                $data[$item['id']]=$item['truename'];
            }
        }
        return $data;
    }
    /**
     *根据学生classname返回所带班级
     * @param $classname
     * return array
     */
    public function get_teach_teacher_by_classid($classid)
    {
        $teacher=$this->get_list('truename,teach_class,id',"schoolid=$this->schoolid",0,100);

        $data=array();
        foreach($teacher as $item)
        {
            $arr=explode(',',$item['teach_class']);
            if(in_array($classid,$arr))
            {
                $data[$item['id']]=$item['truename'];
            }
        }
        return $data;
    }
    /**
     * 上一个教师
     * @param $id
     * @return mixed
     */
    public function getPrePage($id)
    {
        $this->db->where("id >",$id);
        $this->db->order_by("id","asc");
        $query=$this->db->get($this->table,1,0);
        $row_array=$query->row_array();
        return $row_array;
    }

    /**下一个老师
     * @param $id
     * @return mixed
     */
    public function getNextPage($id)
    {
        $this->db->where("id <",$id);
        $this->db->order_by("id","desc");
        $query=$this->db->get($this->table,1,0);
        $row_array=$query->row_array();
        return $row_array;
    }

    public function rows_query($table)
    {
        $query = $this->db->query("SELECT * FROM $table ");
        return $query->num_rows();
    }

    public function update_token($token,$data)
    {
        $this->db->where('token',$token);
        $this->db->update("fly_activity_resource_path",$data);
        $affect=$this->db->affected_rows();
        if($affect>=1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }










}
