<?php

include 'content.php';

/**
 * 奖罚控制器
 * @author qcl 2016/01/07
 *
 */
class Reward extends Content {
    /**
     * 构造器
     */
    function __construct ()
    {
        $class_name = 'reward';
        $this->name = "奖罚管理";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=Reward'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('reward_model');
    }
    /**
     *主页面
     */
    function index()
    {
        $searchsql = "1 AND schoolid=$this->schoolid";
        $type = $this->input->post('type')?$this->input->post('type'):0;
        if ($type) {
            $this->baseurl .= "&type=" . rawurlencode($type);
            $searchsql .= " and reward_type='$type' ";
            $data['type'] = $type;
        }
        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND name like '%{$keywords}%' ";
        }

        $data['list'] = array();
        $count = $this->reward_model->counts($searchsql);
        $data['count'] = $count;


        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();


        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->reward_model->get_list('*',$searchsql,$offset,20);
        $reward_type=$this->config->item('reward_type');
        foreach($list as &$item)
        {
            $item['addtime']=times($item['addtime']);
            $item['reward_type']=$reward_type[$item['reward_type']];
        }

        $data['list'] = $list;
        array_unshift($reward_type,'全部');
        $data['reward_type']=$reward_type;

        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);  /**/
    }
    /**
     * 添加
     *
     */
    public function add()
    {
        $data['reward_type'] = $this->config->item('reward_type');
        $this->load->view('admin/' . $this->add_view, $data);
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->reward_model->get_one($id);
        $data['value'] = $value;
        $data['id'] = $id;
        $data['reward_type'] = $this->config->item('reward_type');

        $this->load->view('admin/' . $this->edit_view, $data);
    }

    /**
     *保存
     */
    public function save()
    {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value']);
        $data['schoolid']=$this->schoolid;

        if ($data ['name'] == "") {
            show_msg('奖励名称不能为空！');
        }

        if ($id) { // 修改 ===========
            $this->reward_model->update($id,$data);
            show_msg('奖罚选项更新成功',$_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $this->reward_model->insert($data);
            show_msg('奖罚添加成功',$_SESSION['url_forward']);
        }
    }
    public function dialog()
    {
        $type = getNumber ( $_GET ['type'] );
        $list = $this->reward_model->get_list ('id,name',"schoolid=$this->schoolid AND reward_type=$type");

        $data ['list']=$list;
        $this->load->view ( 'admin/reward_dialog', $data );
    }
}