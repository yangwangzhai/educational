<?php

include 'content.php';

/**
 * 教师控制器
 * @author ryo 2015/05/04
 *
 */
class Teacher extends Content {
    /**
     * 构造器
     */
    function __construct ()
    {
        $class_name = 'teacher';
        $this->name = "教师";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=teacher'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('teacher_base_model');
        $this->load->model('classroom_model');
        $this->load->model('contract_model');
        $this->load->model('history_model');
        $this->load->model('train_model');
        $this->load->model('train_num_model');
    }


    function history()
    {
        $teacherid = $this->teacherid;
        $value=$this->history_model->get_history_by_teacherid($teacherid);
        $data['uid']=$value['uid'];
        if(empty($value))
        {
            $value=array(
                'schoolid'=>$this->schoolid,
                'addtime'=>time(),
                'updatetime'=>time(),
                'edu'=>'',
                'works'=>'',
                'spec'=>'',
                'lang'=>'',
                'it'=>'',
                'jc'=>'',
                'selfcomm'=>'',
                'teacherid'=>$teacherid
            );
            $insert_id=$this->history_model->insert($value);
            $data['id']=$insert_id;
        }
        $train=$this->train_num_model->get_list('train_id',"teacherid=$teacherid");
        $data['train']=$this->train_model->append_list($train);

        $data['id']=$value['id'];
        $data['value']=$value;
        $_SESSION ['url_forward']="$this->baseurl&m=history";
        $this->load->view ( 'teacher/teacher_history',$data );
    }
    // 保存 添加和修改都是在这里
    public function history_save() {
        $data = trims ( $_POST ['value'] );
        $id = $this->input->post('id');
        $data['updatetime']=time();
        // 修改 ===========
        $this->history_model->update($id,$data);
        show_msg ( '保存成功！' ,$_SESSION['url_forward']);

    }
    /**
     * 编辑
     */
    public function edit ()
    {
        // 这条信息
        $teacher=$this->teacher;
        $arr=$this->classroom_model->get_field($this->schoolid);
        $data['manageid_array'] = explode(',', setClassname($teacher['manage_class']));
        $data['classid_array'] = explode(',', setClassname($teacher['teach_class']));
        $class=setClassname(implode(',',$arr));
        $data['class_list']=explode(',',$class);
        $data['value'] = $teacher;
        $this->load->view('teacher/' . $this->edit_view, $data);
    }

    /**
     *保存
     */
    public function save()
    {
        $teacherid = $this->teacherid;
        $data = trims ( $_POST ['value'] );


        if ($data ['truename'] == "") {
            show_msg ( '姓名不能为空' );
        }
        // 检查手机号码
        if (empty($data ['tel'])) {
            show_msg ( '办公电话不能为空' );
        }

        if($this->teacher_base_model->is_tel_exist($data['tel'], $teacherid)){
            show_msg ( '手机号码已经存在，请更换' );
        }
        if($data['joinin']==''){
            unset($data['joinin']);
        }
        if($data['expireto']==''){
            unset($data['expireto']);
        }
        if($data['birthday']==''){
            unset($data['birthday']);
        }
        if ($data ['thumb']) {
            thumb ( $data ['thumb'] );
        }

        // 附表
        $data['teach_class'] = $data['manage_class'] = '';
        $manage = $this->input->post ('manage');
        if(!empty($manage)) $data['manage_class'] = join(',', getNumber($manage));
        $class = $this->input->post ('class');
        if(!empty($class)) $data['teach_class'] = join(',', getNumber($class));

        if ($teacherid) { // 修改 ===========
            $data['status2'] = 1;
            $this->teacher_base_model->update($teacherid,$data);
            $teacher=$this->teacher_base_model->get_one($teacherid);
            $this->session->set_userdata ( 'teacher', $teacher );
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );

        }
    }
    /**
     *教师详细信息
     */
    function detail()
    {
        $teacherid = $this->teacherid;
        // 这条信息
        $data['value']=$this->teacher;
        $history=$this->history_model->get_history_by_teacherid($teacherid);
        if(empty($history))
        {
            $history=array(
                'schoolid'=>$this->schoolid,
                'addtime'=>time(),
                'updatetime'=>time(),
                'edu'=>'',
                'works'=>'',
                'spec'=>'',
                'lang'=>'',
                'it'=>'',
                'jc'=>'',
                'selfcomm'=>'',
                'teacherid'=>$teacherid
            );
            $this->history_model->insert($history);
        }
        $data['history']=$history;
        $_SESSION ['url_forward']="$this->baseurl&m=detail";
        $train=$this->train_num_model->get_list('train_id',"teacherid=$teacherid");
        $data['train']=$this->train_model->append_list($train);
        $this->load->view('teacher/teacher_detail', $data);
    }
    /**
     * 更新 访问量
     *
     * @param int $id
     * @param int $status
     * @return array 二维数组
     */
    function update_status() {
        $id = $this->teacherid;
        $status=$this->input->get('status');
        if ($id == 0)
            return false;
          $this->teacher_base_model->update ($id,array('status'=>$status));
    }
    // 修改密码页
    public function password() {

        // 这条信息
        $_SESSION ['url_forward']="$this->baseurl&m=password";
        $this->load->view ( 'teacher/teacher_password' );
    }

    // 保存密码
    public function password_save() {
        $id = $this->teacherid;
        $data = trims ( $_POST ['value'] );

        if ($data ['password'] == "") {
            show_msg ( '密码不能为空' );
        }
        if ($data ['password'] != $data ['password2']) {
            show_msg ( '两次密码不相同' );
        }
        if (strlen($data ['password'])<6) {
            show_msg ( '密码不能少于6位' );
        }

        $data ['password'] = get_password ( $data ['password'] );
        unset($data ['password2']);

        $this->teacher_base_model->update($id,$data);

        show_msg ( '修改成功！', $_SESSION ['url_forward'] );
    }
}