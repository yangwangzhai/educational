<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * 学生成绩管理
 * @ author qcl 2016-01-11
 */

include 'content.php';
class Grow_tree extends Content
{
    function __construct ()
    {
        $class_name = 'grow_tree';
        $this->name = '成长树';
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=grow_tree'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('test_score_model');
        $this->load->model('test_list_model');
        $this->load->model('student_model');
        $this->load->model('classroom_model');
        $this->load->model('timetable/content_model');
    }

    public function index(){

        $this->load->view ( 'admin/' . $this->list_view);
    }







}
