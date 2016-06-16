<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 教学资源 控制器
 * @author qcl 2016-01-13
 */

include 'content.php';
class Resource extends Content {
    public $catid;
    function __construct() {
        $class_name = 'resource';
        $this->name = "教学素材";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c='.$class_name; // 本控制器的前段URL

        parent::__construct();
        $this->load->model('resource_model');
        $this->load->model('teacher_base_model');
        $this->load->model('classroom_model');
        $this->load->model('resource_type_model');
        $this->load->model('resource_attachments_model');
    }

    // 首页
    public function index() {
        $searchsql = "1 AND schoolid='$this->schoolid'";

        $keywords =$this->input->post('keywords')?trim($this->input->post('keywords')):'';

        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode ( $keywords );
            $searchsql .= " AND title like '%{$keywords}%' ";
        }

        $data['list'] = array();
        $count = $this->resource_model->counts($searchsql);

        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')?intval($this->input->get('per_page')):0;
        $list = $this->resource_model->get_list("*",$searchsql,$offset,20);


        foreach($list as &$item) {
            $str = utf_substr($item['content'],60);
            if(strlen($item['content'])>60)
                $str .= '...';
            $item['content'] = $str;
        }
        $data['list'] = $list;


        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view ( 'admin/' . $this->list_view, $data );
    }

    /**
     *添加
     */
    public function add()
    {
        $token=md5(time().rand(0,9999));
        $data['token']=$token;
        $this->load->view('admin/' . $this->add_view,$data);
    }

    // 编辑
    public function edit() {
        $token=md5(time().rand(0,9999));
        $data['token']=$token;
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息

        $value = $this->resource_model->get_one($id);
        $value=$this->teacher_base_model->append_item($value);
        $value=$this->classroom_model->append_item($value);
        $data ['value'] = $value;
        $data['type']=$this->resource_type_model->get_one($value['type']);
        $data['attachments']=$this->resource_attachments_model->get_list('id,filename,savename');
        $data ['id'] = $id;

        $this->load->view ( 'admin/' . $this->edit_view, $data );
    }

    // 保存 添加和修改都是在这里
    public function save() {
        $token=$this->input->post('token')?$this->input->post('token'):0;
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $data['schoolid'] = $this->schoolid;

        if ($data ['type'] == "") {
            show_msg ( '素材分类不能为空' );
        }
        if ($data ['title'] == "") {
            show_msg ( '标题不能为空' );
        }
        if ($id) { // 修改 ===========
            $this->resource_model->update($id,$data);
            $this->resource_attachments_model->update_token($token,array('resourceid'=>$id));
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $insert_id=$this->resource_model->insert ($data);
            if($insert_id>=1)
            {
                $this->resource_attachments_model->update_token($token,array('resourceid'=>$insert_id));
            }
            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }

    /**
     *下载
     */
    public function download()
    {
        $id=$this->input->get('id');
        $document=$this->resource_model->get_one($id);
        $this->load->helper('download');
        $biddoc_name=$document['title'];//文档的名称，没有后缀
        $file_sub_dir=$document['resource'];        //文档存放的路径
        $type=substr($file_sub_dir,strrpos($file_sub_dir,".")); //获取文档的后缀
        $name="$biddoc_name"."$type";                   //拼接一个作为输出的文件名
        $data = file_get_contents($file_sub_dir); // 读文件内容
        //$name = 'myphoto.jpg';
        force_download($name, $data);
    }
    public function dialog()
    {
        $data['typename']=$this->input->get('typename');
        $arr = array() ;
        $resource_type_cache = $this->config->item('resource_type_cache');

        if(file_exists($resource_type_cache."/cache_type_{$this->schoolid}.inc.php")){
            require_once  $resource_type_cache."/cache_type_{$this->schoolid}.inc.php" ;
            $arr = $resource_type_array ;
        }
        $arr=$this->resource_type_model->get_list('id,pid,title',"schoolid=$this->schoolid",0,100);
        $data['list']=$this->resource_type_model->get_array($arr,0);
        //echo '<pre>';print_r($data['list']);echo '</pre>';
        $this->load->view('admin/resource_type_dialog',$data);
    }
    public function resource_type()
    {
        $arr=$this->resource_type_model->get_list('id,pid,title',"schoolid=$this->schoolid",0,100);
        $data['list']=$this->resource_type_model->get_array($arr,0);
        $this->load->view('admin/resource_type',$data);
    }
    //生成缓存
    private function make_cache($data){
        $resource_type_cache = $this->config->item('resource_type_cache');
        if(!is_really_writable($resource_type_cache)){
            exit("目录".$resource_type_cache."不可写");
        }

        if(!file_exists($resource_type_cache)){
            mkdir($resource_type_cache);
        }
        $configfile = $resource_type_cache."/cache_type_{$this->schoolid}.inc.php";
        $str = '' ;
        $time = date("Y-m-d H:i:s",time());
        $fp = fopen($configfile,'w');
        flock($fp,3);
        fwrite($fp,"<"."?php\r\n");
        fwrite($fp,"/*素材分类缓存*/\r\n");
        fwrite($fp,"/*author qcl*/\r\n");
        fwrite($fp,"/*time {$time}*/\r\n");
        //fwrite($fp,"\$role_array = array(\r\n");
        /* foreach($this->perm_data as $k=>$v){
            fwrite($fp,"'{$k}' => '{$v}',\r\n");
        } */
        $str.="\$role_array = ";
        $str.= var_export($data,true)  ;
        fwrite($fp,"{$str};\r\n");
        //fwrite($fp,");\r\n");
        fwrite($fp,"?".">");
        fclose($fp);
    }
    /**
     *附件上传
     */
    public function upload()
    {
        $this->load->library('upload');
        if($this->input->post('token'))
        {
            $token=$this->input->post('token')?$this->input->post('token'):0;
            $uploadconfig['upload_path']='uploads/docs/'.date('Ym').'/';
            if(!file_exists($uploadconfig['upload_path']))
            {
                mkdir($uploadconfig['upload_path']);
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
                    'token'=>$token,
                    'filename'=>$_FILES["Filedata"]["name"],
                    'filetype'=>$data['file_ext'],
                    'savename'=>$uploadconfig['upload_path'].$data['file_name'],
                    'addtime'=>time()
                );
                $insert_id=$this->resource_attachments_model->insert($insertdata);

                if ($insert_id >= 1) {
                    $insertdata['id']=$insert_id;
                }
                echo json_encode($insertdata,JSON_UNESCAPED_UNICODE);exit;
            }
        }
    }
    public function deletefileup()
    {
        $id=$this->input->post('id');
        $msg='error';
        if(is_numeric($id))
        {
            $flag=$this->resource_attachments_model->delete($id);
            if($flag)
            {
                $file_path=$this->input->post('file_path');
                if(file_exists($file_path))
                {
                    @unlink($file_path);
                }
                $msg='success';
            }
        }
        echo $msg;exit;
    }
}
