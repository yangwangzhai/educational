<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * 学生电子请假控制器
 * @ author qcl 2016-01-05
 */

include 'content.php';

class Student_leave extends Content
{

    function __construct ()
    {
        $class_name = 'student_leave';
        $this->name = '学生请假条';
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=student_leave'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('student_leave_model');
        $this->load->model('student_model');
        $this->load->model('classroom_model');
    }

    // 首页
    public function index() {
        $searchsql = "1 AND schoolid=$this->schoolid";

        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';

        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode ( $keywords );
            $searchsql .= " AND content like '%{$keywords}%' ";
        }

        $data ['list'] = array ();
        $count = $this->student_leave_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->student_leave_model->get_list('*',$searchsql,$offset,20);
        $list = $this->student_model->append_list ( $list );
        $list=$this->classroom_model->append_list($list);

        $data ['list'] = $list;

        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view ( 'admin/' . $this->list_view, $data );
    }
    /**
     * 添加
     *
     */
    public function add()
    {
        $this->load->view ( 'admin/' . $this->add_view );
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->student_leave_model->get_one($id);
        $value=$this->student_model->append_item( $value);
        $data['value']=$value;
        $data['id'] = $id;
        $this->load->view('admin/' . $this->edit_view, $data);
    }

    /**
     *保存
     */
    public function save()
    {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';

        $data = trims ( $_POST ['value'] );
        $data['schoolid']=$this->schoolid;
        if ($data ['studentid'] == "") {
            show_msg ( '学生不能为空' );
        }
        if ($data ['content'] == "") {
            show_msg ( '请假理由不能为空' );
        }
        if ($id) { // 修改 ===========
            $this->student_leave_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $this->student_leave_model->insert($data);

            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
}
