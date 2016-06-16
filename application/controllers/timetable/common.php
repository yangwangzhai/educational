<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// 后台公共页控制器 登陆页 by tangjian
include 'base.php';
class Common extends base {

	function __construct() {
		$this->name = '公共模块';
		
		parent::__construct ();
	}
	
	// 框架首页
	public function index() {
		if (empty ( $this->school_type )) {
			header('Location: index.php?d=admin&c=common&m=login');
			//redirect ( 'd=admin&c=common&m=login' );
		}
        $this->adminlog('登录成功！');
		$this->load->view ( 'admin/frame_index');
	}
	
	// 默认搜索页
	public function main() {
		if (empty ( $this->school_type )) {
			redirect ( 'admin.php' );
		}
		$this->load->view ( 'admin/main' );
	}

    public function main2() {
        if (empty ( $this->school_type )) {
            redirect ( 'admin.php' );
        }
        $this->load->view ( 'admin/main2' );
    }
	
	// 登陆页
	public function login() {
    //$this->uid 为用户id
		if (! empty ( $this->school_type )) {
			redirect ( 'd=admin&c=common' );
		}
		$this->adminlog('登陆页');
		$this->load->view ( 'admin/login');
	}
	
	// 验证登陆 区后台 schoolid=0
	public function check_login() {
		$username = trim ( $this->input->post ( 'username' ) );
		$password = get_password ( $this->input->post ( 'password' ) );
		// $checkcode = trim($this->input->post('checkcode'));

		// if ($checkcode != $_SESSION['checkcode']) {
		// show_msg('验证码不正确，请重新输入');
		// }

        //从用户表fly_admin，获取用户信息，判断用户是否合法
		$query = $this->db->get_where ( 'fly_admin', array (
				'username' => $username,
				'password' => $password 
		), 1 );
		$user = $query->row_array ();

		if (empty ( $user )) {
			show_msg ( '用户名或密码错误，请重新登录！', 'admin.php' );
		}
		if ($user ['status'] != 1) {
			show_msg ( '您的账号已被锁定，请联系管理员！', 'admin.php' );
		}
		if ($user ['schoolid'] == 0) {
			show_msg ( '您的账号没有权限，请联系管理员！', 'admin.php' );
		}
		
		// $this->db->query('update fly_user set
		// logins=logins+1,lastlogtime='.time().' where id='.$user['id']);
		unset ( $user ['password'] );//为了安全，销毁数组$user中的密码

		$user['schoolname'] = get_schoolname($user['schoolid']);//根据schoolid，到fly_school表获取对应的学校名称
		$this->session->set_userdata ( 'admin', $user );        //数组$user放入session，

        /*  $user=Array
                        (
                            [id] => 38                  用户（管理员）id
                            [schoolid] => 9             用户（管理员）所在学校的id
                            [addtime] => 1435114471     用户注册时间
                            [status] => 1               状态
                            [catid] => 1                分类
                            [username] => ceshi         用户（管理员）名称
                            [truename] =>               用户（管理员）真实名称
                            [telephone] =>
                            [email] =>
                            [remarks] =>
                            [schoolname] => 内部测试学校  用户（管理员）所在学校的名称
                        )
        */
		redirect ( 'd=admin&c=common&m=index' );
	}
	
	// 退出
	public function login_out() {
		$this->adminlog('退出登录');
		$this->session->unset_userdata ('admin');
		$this->session->unset_userdata ('term');
		redirect ( 'd=admin&c=common&m=login' );
	}
	
}
/* End of file welcome.php */




