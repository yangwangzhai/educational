<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
/**
 * 后台基础类
 * 
 * @author ryo 2015/04/16
 */
class Base extends CI_Controller {
	
	public $admin = array();
	public $uid = 0;
    public $school_type='';
    public $schoolid = 0;
	/**
	 * 构造器
	 * 
	 * @return void
	 */
	function __construct() {
		parent::__construct ();
		$this->admin = $this->session->admin;

		if(!empty($this->admin)) {
			$this->uid = $this->admin['id'];
            $this->school_type = $this->admin['id'];
            $this->schoolid = $this->admin['schoolid'];
		}
		
		$this->load->driver ( 'cache', array (
				'adapter' => 'file'
		));		
	}
	
	/**
	 * 后台操作日志
	 * 
	 * @param string $title
	 * @return void
	 */
	function adminlog($title) {
		if (empty ( $title )) {
			return ;
		}		
		
		$this->load->library ( 'user_agent' );
		$browser = $this->agent->browser () . $this->agent->version ();
		// 插入数据
		$data = array (
                'schoolid'=>$this->schoolid,
				'adminid' => $this->uid,
				'title' => $title,
				'ip' => ip (),
				'addtime' => time (),
				'browser' => $browser 
		);
		$this->db->insert ('fly_adminlog', $data );
	}
	

	/**
	 * foo方法，测试用
	 *
	 * @return void
	 */
	function foo() {
		print_r($this->session->userdata('admin'));
		$this->load->view ( 'index');
		$this->session->sess_destroy();
	}
	
}
