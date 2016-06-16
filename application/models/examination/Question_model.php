<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 管理员
include_once APPPATH.'models/content_model.php';
class Question_model extends content_model
{
    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();
        $this->table = 'fly_question';
    }

    public function rows_query($table)
    {
        $query = $this->db->query("SELECT * FROM $table ");
        return $query->num_rows();
    }

    /**
     * @access public
     * @param $pid 节点的id
     * @param array 返回该节点的所有后代节点
     */
    public function list_cate($subjectid,$p_id = 0){
        #获取所有的记录
        $cates = $this->Question_model->get_column("*","fly_knowledge_point","subjectid=$subjectid");
        #对类别进行重组，并返回
        return $this->_tree($cates,$p_id);
    }

    /**
     *@access private
     *@param $arr array 要遍历的数组
     *@param $pid 节点的pid，默认为0，表示从顶级节点开始
     *@param $level int 表示层级 默认为0
     *@param array 排好序的所有后代节点
     */
    public function _tree($arr,$p_id = 0,$level = 0){
        static $tree = array(); #用于保存重组的结果,注意使用静态变量
        foreach ($arr as $v) {
            if ($v['p_id'] == $p_id){
                //说明找到了以$pid为父节点的子节点,将其保存
                $v['level'] = $level;
                $tree[] = $v;
                //然后以当前节点为父节点，继续找其后代节点
                $this->_tree($arr,$v['id'],$level + 1);
            }
        }
        return $tree;
    }







}