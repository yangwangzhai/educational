<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// 后台公共页控制器 登陆页 by tangjian
include 'base.php';
class Common extends base {
	
	function __construct() {
		$this->name = '公共模块';
		
		parent::__construct ();
        $this->load->model('teacher_base_model');
	}
	
	// 框架首页
	public function index() {
		if (empty ( $this->teacherid )) {
			header('Location: index.php?d=teacher&c=common&m=login');
			//redirect ( 'd=manager&c=common&m=login' );
		}
		$this->teacherlog('教师管理后台首页');
		$this->load->view ( 'teacher/frame_index');
	}
	
	// 默认搜索页
	public function main() {
		if (empty ( $this->teacherid )) {
			redirect ( 'teacher.php' );
		}
		$this->load->view ( 'teacher/main' );
	}

    /**
     *登陆页
     */
    public function login()
    {

// 		$this->adminlog('区登陆页');
// 		if (! empty ( $this->uid )) {
// 			redirect ( 'index.php?d=manager&c=common' );
// 		}
		$data = null;
		$this->load->view ( 'teacher/login', $data );
	}
    /**
     *验证登陆
     */
    public function check_login()
    {
        $username = trim ( $this->input->post ( 'username' ) );
        $password = get_password ($this->input->post ( 'password' ) );
        $checkcode=trim ( $this->input->post ( 'checkcode' ) );
        if($_SESSION['checkcode']!=$checkcode)
        {
            show_msg('验证码错误！','index.php?d=teacher&c=common&m=login');
        }
        $teacher = $this->teacher_base_model->get_teacher_by_username ($username);
        if (empty ($teacher)) {
            show_msg ( '用户名不存在，请重新登录！' );
        }
        elseif ($teacher ['status'] != 1) {
            show_msg ( '您的账号已被锁定，请联系管理员！' );
        }
        elseif ($teacher ['password'] != $password) {
            show_msg ( '密码错误，请联系管理员！');
        }
        else
        {
            unset ( $teacher ['password'] );
            $this->session->set_userdata ( 'teacher', $teacher );
            redirect ( 'd=teacher&c=common&m=index' );
        }
	}
	
	// 退出
	public function login_out() {
		$this->teacherlog('教师退出登录');
        delete_cookie("classname");
		$this->session->unset_userdata ('teacher');
		redirect ( 'd=teacher&c=common&m=login' );
	}
	
}
/* End of file welcome.php */




