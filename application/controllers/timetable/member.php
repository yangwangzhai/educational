<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// 会员 控制器 by tangjian

include 'content.php';
class Member extends Content
{
	function __construct() {
		
		parent::__construct ();

		$this->load->model('member_model');
	}
	
	// 修改密码页
	public function password() {
		$id = intval ( $_GET ['id'] );
	
		// 这条信息
		$query = $this->db->get_where ( $this->table, 'id = ' . $id, 1 );
		$value = $query->row_array ();
		$value = $this->student_model->append_one ( $value );
	
		$data ['id'] = $id;
		$data ['value'] = $value;
		$this->load->view ( 'admin/member_password' , $data );
	}
	
	// 保存密码
	public function password_save() {
		$id = intval ( $_POST ['id'] );
		$data = trims ( $_POST ['value'] );
	
		if ($data ['password'] == "") {
			show_msg ( '密码不能为空' );
		}
		if ($data ['password'] != $data ['password2']) {
			show_msg ( '两次密码不相同' );
		}

		unset($data ['password2']);
		$this->member_model->update($data, $id);
			
		show_msg ( '修改成功！', $_SESSION ['url_forward'] );
	}
	
	// 删除
	public function delete() {
		$id = $_GET ['id'];
		$catid = $_REQUEST ['catid'];
	
		if ($id) {
			$this->db->query ( "delete from $this->table where id=$id" );
		} else {
			$ids = implode ( ",", $_POST ['delete'] );
			$this->db->query ( "delete from $this->table where id in ($ids)" );
		}
		show_msg ( '删除成功！', $_SESSION ['url_forward'] );
	}
	
}
