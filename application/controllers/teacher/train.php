<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

// 招聘管理

include 'content.php';

class Train extends Content
{

    function __construct ()
    {
        $class_name = 'train';
        $this->name = '培训';
        $this->list_view = $class_name.'_list';
        $this->detail_view = $class_name.'_detail';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=train'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('train_model');
        $this->load->model('train_num_model');
        $this->load->model('docs_model');
    }

    // 首页
    public function index() {
        $teacherid=$this->teacherid;
        $searchsql = "1 AND teacherid=$teacherid";

        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        $type = $this->input->post('train_type')?trim($this->input->post('train_type')):'';
        if($type)
        {
            $this->baseurl .= "&train_type=" . rawurlencode ( $type );
            $searchsql .= " AND train_type='$type' ";
        }
        $data['type']=$type;
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode ( $keywords );
            $searchsql .= " AND title like '%{$keywords}%' ";
        }

        $data ['list'] = array ();
        $count = $this->train_num_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $re = $this->train_num_model->get_list('*',$searchsql,$offset,20);
        $train_type=$this->config->item('train_type');
        foreach($re as $item) {
            $list[]=$this->train_model->get_one($item['train_id']);
        }
        $data['list']=$list;
        $train_type[0]='不限';
        ksort($train_type);
        $data['train_type']=$train_type;
        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view ( 'teacher/' . $this->list_view, $data );
    }
    /**
     *详情
     */
    public function detail()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        $_SESSION ['url_forward'] = $this->baseurl . "&m=edit&id=$id";
        // 这条信息
        $data ['value'] = $this->train_model->get_one($id);
        $data['docs']=$this->docs_model->get_list('*',"train_id=$id",0,10);
        $data['id'] = $id;
        $this->load->view('teacher/' . $this->detail_view, $data);
    }
}
