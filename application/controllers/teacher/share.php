<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// 分享信息

include 'content.php';
class Share extends Content {
	
	function __construct() {
        $class_name = 'share';
        $this->name = "家长分享";
        $this->list_view = $class_name.'_list'; // 列表页
        $this->add_view = $class_name.'_add';// 添加页
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=share'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('share_model');
        $this->load->model('classroom_model');
        $this->load->model('student_model');
	}
	
	// 首页
	public function index() {
        if( get_cookie ('classname')==null)
        {
            show_msg('没有找到你的班级 请先设置班级！', 'index.php?d=teacher&c=class_list&m=index');
        }
        else
        {
            $classname = get_cookie('classname');
            $class = $this->classroom_model->get_class_by_classname($classname);
            $ids = implode(',', $this->student_model->get_ids_by_classid($class['id']));
            $searchsql = "1 AND b.studentid in ($ids)";
            $keywords = $this->input->post('keywords') ? trim($this->input->post('keywords')) : '';

            if ($keywords) {
                $this->baseurl .= "&keywords=" . rawurlencode($keywords);
                $searchsql .= " AND title like '%{$keywords}%' ";
            }

            $data['list'] = array();
            $count = $this->share_model->counts($searchsql);
            $data['count'] = $count;

            $this->config->load('pagination', TRUE);
            $pagination = $this->config->item('pagination');
            $pagination['base_url'] = $this->baseurl;
            $pagination['total_rows'] = $count;
            $this->load->library('pagination');
            $this->pagination->initialize($pagination);
            $data['pages'] = $this->pagination->create_links();

            $offset = $this->input->get('per_page') ? intval($this->input->get('per_page')) : 0;

            $list = $this->share_model->get_share( $searchsql, $offset, 20);
            $data['list'] =$list;

            $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
            $this->load->view('teacher/' . $this->list_view, $data);  /**/
        }
	}
}
