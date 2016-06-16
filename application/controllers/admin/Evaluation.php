<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
/*
 * 教学测评控制器,学生对教师的评测
 * @author qcl 2016-01-06
 */

include 'content.php';
class Evaluation extends Content {

    function __construct() {

        $class_name = 'evaluation';
        $this->name = "学生教学评测";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';//添加列
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=evaluation'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('evaluation_model');
        $this->load->model('teacher_base_model');
    }

    /**
     *主页面
     */
    function index()
    {
        $searchsql = "1 AND a.schoolid=$this->schoolid";
        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND b.truename like '%{$keywords}%' ";
        }

        $data['list'] = array();
        $count = $this->evaluation_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();


        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->evaluation_model->get_evaluation($searchsql,$offset,20);

        $data['list'] = $list;

        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);  /**/
    }

    // 编辑
    public function add() {
        $data ['pubdate'] = times(time());
        $this->load->view ( 'admin/' . $this->add_view, $data );
    }

    // 编辑
    public function edit() {
        $this->load->model('student_model');
        $this->load->model('classroom_model');
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->evaluation_model->get_one($id);
        $value = $this->teacher_base_model->append_item( $value );
        $value=$this->student_model->append_item($value);
        $value = $this->classroom_model->append_item( $value );
        $data ['id'] = $id;
        $data ['value'] = $value;
        $this->load->view ( 'admin/' . $this->edit_view, $data );
    }

    // 保存 添加和修改都是在这里
    public function save() {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $data['schoolid'] = $this->schoolid;
        if ($data ['teacherid'] == "" || $data ['studentid'] == "" || $data ['pubdate'] == "") {
            show_msg ( '教师、学生、评价日期不能为空' );
        }
        $data['total']=0;
        if($data['morality']=='')
        {
            show_msg ( '师德修养不能为空' );
        }
        else
        {
            $data['total']+=intval($data['morality']);
        }
        if($data['visits']=='')
        {
            show_msg ( '家访情况不能为空' );
        }
        else
        {
            $data['total']+=intval($data['visits']);
        }
        if($data['chalkface']=='')
        {
            show_msg ( '课堂教学不能为空' );
        }
        else
        {
            $data['total']+=intval($data['chalkface']);
        }
        if($data['correction']=='')
        {
            show_msg ( '作业批改不能为空' );
        }
        else
        {
            $data['total']+=intval($data['correction']);
        }
        if($data['habitual']=='')
        {
            show_msg ( '学生习惯养成情况不能为空' );
        }
        else
        {
            $data['total']+=intval($data['habitual']);
        }
        if($data['effect']=='')
        {
            show_msg ( '教学效果不能为空' );
        }
        else
        {
            $data['total']+=intval($data['effect']);
        }
        if ($id) { // 修改 ===========
            $this->evaluation_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========

            $data ['addtime'] = time ();
            $this->evaluation_model->insert($data);

            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
}
