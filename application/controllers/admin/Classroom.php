<?php

include 'content.php';

/**
 * 班级控制器
 * @author qcl 2016/01/06
 *
 */
class Classroom extends Content {
    /**
     * 构造器
     */
    function __construct ()
    {
        $class_name = 'classroom';
        $this->name = "班级管理";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=Classroom'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('classroom_model');
    }
    /**
     *主页面
     */
    function index()
    {
        $searchsql = "1 AND schoolid=$this->schoolid";
        $grade = $this->input->post('grade')?$this->input->post('grade'):0;
        if ($grade) {
            $this->baseurl .= "&grade=" . rawurlencode($grade);
            $searchsql .= " and grade='$grade' ";
            $data['grade'] = $grade;
        }
        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND classname like '%{$keywords}%' ";
        }

        $data['list'] = array();
        $count = $this->classroom_model->counts($searchsql);
        $data['count'] = $count;


        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();


        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->classroom_model->get_list('*',$searchsql,$offset,20);

        $grade_list=$this->config->item('grade');
        foreach($list as &$item)
        {
            $item['addtime']=times($item['addtime']);
            //$item['grade']=$grade_list[$item['grade']];
            if($item['logo']!='')
            {
                $item['logo']="<img src='$item[logo]' height='35' />";
            }
        }

        $data['list'] = $list;
        array_unshift($grade_list,'全部');
        $data['grade_list']=$grade_list;

        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);  /**/
    }
    /**
     * 添加
     *
     */
    public function add()
    {
        $data['grade'] = $this->config->item('grade');
        $this->load->view('admin/' . $this->add_view, $data);
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->classroom_model->get_one($id);
        $data['value'] = $value;
        $data['id'] = $id;
        $data['grade'] = $this->config->item('grade');

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

        if ($data ['classname'] == "") {
            show_msg('班级名称不能为空！');
        }

        else
        {
            $re=$this->classroom_model->is_classname_exist($data ['classname'],$this->schoolid,$data['grade'],$id);
            if($re)
            {
                show_msg('班级名称已存在，请更换！');
            }
        }
        if($data['logo']!='')
        {
            thumb_small($data['logo'], 200, 150);
        }
        if ($id) { // 修改 ===========
            $this->classroom_model->update($id,$data);
            show_msg('班级更新成功',$_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $this->classroom_model->insert($data);
            show_msg('班级添加成功',$_SESSION['url_forward']);
        }
    }
    public function dialog()
    {
        $classes = $this->classroom_model->get_class_by_school_id ('id,classname,grade',$this->schoolid);
        $grade=$this->config->item('grade');
        foreach($classes as $item)
        {
            foreach($grade as $k=>$val)
            {
                if($k==$item['grade'])
                {
                    $classname[$val][]=$item;
                }
            }
        }
        $data ['classname']=$classname;
        $this->load->view ( 'admin/class_dialog', $data );
    }
    //异步获取班级
    function ajaxclass()
    {
        $grade=$this->input->post('grade');
        $list=$this->classroom_model->get_list('id,classname',"grade=$grade");
        if($list)
        {
            $result = array();
            foreach($list as $value) {
                $result[$value['id']] = $value['classname'];
            }
            echo json_encode($result);exit;
        }
        else
        {
            echo 'false';exit;
        }
    }
}