<?php

if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 管理登录日志控制器
 * @ author qcl 2016-01-05
 */

include 'content.php';
class Adminlog extends Content {

    function __construct() {

        $class_name = 'adminlog';
        $this->name = '后台日志';
        $this->list_view = $class_name.'_list';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=adminlog'; // 本控制器的前段URL

        parent::__construct ();
        $this->load->model('adminlog_model');
    }

    // 首页
    public function index ()
    {
        $searchsql = "1 AND schoolid='$this->schoolid'";

        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND adminid like '%{$keywords}%' ";
        }

        $data['list'] = array();
        $count = $this->adminlog_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;
        $list = $this->adminlog_model->get_list('*',$searchsql,$offset,20);
        $data ['list']=$list;
        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
}
