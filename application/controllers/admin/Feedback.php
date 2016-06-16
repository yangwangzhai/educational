<?php

include 'content.php';

/**
 * 网站介绍管理类
 * @author ryo 2015/05/04
 *
 */
class Feedback extends Content {
    /**
     * 构造器
     */
    function __construct ()
    {
        $class_name = 'feedback';
        $this->name = "家长反馈";
        $this->list_view = $class_name.'_list';
        $this->reply_view = $class_name.'_reply';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=feedback'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('feedback_model');
        $this->load->model('feedback_score_model');
        $this->load->model('parents_model');
        $this->load->model('teacher_base_model');
    }
    /**
     *回复保存出来
     */
    public function reply_save()
    {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        if ($data ['reply'] == "") {
            show_msg ( '回复内容不能为空' );
        }
        $this->feedback_model->update($id,$data);
        show_msg ( '回复成功！', $_SESSION ['url_forward'] );

    }

    /**
     *主页面
     */
    function index()
    {
        $searchsql = '1';
        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND content like '%{$keywords}%' ";
        }


        $data['list'] = array();
        $count = $this->feedback_model->counts($searchsql);
        $data['count'] = $count;


        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();


        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;
        $list = $this->feedback_model->get_list('*',$searchsql,$offset,20);
        $feedback_type=$this->config->item('feedback_type');
        foreach($list as &$item) {
            $str = strip_tags($item['content']);
            $str = utf_substr($str,60);
            if(strlen($item['content'])>60)
                $str .= '...';
            $item['content'] = $str;

            $item['pname']=$this->parents_model->get_one($item['parentid'])['username'];
            $item['tname']=$this->teacher_base_model->get_one($item['teacherid'])['truename'];
            $item['feedback_type']=$feedback_type[$item['feedback_type']];
        }
        $data['list'] =$list;

        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);  /**/
    }
    public function statistic()
    {
        $y=date('Y',time());
        if ($this->input->get('year')) {
            $y = $this->input->get('year');
        }
        $m=date('m',time());
        if ($this->input->get('month')) {
            $m = $this->input->get('month');
        }
        $date=$y.'-'.$m;
        $re=$this->feedback_model->statistic($this->schoolid,$date);
        foreach(config_item('feedback_type') as $k=>$v)
        {
            $list[$k]['num']=0;
            $list[$k]['feedback_type']=$v;
            if($re)
            {
                foreach($re as $item)
                {
                    if($item['feedback_type']==$k)
                    {
                        $list[$k]['num']+=$item['num'];
                    }
                }
            }
        }
        $data['list']=$list;
        $data['year']=$y;
        $data['month']=$m;
        $this->load->view('admin/feedback_statistic',$data);
    }
    /**
     *回复
     */
    public function detail()
    {
        if($this->input->get('id'))
        {
            $id=$this->input->get('id');
            $data['value']=$this->feedback_model->get_one($id);
            $data['id']=$id;
            $_SESSION['url_forward'] = $this->baseurl . "&m=detail&id=$id";
            $this->load->view('admin/feedback_detail', $data);
        }
    }
    public function progress()
    {
        if($this->input->get('id'))
        {
            $id=$this->input->get('id');
            $data['value']=$this->feedback_model->get_one($id);
            $this->load->view('admin/feedback_progress', $data);
        }
    }
    public function dialog()
    {
        $data['id']=$this->input->get('id');
        $data['type']=$this->input->get('type');
        $this->load->view('admin/feedback_dialog',$data);
    }
    public function active()
    {
        $id=$this->input->post('id');
        $type=$this->input->post('type');
        if($type=='ok' ||$type=='cancel')
        {
            $data['advice']=$this->input->post('content');
            if($type=='ok')
            {
                $data['feedback_active']=3;
            }
            else
            {
                $data['feedback_active']=5;
            }
        }
        elseif($type=='rectify')
        {
            $data['rectify']=$this->input->post('content');
            $data['feedback_active']=4;
        }
        elseif($type=='verify')
        {
            $data['verify']=$this->input->post('content');
            $data['score']=$this->input->post('score');
            $data['feedback_active']=5;
        }
        elseif($type=='check')
        {
            $data['check']=$this->input->post('content');
            $data['feedback_active']=6;
        }
        $this->feedback_model->update($id,$data);
        echo 1;exit;
    }
    /**
     * 添加
     */
    public function add ()
    {
        $data['feedback_date']=date('Y-m-d',time());
        $this->load->view('admin/' . $this->add_view,$data);
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->feedback_model->get_one($id);
        $value['pname']=$this->parents_model->get_one($value['parentid'])['username'];
        $value['tname']=$this->teacher_base_model->get_one($value['teacherid'])['truename'];
        $data['value'] = $this->parents_model->append_item($value);
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
        if ($data ['content'] == "") {
            show_msg ( '内容不能为空' );
        }
        if ($data ['parentid'] == "") {
            show_msg ( '家长不能为空' );
        }
        if ($data ['teacherid'] == "") {
            show_msg ( '教师不能为空' );
        }
        if ($data ['feedback_date'] == "") {
            unset ($data['feedback_date']);
        }
        if ($id) { // 修改 ===========
            $this->feedback_model->update($id,$data);
            $arr=array(
                'teacherid'=>$data['teacherid']
            );
            switch($data['feedback_type'])
            {
                case 1:
                    $arr['score']=-1;
                    break;
                case 2:
                    $arr['score']=0;
                    break;
                case 3:
                    $arr['score']=1;
                    $data['feedback_active']=6;
                    break;
            }
            $this->feedback_score_model->updata_by_feedback_id($id,$arr);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        }
        else{ // 添加 ===========
            $data['addtime']=time();
            $data['status']=0;
            $data['feedback_active']=2;
            switch($data['feedback_type'])
            {
                case 1:
                    $arr['score']=-1;
                    break;
                case 2:
                    $arr['score']=0;
                    break;
                case 3:
                    $arr['score']=1;
                    $data['feedback_active']=6;
                    break;
            }
            $insert_id=$this->feedback_model->insert($data);
            if($insert_id>=1)
            {
                $arr=array(
                    'schoolid'=>$this->schoolid,
                    'teacherid'=>$data['teacherid'],
                    'feedback_id'=>$insert_id,
                    'feedback_date'=>$data['feedback_date'],
                    'addtime'=>$data['addtime']
                );
                switch($data['feedback_type'])
                {
                    case 1:
                        $arr['score']=-1;
                        break;
                    case 2:
                        $arr['score']=0;
                        break;
                    case 1:
                        $arr['score']=1;
                        break;
                }
                $this->feedback_score_model->insert($arr);
            }
            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
}