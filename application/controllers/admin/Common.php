<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 后台公共页控制器 登陆页 by tangjian
include 'base.php';
class Common extends Base {

    function __construct() {
        $this->name = '公共模块';

        parent::__construct ();
        $this->load->model('admin_model');
    }

    public function top(){
        $this->load->view("admin/top");
    }

    public function left(){
        $this->load->view("admin/left");
    }

    public function right(){
        $where="order by date asc limit 10";
        $data['list'] = $this->admin_model->get_notice_list('date,content','fly_notice',$where);
        $this->load->view("admin/main",$data);
    }

    // 框架首页
    public function index() {
        if (empty ( $this->uid )) {
            header('Location: index.php?d=admin&c=common&m=login');
            //redirect ( 'd=manager&c=common&m=login' );
        }
        $this->adminlog('区管理后台首页');

        $title=$this->input->get("title");
        if(empty($title)||$title=="jwc"){
            $this->load->view ( 'admin/frame_index');
        }elseif($title=="zjc"){
            $this->load->view ( 'admin/frame_index_zjc');
        }elseif($title=="ht"){
            $this->load->view ( 'admin/frame_index_ht');
        }

    }

    // 默认搜索页
    public function main() {
        if (empty ( $this->uid )) {
            redirect ( 'admin.php' );
        }

        //获取公告栏信息
        $where="order by date asc limit 10";
        $data['list'] = $this->admin_model->get_notice_list('date,content','fly_notice',$where);
        $this->load->view ( 'admin/main' ,$data);
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
        $this->load->view ( 'admin/login', $data );
    }
    /**
     *验证登陆
     */
    public function check_login()
    {
        $username = trim ( $this->input->post ( 'username' ) );
        $password = get_password ($this->input->post ( 'password' ) );
        /*if(config_item('yzm_open'))
        {
            $checkcode = strtolower($this->input->post('checkcode'));
            if ($checkcode != $this->session->checkcode) {
                show_msg('验证码不正确，请重新输入');
            }
        }*/
        $admin = $this->admin_model->get_admin_by_username ($username);
        if (empty ($admin)) {
            show_msg ( '用户名不存在，请重新登录！' );
        }
        elseif ($admin ['status'] != 1) {
            show_msg ( '您的账号已被锁定，请联系管理员！' );
        }
        elseif ($admin ['password'] != $password) {
            show_msg ( '密码错误，请联系管理员！');
        }
        else
        {
            unset ( $admin ['password'] );
            $this->session->admin=$admin ;
            redirect ( 'd=admin&c=common&m=index' );
        }
    }

    // 退出
    public function login_out() {
        $this->adminlog('区管理员退出登录');
        $this->session->unset_userdata ('admin');
        redirect ( 'd=admin&c=common&m=login' );
    }

}
/* End of file welcome.php */




