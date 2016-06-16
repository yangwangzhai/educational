<?php

if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 学校管理控制器
 * @ author qcl 2016-01-05
 */

include 'content.php';
class School extends Content {

    function __construct() {
        $this->name = '学校';
        $class_name = 'school';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c='.$class_name; // 本控制器的前段URL
        parent::__construct();
        $this->load->model('school_model');
    }

    // 保存 添加和修改都是在这里
    public function save() {
        $data = trims ( $_POST ['value'] );

        if ($data ['title'] == "") {
            show_msg ( '标题不能为空' );
        }
        if ($data ['thumb']) {
            thumb ( $data ['thumb'] );
        }
        // 修改 ===========
        $this->school_model->update($this->schoolid,$data);
        show_msg ( '修改成功！', 'index.php?d=admin&c=school&m=edit&id=' . $this->schoolid );

    }
    /**
     * 编辑
     */
    public function edit ()
    {
        // 这条信息
        $value = $this->school_model->get_one($this->schoolid);
        $data['value'] = $value;
        $data['id'] = $this->schoolid;

        $this->load->view('admin/' . $this->edit_view, $data);
    }
}
