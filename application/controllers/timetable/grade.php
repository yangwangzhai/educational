<?php

if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

// 每日刷卡统计

include 'content.php';

class grade extends Content
{

    function __construct()
    {

        $this->name = '班级列表';
        $this->control = 'grade';
        $this->baseurl = 'index.php?d=admin&c=grade';
        $this->table = 'fly_class';
        $this->list_view = 'grade'; // 列表页
        $this->add_view = 'class_add'; // 添加页
        parent::__construct();

        /*$catid = intval($_REQUEST ['catid']);
        $news_type = config_item('news_type');
        $this->name = $news_type [$catid];*/
    }

    // 首页
    public function index()
    {
        $schoolid = $this->schoolid;
        $term=$this->session->userdata('term'); //学期
        $school_type=$this->session->userdata('school_type');   //学校类型：小学、初中
        $res=utf_substr($term,9);
        $term_array=config_item('term_array');
        $term_china=$res[0].$res[1].$res[2].$res[3].'-'.$res[4].$res[5].$res[6].$res[7].$term_array[$res[8]];
        //从fly_class表取出数据
        $data['list']=$this->class_model->get_column('*',$this->table,$where="schoolid=$schoolid AND term=$term AND school_type=$school_type");
        $data['grade_num']=$school_type;
        $_SESSION ['url_forward'] = $this->baseurl;
        $data['grade_term']=$term_china;

        $this->load->view('admin/' . $this->list_view, $data);
    }


    public function add()
    {
        $data['grade_num']=6;
        $this->load->view('admin/' . $this->list_view, $data);
    }

    public function save()
    {
        $schoolid = $this->schoolid;
        $data = $_POST['value'];
        $term=$this->session->userdata('term'); //学期
        $school_type=$this->session->userdata('school_type');   //学校类型：小学、初中

        //中文逗号“,”转换成英文逗号
        foreach($data as $key=>$value){
            $data[$key]['major']=str_replace("，",",",$value['major']);
            $data[$key]['minor']=str_replace("，",",",$value['minor']);
        }

        for($i=0;$i<count($data);$i++){
            for($j=1;$j<=$data[$i]['class_count'];$j++){
                //echo $data[$i]['id'];
                $data[$i]['classes'].=(2015-$i)."$j".",";           //定义一年级是几几年
            }
            $data[$i]['schoolid']=$schoolid;                        //每个年级添加schoolid
            $data[$i]['term']=$term;                                //每个年级添加 学期 2015-2016上
            $data[$i]['school_type']=$school_type;                  //每个学校添加 学校类型
            $data[$i]['classes']=rtrim($data[$i]['classes'],",");   //去掉字符串末端的 ","号
        }

        /*
            if ($data ['classid'] == "") {
                show_msg('班级名不能为空');
            }
            $message = $data ['classid'];
            if (preg_match('/^([0-9_\.-]+)级([0-9_\.-]+)\班/', $message) == 0) { //匹配
                show_msg('班级名格式不正确； 格式为： XXXX级X班');
            }
            //echo 1111;	exit;
            $data['schoolid'] = $this->schoolid;
            $data ['classid'] = getNumber($data ['classid']);
        */
        //增加，更新都使用这个
           if($this->class_model->update($data)){
               show_msg('修改成功！', $this->baseurl."&m=index&term=$term");
           }


    }

    /*public function edit()
    {

        $id = intval($_GET ['id']);

        $where = array(
            id => $id
        );

        $result = db_row("fly_class", $where);

        $result['classname'] = setClassname($result['classid']);

        $data['result'] = $result;

        base_url();

        $this->load->view('admin/' . $this->add_view, $data);
    }*/
}
