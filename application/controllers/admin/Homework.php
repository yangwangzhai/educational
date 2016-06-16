<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * 学生作业成绩管理
 * @ author qcl 2016-01-11
 */

include 'content.php';

class Homework extends Content
{

    function __construct ()
    {
        $class_name = 'homework';
        $this->name = '学生作业成绩';
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=homework'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('homework_model');
        $this->load->model('student_model');
        $this->load->model('classroom_model');
    }

    // 首页
    public function index() {
        $searchsql = "1 AND a.schoolid=$this->schoolid";

        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';

        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode ( $keywords );
            $searchsql .= " AND b.name like '%{$keywords}%' ";
        }

        $data ['list'] = array ();
        $count = $this->homework_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->homework_model->get_homework($searchsql,$offset,20);
        $list=$this->classroom_model->append_list($list);
        $subject=$this->config->item('subject');
        $semester=$this->config->item('semester');
        foreach($list as &$item)
        {
            $item['subject']=$subject[$item['subject']];
            $item['semester']=$semester[$item['semester']];
        }
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
        $data['subject']=$this->config->item('subject');
        $data['semester']=$this->config->item('semester');
        $this->load->view ( 'admin/' . $this->add_view,$data );
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $data['subject']=$this->config->item('subject');
        $data['semester']=$this->config->item('semester');
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->homework_model->get_one($id);
        $student=$this->student_model->get_one($value['studentid']);
        $value['studentname']=$student['name'];
        $value['classid']=$student['classid'];
        $value=$this->classroom_model->append_item($value);

        $value['addtime']=times($value['addtime']);
        $data['value']=$value;
        $data['id'] = $id;

        $this->load->view('admin/' . $this->add_view, $data);
    }

    /**
     *保存
     */
    public function save()
    {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value']);
        $data['schoolid']=$this->schoolid;

        if ($data ['studentid'] == "") {
            show_msg ( '学生不能为空' );
        }
        if ($data ['score'] == "" || !is_numeric($data ['score'])) {
            show_msg ( '考试成绩不能为空或者格式不对' );
        }
        if ($data ['pubdate'] == "") {
            show_msg ( '考试时间不能为空' );
        }
        if ($id) { // 修改 ===========
            $this->homework_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $this->homework_model->insert($data);

            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
}
