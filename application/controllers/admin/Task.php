<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

// 作业信息 课外实践

include 'content.php';

class task extends Content
{
    function __construct ()
    {
        $this->name = '课外作业';
        $class_name = 'task';
        $this->list_view = $class_name.'_list';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=task'; // 本控制器的前段URL

        parent::__construct ();
        $this->load->model('task_model');
        $this->load->model('teacher_base_model');
    }

    // 首页
    public function index() {
        $searchsql = "1 AND schoolid='$this->schoolid'";

        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode ( $keywords );
            $searchsql .= " AND title like '%{$keywords}%' ";
        }

        $data ['list'] = array ();
        $count = $this->task_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;
        $list = $this->task_model->get_list('*',$searchsql,$offset,20);
        foreach($list as &$value) {
            $value['classname'] = setClassname($value['classname']);
            $value['title'] = html_escape($value['title']);
        }
        $data ['list'] = $this->teacher_base_model->append_list ( $list );


        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view ( 'admin/' . $this->list_view, $data );
    }

}


