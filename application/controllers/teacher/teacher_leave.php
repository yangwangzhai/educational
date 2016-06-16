<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

// 教师提交的电子请假条

include 'content.php';

class Teacher_leave extends Content
{

    function __construct ()
    {
        $class_name = 'teacher_leave';
        $this->name = '电子请假条';
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=teacher_leave'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('teacher_leave_model');
        $this->load->model('teacher_base_model');
        $this->load->model('admin_model');
    }

    // 首页
    public function index() {
        $teacherid=$this->teacherid;
        $searchsql = "1 AND a.teacherid=$teacherid";

        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        $leave_type = $this->input->post('leave_type')?$this->input->post('leave_type'):'';
        if ($leave_type) {
            $this->baseurl .= "&leave_type=" . rawurlencode ( $leave_type);
            $searchsql .= " AND a.leave_type='$leave_type' ";
        }
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode ( $keywords );
            $searchsql .= " AND b.truename like '%{$keywords}%' ";
        }

        $data ['list'] = array ();
        $count = $this->teacher_leave_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->teacher_leave_model->get_teacher_leave($searchsql,$offset,20);
        $leave_type=$this->config->item('leave_type');

        foreach($list as &$item) {
            $item['leave_type']=$leave_type[$item['leave_type']];
            if($item['isread']==0)
            {
                $item['isread']="<font color='red'>未阅读</font>";
            }
            else
            {
                $item['isread']="<font color='green'>已阅</font>";
            }
        }
        $data ['list'] = $this->teacher_base_model->append_list ($list);
        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view ( 'teacher/' . $this->list_view, $data );
    }
    /**
     * 添加
     *
     */
    public function add()
    {
        $data['hournums']=array(
            0=>'0小时',
            1=>'1小时',
            2=>'2小时',
            3=>'3小时',
            4=>'4小时',
            5=>'5小时',
            6=>'6小时',
            7=>'7小时'
        );
        $this->load->view('teacher/' . $this->add_view,$data);
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->teacher_leave_model->get_one($id);
        $data ['value'] = $this->teacher_base_model->append_item ($value);
        $data['id'] = $id;
        $data['hournums']=array(
            0=>'0小时',
            1=>'1小时',
            2=>'2小时',
            3=>'3小时',
            4=>'4小时',
            5=>'5小时',
            6=>'6小时',
            7=>'7小时'
        );
        $this->load->view('teacher/' . $this->edit_view, $data);
    }
    public function save() {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $data['schoolid']=$this->schoolid;

        if($data['starttime']=='' || $data['endtime']==''){
            show_msg ( '时间不能为空！' );
        }
        if ($id) { // 修改 ===========
            $this->teacher_leave_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $data['teacherid']=$this->teacherid;
            $this->teacher_leave_model->insert($data);

            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
}
