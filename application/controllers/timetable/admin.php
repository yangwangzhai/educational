<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
// 管理员

include 'content.php';
class admin extends Content {
	
	function __construct() {
		parent::__construct ();
		
		$this->control = 'admin';
		$this->baseurl = 'index.php?d=admin&c=admin';
		$this->table = 'fly_admin';
		$this->list_view = 'admin_list';
		$this->add_view = 'admin_add';
	}
	
	// 首页
	public function index ()
	{
		$searchsql = "schoolid='$this->schoolid'";
		$catid = intval($_REQUEST['catid']);
				if ($catid) {
				$this->baseurl .= "&catid=$catid";
				$searchsql .= " AND catid='$catid' ";
		}
		$keywords = trim($_REQUEST['keywords']);
		if ($keywords) {
			$this->baseurl .= "&keywords=" . rawurlencode($keywords);
			$searchsql .= " AND (username like '%{$keywords}%' OR truename like '%{$keywords}%' OR telephone like '%{$keywords}%')";
		}
		
		$data['list'] = array();
		$query = $this->db->query(
		"SELECT COUNT(*) AS num FROM $this->table WHERE $searchsql");
		$count = $query->row_array();
		$data['count'] = $count['num'];
	
		$this->config->load('pagination', TRUE);
		$pagination = $this->config->item('pagination');
		$pagination['base_url'] = $this->baseurl;
		$pagination['total_rows'] = $count['num'];
		$this->load->library('pagination');
		$this->pagination->initialize($pagination);
		$data['pages'] = $this->pagination->create_links();
	
		$offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;		
		$query = $this->db->query("SELECT * FROM $this->table WHERE $searchsql ORDER BY id DESC limit $offset,$this->per_page");
		$list = $query->result_array();
		$data['list'] = $list;

		$data['catid'] = $catid;
		$data ['group'] = $this->config->item ( 'user_category' );

		$_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
		$this->load->view('admin/' . $this->list_view, $data);
	}

    public function add ()
    {
        $value['catid'] = intval($_REQUEST['catid']);
        $category = get_cache('category');
        $value['catname'] = $category[$value['catid']]['name'];

        $value['addv'] = $_GET['addv'];
        $data['value'] = $value;

        $this->load->view('admin/' . $this->add_view, $data);
    }

	// 保存 添加和修改都是在这里
	public function save() {
		
		$id = intval ( $_POST ['id'] );
		$data = trims ( $_POST ['value'] );
		$data['schoolid'] = $this->schoolid;
		
		if ($data [password]) {
			$data [password] = get_password ( $data [password] );
		} else {
			unset ( $data [password] );
		}
		
		if ($id) { // 修改 ===========
			$this->db->where ( 'id', $id );
			$query = $this->db->update ( $this->table, $data );
			show_msg ( '修改成功！', $_SESSION ['url_forward'] );
		} else { // ===========添加 ===========
			$data ['addtime'] = time ();
			$query = $this->db->insert ( $this->table, $data );
			show_msg ( '添加成功！', $_SESSION ['url_forward'] );
		}
	}
	
	// 删除
	public function delete() {
		$id = $_GET ['id'];
		$catid = $_REQUEST ['catid'];
		
		if ($id == 1)
			show_msg ( '超级管理员不能删除', $_SESSION ['url_forward'] );
		
		parent::delete ();
	}
}
