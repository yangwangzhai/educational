<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * 班级兴趣小组控制器
 * @ author qcl 2016-01-05
 */

include 'content.php';

class Interest_group extends Content
{

    function __construct ()
    {
        $class_name = 'interest_group';
        $this->name = '兴趣小组';
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=interest_group'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('classroom_model');
        $this->load->model('student_model');
        $this->load->model('interest_group_model');
    }

    // 首页
    public function index() {
        $searchsql = "1 AND schoolid=$this->schoolid";

        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode ( $keywords );
            $searchsql .= " AND title like '%{$keywords}%' ";
        }

        $data ['list'] = array ();
        $count = $this->interest_group_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->interest_group_model->get_list('*',$searchsql,$offset,20);
        foreach($list as &$item)
        {
            $item['addtime']=times($item['addtime']);
        }
        $list=$this->classroom_model->append_list($list);
        $data['list']=$list;
        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view ( 'admin/' . $this->list_view, $data );
    }
    /**
     * 添加
     *
     */
    public function add()
    {
        $this->load->view('admin/' . $this->add_view);
    }
    function dialog ()
    {
        $classid = getNumber ( $_GET ['classid'] );

        $studentid =$_GET ['studentid'];

        $list = $this->student_model->get_student_by_classid($classid);

        $ids=explode(',',$studentid);
        foreach($list as &$item)
        {
            $item['student']='';
            if(in_array($item['id'],$ids))
            {
                $item['student']='checked';
            }
        }
        $data['list']=$list;
        echo "<pre>";
        print_r($ids);
        print_r($data);
        echo "<pre/>";

        $this->load->view('admin/interest_group_dialog', $data);
    }

    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->interest_group_model->get_one($id);
        $value=$this->classroom_model->append_item($value);
        $student=@unserialize($value['student']);
        $value['studentname']='';
        $value['studentid']='';
        foreach($student as $v)
        {
            $arr=$this->student_model->get_one($v);
            $value['studentname'].=$arr['name'].',';
            $value['studentid'].=$v.',';
        }
        $data ['value']=$value;
        $data['id'] = $id;
        $this->load->view('admin/' . $this->edit_view, $data);
    }
    public function save() {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $data['schoolid']=$this->schoolid;

        if($data['title']==''){
            show_msg ( '兴趣小组名称不能为空！');
        }
        $student=explode(',',$data['student']);
        $data['student']=@serialize($student);
        $data['number']=count($student);
        if ($id) { // 修改 ===========
            $this->interest_group_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data['addtime']=time();
            $this->interest_group_model->insert($data);
            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }


}
