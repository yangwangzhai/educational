<?php

if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 管理员控制器
 * @ author qcl 2016-01-05
 */

include 'content.php';
class Admin extends Content {

    function __construct() {

        $class_name = 'admin';
        $this->name = '管理员';
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=admin'; // 本控制器的前段URL

        parent::__construct ();
        $this->load->model('admin_model');
    }

    // 首页
    public function index ()
    {
        $searchsql = "1 AND schoolid='$this->schoolid'";
        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND (username like '%{$keywords}%' OR truename like '%{$keywords}%' OR telephone like '%{$keywords}%')";
        }

        $data['list'] = array();
        $count = $this->admin_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;
        $list = $this->admin_model->get_list('*',$searchsql,$offset,20);
        $data ['list']=$list;
        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

    // 保存 添加和修改都是在这里
    public function save() {

        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $data['schoolid'] = $this->schoolid;

        if ($data ['password']) {
            $data ['password'] = get_password ( $data ['password'] );
        } else {
            unset ( $data ['password'] );
        }

        if ($id) { // 修改 ===========
            $this->admin_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $this->admin_model->insert ($data );
            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }

    /**
     *添加
     */
    public function add()
    {
        $this->load->view('admin/' . $this->add_view);
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->admin_model->get_one($id);
        $data ['value'] =$value;
        $data['id'] = $id;

        $this->load->view('admin/' . $this->edit_view, $data);
    }
    // 删除
    public function delete() {
        $id = $_GET ['id'];

        if ($id == 1)
            show_msg ( '超级管理员不能删除', $_SESSION ['url_forward'] );

        parent::delete ();
    }
}
