<?php

    if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

    // 每日刷卡统计

    include 'content.php';

    class term extends Content
    {
        function __construct()
        {
            $this->name = '学期列表';
            $this->control = 'term';
            $this->baseurl = 'index.php?d=admin&c=term';
            $this->list_view = 'term_list'; // 列表页
            parent::__construct();
        }


        public function index()
        {
            $this->load->view('admin/' . $this->list_view);
        }

        public function save()
        {
            $term=$this->input->post('term');
            $school_type=$this->input->post('school_type');
            $this->session->set_userdata('term',$term);
            $this->session->set_userdata('school_type',$school_type);
            show_msg ( '设置成功！请继续下一步');

        }













    }