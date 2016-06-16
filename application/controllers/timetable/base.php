<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
/*
 * 后台基础类，其他类必须继承该类 code by tangjian
 */
class base extends CI_Controller {
	
	public $admin = array();
	public $schoolid = 0;
    public $school_type='';

	function __construct() {
		parent::__construct ();

		$this->admin = $this->session->userdata('admin');

		if(!empty($this->admin)) {
            $this->school_type = $this->admin['id'];
			$this->schoolid = $this->admin['schoolid'];
		}
		$this->load->driver ( 'cache', array (
				'adapter' => 'file'
		) );

	}
	
	// 用户登录信息
	function adminlog($title) {

		if (empty ( $title )) return '';

		$this->load->library ( 'user_agent' );
		$browser = $this->agent->browser () . $this->agent->version (); //获取用户使用的浏览器

		// 插入数据
		$data = array (
				'adminid' => $this->school_type,
				'title' => $title,
				'ip' => ip (),
				'addtime' => time (),
				'browser' => $browser 
		);

		$this->db->insert ( 'fly_adminlog', $data );
	}
	
	
	
	
	
	
}
