<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * 教师培训控制器
 * @ author qcl 2016-01-05
 */

include 'content.php';

class Train extends Content
{

    function __construct ()
    {
        $class_name = 'train';
        $this->name = '培训';
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=train'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('train_model');
        $this->load->model('train_num_model');
        $this->load->library('upload');
        $this->load->model('docs_model');
        $this->load->model('teacher_base_model');
    }

    // 首页
    public function index() {
        $searchsql = "1 AND schoolid=$this->schoolid";

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
        $count = $this->train_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->train_model->get_list('*',$searchsql,$offset,20);
        $train_type=$this->config->item('train_type');
        foreach($list as &$item) {
            $item['train_type']=$train_type[$item['train_type']];
        }
        $data['list']=$list;
        $train_type[0]='不限';
        ksort($train_type);
        $data['train_type']=$train_type;
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
        $where="schoolid=$this->schoolid";

        $train_id=$this->input->get('train_id')?$this->input->get('train_id'):'0';
        $list = $this->teacher_base_model->get_list('id,truename',$where,0,50);
        foreach($list as &$item)
        {
            $train=$this->train_num_model->get_train_num_by_train_id($train_id,$item['id']);
            $item['train']='';
            if($train)
            {
                $item['train']='checked';
            }
        }
        $data['train_id']=$train_id;
        $data['list']=$list;
        $this->load->view('admin/train_dialog', $data);
    }
    function teacher_save()
    {
        $uids=$this->input->post('arr');
        $train_id=$this->input->post('train_id');
        $this->train_num_model->delete_by_train_num_id($train_id);
        if(is_array($uids))
        {
            foreach($uids as $item)
            {
                $data=array(
                    'train_id'=>$train_id,
                    'schoolid'=>$this->schoolid,
                    'addtime'=>time(),
                    'teacherid'=>$item
                );
                $this->train_num_model->insert($data);
            }
            echo 1;exit;
        }
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        $_SESSION ['url_forward'] = $this->baseurl . "&m=edit&id=$id";
        // 这条信息
        $data ['value'] = $this->train_model->get_one($id);
        $data['docs']=$this->docs_model->get_list('*',"train_id=$id",0,10);
        $data['id'] = $id;
        $this->load->view('admin/' . $this->edit_view, $data);
    }
    public function save() {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $data['schoolid']=$this->schoolid;

        if($data['title']==''){
            show_msg ( '培训名称不能为空！' );
        }
        if($data['begintime']==''){
            unset($data['begintime']);
        }
        if($data['endtime']==''){
            unset($data['endtime']);
        }
        if ($id) { // 修改 ===========
            $this->train_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data['addtime']=time();
            $insert_id=$this->train_model->insert($data);
            if($insert_id>=1)
            {
                $this->train_num_model->update_by_train_num_id('0',array('train_id'=>$insert_id));
                $this->docs_model->update_by_train_id('0',array('train_id'=>$insert_id));
            }
            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
    public function delete_docs()
    {
        $id = $this->input->get('id');
        if ($id)
        {
            $this->docs_model->delete($id);
            show_msg('删除成功！', $_SESSION['url_forward']);
        }
    }
    /**
     *附件上传
     */
    public function upload()
    {
        if($this->input->post('id'))
        {
            $id=is_numeric($this->input->post('id'))?$this->input->post('id'):0;
            $uploadconfig['upload_path']='uploads/docs/'.date('Ym').'/';
            if(!file_exists($uploadconfig['upload_path']))
            {
                _mkdir($uploadconfig['upload_path']);
            }
            $uploadconfig['allowed_types'] = '*';
            $uploadconfig['file_name']=time().'_'.rand(10000,99999);
            $uploadconfig['max_size'] = '1048576';//2G
            $uploadconfig['remove_spaces']  = TRUE;

            $this->upload->initialize($uploadconfig);
            if (!$this->upload->do_upload('Filedata')) {
                    echo $this->upload->display_errors();exit;
            }
            else{
                $data = $this->upload->data();
                $insertdata = array(
                    'train_id'=>$id,
                    'schoolid'=>$this->schoolid,
                    'filename'=>$_FILES["Filedata"]["name"],
                    'doctype'=>$data['file_ext'],
                    'src'=>$uploadconfig['upload_path'].$data['file_name'],
                    'size'=>$data['file_size'],
                    'addtime'=>time()
                );
                $insert_id=$this->docs_model->insert($insertdata);
                $doc_str = '';
                if ($insert_id >= 1) {
                    $addtime = times($insertdata['addtime'], 0);
                    $doc_str .= "<td style='width:70px;'>$insert_id</td>
                    <td width='250'> <a href='$insertdata[src]' target='_blank'>$insertdata[filename]</a></td>
                    <td style='width:150px;'>$addtime</td>
                    <td style='width:100px;'>$insertdata[size]</td>
                    <td width='150'> </td>";
                }
                echo $doc_str;exit;
            }
        }
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
        $this->load->view('admin/train_detail', $data);
    }
}
