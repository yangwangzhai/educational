<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
/*
 * 主管教学测评
 * @author qcl 2016-01-06
 */
include_once 'content_model.php';
class Assessment_model extends Content_model
{


    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'fly_assessment';
    }


    public function rows_query()
    {
        $table='fly_assessment_list';
        $query = $this->db->query("SELECT * FROM $table ");
        return $query->num_rows();
    }



    /**
     * 获取教师测评信息
     * @param
     *          多个参数
     * @return array 二维数组
     */

//    function get_assessment($where = '', $offset = 0, $limit = 20)
//    {
//        if($where) $where = " AND $where";
//        $sql = "SELECT a.*,b.truename FROM $this->table a ,fly_teacher b where a.teacherid=b.id $where ORDER BY a.id DESC limit $offset,$limit";
//        $query = $this->db->query ( $sql );
//        return $query->result_array ();
//    }
    /**
     *  查询记录条数
     *
     * @param string $where
     * @return array 二维数组
     */
    /*function counts($where='') {
        if($where) {
            $where = " AND $where";
        }

        $sql = "SELECT COUNT(*) AS num FROM $this->table a, fly_teacher b where a.teacherid=b.id $where";
        $query = $this->db->query ( $sql );
        $value = $query->row_array ();
        return $value ['num'];
    }*/
    /*
    * 教师部门统计
    * @param $teacherid
    *@param  $semester
    * return array
    */
    function statistic_semester($teacherid,$semester)
    {
        $sql = "SELECT `MONTH`,total FROM $this->table WHERE teacherid=$teacherid AND semester=$semester GROUP BY `MONTH` ORDER BY `MONTH`";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
    * 教师部门统计
    * @param $teacherid
    *@param  $semester
    * return array
    */
    function get_assessment_by_month($month,$semester)
    {
        $sql = "SELECT total,teacherid FROM $this->table WHERE `MONTH`=$month AND semester=$semester";
        $query = $this->db->query($sql);
        $value = $query->result_array();
        return $value;
    }
    /*
   * 教师部门统计
   * @param $teacherid
   *@param  $semester
   * return array
   */
    function get_assessment_by_teacherid($teacherid,$month,$semester)
    {
        $sql = "SELECT * FROM $this->table WHERE teacherid=$teacherid AND `MONTH`=$month AND semester=$semester";
        $query = $this->db->query($sql);
        $value = $query->row_array();
        return $value;
    }
    /*
    * 教师部门统计
    * @param $teacherid
    *@param  $semester
    * return array
    */
    function statistic($semester)
    {
        $sql = "SELECT `MONTH`,total FROM $this->table WHERE schoolid=$this->schoolid AND semester=$semester";
        $query = $this->db->query($sql);
        $arr=array();
        $value = $query->result_array();
        foreach($value as $item)
        {
            if(!isset($arr[$item['MONTH']]))
            {
                $arr[$item['MONTH']]=0;
            }
            $arr[$item['MONTH']]+=$item['total'];
        }
        return $arr;
    }




















}
