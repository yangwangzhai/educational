<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
// 缓存控制器 常用变量

include 'content.php';
class cache extends content {

	function __construct() {
		$this->name = '缓存模块';
		
		parent::__construct ();		
	}
	
	// 首页
	public function index() {
		$data ['list'] = array (
				'电台组会员 缓存' 
		);
		
		$this->load->view ( 'admin/cache_list', $data );
	}
	
	// 更新缓存
	public function save() {
		$query = $this->db->query ( 'select id,nickname from fly_member where catid=3 limit 50' );
		$list = $query->result_array ();
		foreach ( $list as $value ) {
			$user [$value ['id']] = $value ['nickname'];
		}
		
		echo '更新中....';
		
		$this->cache->save ( 'user_radios', $user, TEN_YEAR );
		show_msg ( '更新完成', 'index.php?d=admin&c=cache' );
	}
	
	// 版本
	public function version() {
		$data ['value'] = $this->cache->get ( 'version' );		
		$this->load->view ( 'admin/version', $data );
	}
	
	// 版本保存
	public function version_save() {
		$value = trims ( $_POST ['value'] );
		$this->cache->save ( 'version', $value, TEN_YEAR );
		show_msg ( '更新完成', 'index.php?d=admin&c=cache&m=version' );
	}
	
	// 学校班级相关设置
	public function classes() {
		$data ['value'] = $this->cache->get ( 'classes' );		
		$this->load->view ( 'admin/cache_classes', $data );
	}
	
	// 学校班级相关设置 保存
	public function classes_save() {
		$value = trims ( $_POST ['value'] );
		$this->cache->save ( 'classes', $value, TEN_YEAR );
		show_msg ( '更新完成', 'index.php?d=admin&c=cache&m=classes' );
	}
	
	// 基础设置
	public function website() {
		$data ['value'] = $this->cache->get ( 'website' );		
		$this->load->view ( 'admin/cache_website', $data );
	}
	
	// 基础设置
	public function website_save() {
		$data = trims ( $_POST ['value'] );		
		$this->cache->save ( 'website', $data, TEN_YEAR );		
		show_msg ( '设置成功！', 'index.php?d=admin&c=cache&m=website' );
	}
}

/* End of file welcome.php */




