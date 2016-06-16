<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

// 教师合同信息

include 'content.php';

class Contract extends Content
{

    function __construct ()
    {
        $class_name = 'contract';
        $this->name = '合同信息';
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->detail_view = $class_name.'_detail';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=contract'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('contract_model');
    }

    // 首页
    public function index() {
        $teacherid=$this->teacherid;
        $searchsql = "1 AND teacherid=$teacherid";

        $status = $this->input->post('contract_status')?trim($this->input->post('contract_status')):'';
        if($status)
        {
            $this->baseurl .= "&contract_status=" . rawurlencode ( $status );
            $searchsql .= " AND contract_status='$status' ";
        }
        $data['status']=$status;
        $data ['list'] = array ();
        $count = $this->contract_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->contract_model->get_list('*',$searchsql,$offset,20);
        $contract_type=$this->config->item('contract_type');
        $contract_status=$this->config->item('contract_status');
        foreach($list as &$item) {
            $item['contract_type']=$contract_type[$item['contract_type']];
            $item['contract_status']=$contract_status[$item['contract_status']];
        }
        $data ['list'] =$list;

        $contract_status=$this->config->item('contract_status');
        $contract_status[0]='不限';
        ksort($contract_status);
        $data['contract_status']=$contract_status;
        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view ( 'teacher/' . $this->list_view, $data );
    }

    /**
     * 编辑
     */
    public function detail ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->contract_model->get_one($id);
        $data ['value'] = $value;
        $data['id'] = $id;
        $data['contract_status']=$this->config->item('contract_status');
        $this->load->view('teacher/' . $this->detail_view, $data);
    }
}
