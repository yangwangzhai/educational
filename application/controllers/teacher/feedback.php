<?php

include 'content.php';

/**
 * 家长反馈
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
        $this->baseurl = 'index.php?d=teacher&c=feedback'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('feedback_model');
        $this->load->model('feedback_score_model');
        $this->load->model('parents_model');
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
        $teacherid=$this->teacherid;
        $searchsql = "1 AND teacherid=$teacherid";
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

            $item['pname']=$this->parents_model->get_one($item['pid'])['username'];
            $item['tname']=$this->teacher['truename'];
            $item['feedback_type']=$feedback_type[$item['feedback_type']];
        }
        $data['list'] =$list;

        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('teacher/' . $this->list_view, $data);  /**/
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
            $this->load->view('teacher/feedback_detail', $data);
        }
    }
    public function progress()
    {
        if($this->input->get('id'))
        {
            $id=$this->input->get('id');
            $data['value']=$this->feedback_model->get_one($id);
            $this->load->view('teacher/feedback_progress', $data);
        }
    }
    public function dialog()
    {
        $data['id']=$this->input->get('id');
        $data['type']=$this->input->get('type');
        $this->load->view('teacher/feedback_dialog',$data);
    }
    public function active()
    {
        $id=$this->input->post('id');
        $type=$this->input->post('type');
        if($type=='rectify')
        {
            $data['rectify']=$this->input->post('content');
            $data['feedback_active']=4;
        }
        $this->feedback_model->update($id,$data);
        echo 1;exit;
    }
}