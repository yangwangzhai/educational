<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * 学生奖罚信息
 * @ author qcl 2016-01-07
 */

include 'content.php';

class Student_reward extends Content
{

    function __construct ()
    {
        $class_name = 'student_reward';
        $this->name = '学生奖罚';
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=student_reward'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('student_reward_model');
        $this->load->model('reward_model');
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
        $count = $this->student_reward_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->student_reward_model->get_student_reward($searchsql,$offset,20);
        $list=$this->classroom_model->append_list($list);
        $reward_type=$this->config->item('reward_type');
        foreach($list as &$item)
        {
            $reward=$this->reward_model->get_one($item['rewardid']);
            if($reward)
            {
                $item['rewardname']=$reward['name'];
                $item['type']=$reward_type[$reward['reward_type']];
                $item['grade']=$reward['grade'];
            }
            $item['addtime']=times($item['addtime']);
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
        $data['pubdate']=times(time());
        $data['type']=$this->config->item('reward_type');
        $this->load->view ( 'admin/' . $this->add_view,$data );
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $this->load->model('teacher_base_model');
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->student_reward_model->get_one($id);
        $student=$this->student_model->get_one($value['studentid']);
        $value['studentname']=$student['name'];
        $value['classid']=$student['classid'];
        $value=$this->classroom_model->append_item($value);

        $value=$this->teacher_base_model->append_item($value);
        $reward=$this->reward_model->get_one($value['rewardid']);
        if($reward)
        {
            $value['rewardname']=$reward['name'];
            $value['type']=$reward['reward_type'];
        }
        $value['addtime']=times($value['addtime']);
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
        if ($data ['rewardid'] == "") {
            show_msg ( '奖罚名称不能为空' );
        }
        if($data['reward_type']==2)
        {
            $data['teacherid']=$this->input->post('teacherid');
            $data['doc']=uploadFile('file','doc');
        }
        unset($data['reward_type']);
        if ($id) { // 修改 ===========
            $this->student_reward_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $this->student_reward_model->insert($data);

            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
}
