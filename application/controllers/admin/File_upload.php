<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
class File_upload extends CI_Controller
{
    /**
     * 构造器
     *
     * @return void
     */
    function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
    }
    public function xls_upload()
    {
        if($this->input->post('upload')=='upload'){
            $uploadconfig['upload_path']='uploads/excel/'.date('Ymd').'/';
            if(!file_exists($uploadconfig['upload_path']))
            {
                _mkdir($uploadconfig['upload_path']);
            }
            $uploadconfig['allowed_types'] = '*';
            $uploadconfig['file_name']=time().'_'.rand(10000,99999);
            $uploadconfig['max_size'] = '2048';
            $uploadconfig['remove_spaces']  = TRUE;

            $this->upload->initialize($uploadconfig);
            if (!$this->upload->do_upload('Filedata')) {
                echo $this->upload->display_errors();exit;
            }
            else{
                $data = $this->upload->data();
                $data['url']=$uploadconfig['upload_path'].$data['file_name'];
                echo json_encode($data);exit;
            }
        }
    }
}