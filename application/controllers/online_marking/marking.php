<?php

if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

// 每日刷卡统计

include '/../timetable/content.php';
class marking extends Content
{
    function __construct()
    {
        $this->name = '阅卷列表';
        $this->control = 'marking';
        $this->baseurl = 'index.php?d=online_marking&c=marking';
        $this->table = 'fly_marking';
        $this->list_view = 'marking'; // 列表页
        $this->add_view = 'marking_add'; // 添加页
        parent::__construct();
        $this->load->model('online_marking/marking_model');
    }

    // 首页
    public function index()
    {
        $schoolid=$this->schoolid;
        $school_type=$this->school_type;
        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $total_rows=$this->marking_model->rows_query();
        $pagination['total_rows'] =$total_rows;
        $pagination['base_url'] = $this->baseurl;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('per_page') ? intval($this->input->get('per_page')) : 0;
        $data['list'] = $this->marking_model->get_list('*',"schoolid=$schoolid AND school_type=$school_type",$offset,10);
        foreach($data['list'] as $key=>$value){
            $res=$this->marking_model->sumscore($value['id'],"score");
            $data['list'][$key]['testscore']=$res['score'];
        }

        $this->load->view('online_marking/marking_list',$data);
    }

    public function add(){
        $this->load->view('online_marking/marking_add');
    }

    public function edit(){
        $id=$this->input->get('id');
        $data['list']=$this->marking_model->get_column2("id,classname,testname,thumb",$this->table,"id=$id");
        $this->load->view('online_marking/marking_add',$data);
    }

    public function save(){
        $id=$this->input->post('id');
        $data['schoolid']=$this->schoolid;
        $data['school_type']=$this->school_type;
        $data['classname']=$this->input->post('classname');
        $data['testname']=$this->input->post('testname');
        $data['titlenumber']=$this->input->post('titlenumber');
        $data['thumb']=$this->input->post('thumb');
        //如果图片宽度大于1000，切图
        $res=getimagesize($data['thumb']);
        if($res[0]>1000){
            $width=1000;
            $height=ceil(1000*($res[1]/$res[0]));
            thumb_resize($data['thumb'],$width,$height);
            $src=new_thumbname($data['thumb'],$width,$height);
            $data['thumb']=$src;
        }
        if(empty($id)){
            //插入
            $this->marking_model->db_insert_table($this->table,$data);
        }else{
            //更新
            $this->marking_model->db_update_table($this->table,$data,$id);
        }

    }

    public function delete(){
        $id=$this->input->get('id');
        if($id){
            //删除其他表的信息
            $this->marking_model->db_delete_table($this->table,$id);
        }
    }

    public function marking_action(){
        $id=$this->input->get('id');
        $data['list']=$this->marking_model->get_column2("testnumber,testname,thumb",$this->table,"id=$id");
        $data['id']=$id;
        $this->load->view('online_marking/marking_action',$data);
    }

    public function score_save(){
        $data['id']=$this->input->post('id');
        $data['title']=$this->input->post('title');
        $data['score']=$this->input->post('score');
        $this->marking_model->db_insert_table("fly_score",$data);
        $res=$this->marking_model->sumscore($data['id'],"score");
        echo $res['score'];

    }
















}
