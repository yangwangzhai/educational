<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
/**
 * 后台基础类
 * 
 * @author ryo 2015/04/16
 */
class base extends CI_Controller {
	
	public $teacher = array();
	public $teacherid = 0;
    public $schoolid = 0;
	/**
	 * 构造器
	 * 
	 * @return void
	 */
	function __construct() {
		parent::__construct ();	
		$this->teacher = $this->session->userdata('teacher');
		
		if(!empty($this->teacher)) {
			$this->teacherid = $this->teacher['id'];
            $this->schoolid = $this->teacher['schoolid'];
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
	function teacherlog($title) {
		if (empty ( $title )) {
			return ;
		}		
		
		$this->load->library ( 'user_agent' );
		$browser = $this->agent->browser () . $this->agent->version ();
		// 插入数据
		$data = array (
                'schoolid'=>$this->schoolid,
				'teacherid' => $this->teacherid,
				'title' => $title,
				'ip' => ip (),
				'addtime' => time (),
				'browser' => $browser 
		);
		$this->db->insert ('fly_teacherlog', $data );
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
