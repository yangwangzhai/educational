<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// 文章 控制器 by tangjian

include 'content.php';
class News extends Content {
	
	function __construct() {
		$this->name = '新闻资讯';
		$this->control = 'news';
		$this->baseurl = 'index.php?d=admin&c=news';
		$this->table = 'fly_news';
		$this->list_view = 'news_list'; // 列表页
		$this->add_view = 'news_add'; // 添加页
		
		parent::__construct ();
		
		$catid = intval ( $_REQUEST ['catid'] );
		$news_type = config_item ( 'news_type' );
		$this->name = $news_type [$catid];
	}
	
	// 首页
	public function index() {
		$searchsql = "schoolid='$this->schoolid'";
		
		$catid = intval ( $_REQUEST ['catid'] );
		$keywords = trim ( $_REQUEST ['keywords'] );
		if ($catid) {
			$this->baseurl .= "&catid=$catid";
			$searchsql .= " AND catid='$catid' ";
		}
		if ($keywords) {
			$this->baseurl .= "&keywords=" . rawurlencode ( $keywords );
			$searchsql .= " AND title like '%{$keywords}%' ";
		}
		
		$data ['list'] = array ();
		$query = $this->db->query ( "SELECT COUNT(*) AS num FROM $this->table WHERE $searchsql" );
		$count = $query->row_array ();
		$data ['count'] = $count ['num'];
		
		$this->config->load ( 'pagination', TRUE );
		$pagination = $this->config->item ( 'pagination' );
		$pagination ['base_url'] = $this->baseurl;
		$pagination ['total_rows'] = $count ['num'];
		$this->load->library ( 'pagination' );
		$this->pagination->initialize ( $pagination );
		$data ['pages'] = $this->pagination->create_links ();
		
		$offset = $_GET ['per_page'] ? intval ( $_GET ['per_page'] ) : 0;
		$sql = "SELECT * FROM $this->table WHERE $searchsql ORDER BY id DESC limit $offset,$this->per_page";
		$query = $this->db->query ( $sql );
		$data ['list'] = $query->result_array ();
		
		$data ['catid'] = $catid;
		
		$_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
		$this->load->view ( 'admin/' . $this->list_view, $data );
	}
	
	// 编辑
	public function edit() {
		
		$id = intval ( $_GET ['id'] );
		
		// 这条信息
		$query = $this->db->get_where ( $this->table, 'id = ' . $id, 1 );
		$value = $query->row_array ();
		$data ['value'] = $value;
		$data ['id'] = $id;
		
		base_url();
		
		$this->load->view ( 'admin/' . $this->add_view, $data );
	}
	
	// 显示页
	public function show() {
		$id = intval ( $_GET ['id'] );
		
		// 这条信息
		$query = $this->db->get_where ( $this->table, 'id = ' . $id, 1 );
		$value = $query->row_array ();
		$value ['status'] = $value ['status'] == 1 ? '已审' : '未审';
		
		$news_type = config_item ( 'news_type' );
		$this->name = $news_type [$value ['catid']];
		
		$data ['value'] = $value;
		
		$this->load->view ( 'admin/news_show', $data );
	}
	
	// 保存 添加和修改都是在这里
	public function save() {
		
		$id = intval ( $_POST ['id'] );
		$data = trims ( $_POST ['value'] );
		$data['schoolid'] = $this->schoolid;
		
		if ($data ['title'] == "") {
			show_msg ( '标题不能为空' );
		}
		if ($data ['thumb']) {
			thumb ( $data ['thumb'] );
		}
		
		if ($id) { // 修改 ===========
			$this->db->where ( 'id', $id );
			$query = $this->db->update ( $this->table, $data );
			show_msg ( '修改成功！', $_SESSION ['url_forward'] );
		} else { // ===========添加 ===========
			$data ['addtime'] = time ();
			$data['status'] = 0;
			$query = $this->db->insert ( $this->table, $data );
			$data ['id'] = $this->db->insert_id ();

			// 统计概况
			$this->load->model ( 'stat_model' );
			$this->stat_model->school($data['schoolid'], 'news');

			show_msg ( '添加成功！', $_SESSION ['url_forward'] );
		}
	}
	
	// 审核 公告推送
	public function check() {
		$id = $_GET ['id'];
		// 这条信息
		$query = $this->db->get_where ( $this->table, 'id = ' . $id, 1 );
		$value = $query->row_array ();
		$data ['value'] = $value;
		
		$this->load->view ( 'admin/news_check', $data );
	}
	
	// 审核 公告推送
	public function check_save() {
		$id = $_POST ['id'];		
		if(empty($id)) {
			show_msg ( '暂时不能审核，请联系管理员！', $_SESSION ['url_forward'] );
		}	
		
		$data ['status'] = 1;
		$this->db->where ( 'id', $id );
		$query = $this->db->update ( $this->table, $data );
		
		// 全部推送   
		$push = $_POST['push'];
		if($push==1) {
			$query = $this->db->get_where ( $this->table, 'id = ' . $id, 1 );
			$value = $query->row_array();
			$value['window'] = intval($_POST['window']); // 1弹窗 0否				
			$this->push_news($value);
		}
		
		show_msg ( '审核成功！', $_SESSION ['url_forward'] );
	}
	
	// 推送新闻信息
	public function push_news($value) {
				
		if (empty ( $value ))
			return false;
			
		$data = array (
				'tag' => 'schoolid_'.$this->schoolid,
				'id' => $value['id'],
				'title' => $value ['title'],
				'window' => $value ['window'],
				'addtime' => times ( $value ['addtime'], 1 ) 
				);				
		
		$this->load->model ( 'push_model' );
		$ret = $this->push_model->pushNewsAll ( $data );			
	}
	
}
