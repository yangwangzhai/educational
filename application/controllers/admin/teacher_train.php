<?php

include 'content.php';

/**
 * 教师控制器
 * @author qcl 2016/01/06
 *
 */
class Teacher_train extends Content
{
    /**
     * 构造器
     */
    function __construct()
    {
        $class_name = 'teacher_train';
        $this->name = "教师培训";
        $this->list_view = $class_name . '_list';
        $this->add_view = $class_name . '_add';
        $this->edit_view = $class_name . '_edit';
        $this->table = 'fly_' . $class_name;
        $this->baseurl = 'index.php?d=admin&c=teacher_train'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('teacher_base_model');
        $this->load->model('teacher_train_model');

    }

    function index()
    {
        $grade = $this->input->post('grade')?$this->input->post('grade'):2015;
        //按年级，取出所有老师
        $list=array();

        $where="grade='$grade'";
        $list=$this->teacher_train_model->get_column("*","fly_teacher_train",$where);

        $data['list'] = $list;
        $data['grade']=$grade;
        
        $this->load->view('admin/' . $this->list_view, $data);
    }

    public function save_teacher_train(){
        $id=$this->input->post("id");
        $value=$this->input->post('value');
        if($id){
            $this->teacher_train_model->update2($id,"fly_teacher_train",$value);
        }else{
            $this->teacher_train_model->db_insert_table("fly_teacher_train",$value);
        }

        $_SESSION ['url_forward']=$this->baseurl;
        show_msg ( '保存成功！', $_SESSION ['url_forward'] );
    }

















}