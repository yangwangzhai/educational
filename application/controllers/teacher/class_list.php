<?php

include 'content.php';

/**
 * 家长反馈
 * @author ryo 2015/05/04
 *
 */
class Class_list extends Content {
    /**
     * 构造器
     */
    function __construct ()
    {
        $class_name = 'class_list';
        $this->name = "班级信息";
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=class_list'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('classroom_model');
        $this->load->model('class_review_model');
    }
    /**
     *主页面
     */
    function index()
    {
        $data ['teach_class'] = explode (',', $this->teacher['teach_class']);
        $_SESSION ['url_forward'] ="$this->baseurl&m=index";
        $this->load->view ( 'teacher/classes', $data );
    }
    // 选择班级
    public function choose() {
        set_cookie ( 'classname', $_GET ['classname'], TEN_YEAR );
        $data ['classname'] = setClassname($_GET ['classname']);

        $this->load->view ( 'teacher/class_choose', $data );
    }

    public function class_info() {
        if( get_cookie ('classname')==null)
        {
            show_msg('没有找到你的班级 请联系管理员！', $_SESSION ['url_forward']);
        }
        else
        {
            $classname =  get_cookie ('classname');
            $value=$this->classroom_model->get_class_by_classname($classname);
            $data['grade'] = $this->config->item('grade');
            $data['value']=$value;
            $_SESSION ['url_forward'] ="$this->baseurl&m=class_info";
            $this->load->view ( 'teacher/class_info', $data );
        }
    }
    /**
     *保存
     */
    public function save()
    {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $message=$data ['classname'];
        $data ['classname']=getNumber($data ['classname']);

        if ($data ['classname'] == "") {
            show_msg('班级名称不能为空！');
        }
        if(preg_match('/^([0-9_\.-]+)级([0-9_\.-]+)\班/',$message)==0){ //匹配
            show_msg('班级名格式不正确； 格式为： XXXX级X班');
        }
        else
        {
            $re=$this->classroom_model->is_classname_exist($data ['classname'],$id);
            if($re)
            {
                show_msg('班级名已存在，请更换');
            }
        }
        if ($data ['nickname'] == "") {
            show_msg('班级昵称不能为空');
        }
        if ($id) { // 修改 ===========
            $this->classroom_model->update($id,$data);
            show_msg('班级修改成功',$_SESSION['url_forward']);
        }
    }
    public function review_list()
    {
        $cur_year=date('Y',time());
        if($this->input->get('year'))
        {
            $cur_year=$this->input->get('year');
        }
        if( get_cookie ('classname')==null)
        {
            show_msg('没有找到你的班级 请联系管理员！', $_SESSION ['url_forward']);
        }
        else {
            $classname = get_cookie('classname');
            $class= $this->classroom_model->get_class_by_classname($classname);
            for($i=1;$i<=12;$i++)
            {
                $list[$i]=$this->class_review_model->get_one_class_review($class['id'],$cur_year,$i);
            }
        }
        $data['list']=$list;
        $this->load->view('teacher/class_review_list',$data);
    }
}