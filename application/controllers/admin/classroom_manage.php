<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
/*
 * 教师测评控制器
 * @ author qcl 2016-01-05
 */

include 'content.php';
class Classroom_manage extends Content
{

    function __construct()
    {
        $class_name = 'classroom_check';
        $this->name = "课堂管理";
        $this->list_view = $class_name . '_list';
        $this->add_view = $class_name . '_add';//添加列
        $this->edit_view = $class_name . '_edit';
        $this->table = 'fly_' . $class_name;
        $this->baseurl = 'index.php?d=admin&c=classroom_manage'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('classroom_manage_model');
        $this->load->model('teacher_base_model');
    }

    public function index(){
        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $total_rows=$this->classroom_manage_model->rows_query();
        $pagination['total_rows'] =$total_rows;
        $pagination['base_url'] = $this->baseurl;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('pn') ? intval($this->input->get('pn')) : 0;
        $data['list'] = $this->classroom_manage_model->get_list2('*',"",'fly_classroom_check',$offset,10);

        $this->load->view('admin/' . $this->list_view,$data);
    }

    public function save_classroom_check(){
        $classroom_check_id=$this->input->get('id');
        $data['grade']=$this->input->post('grade');
        $data['week']=$this->input->post('week');
        $data['section']=$this->input->post('section');
        $data['term']=$this->input->post('term');
        $data['date']=$this->input->post('date');
        $_SESSION ['url_forward']=$this->baseurl;
        if($classroom_check_id){    //修改
            $this->classroom_manage_model->db_update_table("fly_classroom_check",$data,$classroom_check_id);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        }else{  //添加
            $this->classroom_manage_model->db_insert_table("fly_classroom_check",$data);
            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }

    }

    public function classroom_check_content(){
        $id=$this->input->get('id');
        $this->session->set_userdata ('classroom_check_id', $id);
        $where="id=$id";
        $check_list=$this->classroom_manage_model->get_column2("*",$this->table,$where);

        //根据年级获取所有班级，根据节次获取该节次的科目和上课老师
        $schoolid=1;
        $school_type=1;
        $term=3;
        $where_classname="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$check_list[grade]'";
        $column="classname";
        $table="fly_course_plan";
        $res_classname=$this->classroom_manage_model->get_column($column,$table,$where_classname);
        $arr_classname=unique($res_classname);
        foreach($arr_classname as $classname_value){
            $where_course_teacher="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$check_list[grade]' AND classname='$classname_value' AND week=$check_list[week] AND section=$check_list[section]";
            $res=$this->classroom_manage_model->get_column2("title,teacher_truename","fly_timetable",$where_course_teacher);
            $res['classname']=$classname_value;
            $message[]=$res;
        }
        //如果已经检查过，从fly_check_content表获取响应的检查内容
        foreach($message as $message_key=>$message_value){
            $where_content="classroom_check_id=$id AND classname='$message_value[classname]' AND course='$message_value[title]' AND teacher='$message_value[teacher_truename]'";
            $content=$this->classroom_manage_model->get_column2("check_content","fly_check_content",$where_content);
            $message[$message_key]['check_content']=$content['check_content'];
        }

        $data['list']=$message;
        $data['check']=$check_list;

        $this->load->view('admin/classroom_check_content',$data);
    }

    public function save_check_content(){
        $classroom_check_id=$this->session->userdata('classroom_check_id');
        $data=$this->input->post('value');
        foreach($data as $key=>$value){
            $value['classroom_check_id']=$classroom_check_id;
            $this->classroom_manage_model->db_insert_table("fly_check_content",$value);
        }
        $_SESSION ['url_forward']=$this->baseurl;
        show_msg ( '保存成功！', $_SESSION ['url_forward'] );
    }

    public function delete_classroom_check(){
        $classroom_check_id=$this->input->get('id');
        $delete_classroom_check['id']=$classroom_check_id;
        $this->classroom_manage_model->db_delete2("fly_classroom_check",$delete_classroom_check);
        $delete_check_content['classroom_check_id']=$classroom_check_id;
        $this->classroom_manage_model->db_delete2("fly_check_content",$delete_check_content);
        $_SESSION ['url_forward']=$this->baseurl;
        show_msg ( '删除成功！', $_SESSION ['url_forward'] );
    }




}