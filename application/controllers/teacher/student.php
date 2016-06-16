<?php

include 'content.php';

/**
 * 学生信息控制器
 * @author ryo 2015/05/04
 *
 */
class Student extends Content {
    /**
     * 构造器
     */
    function __construct ()
    {
        $class_name = 'student';
        $this->name = "学生信息";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=student'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('student_model');
        $this->load->model('parents_model');
        $this->load->model('classroom_model');
        $this->load->model('teacher_base_model');
        $this->load->model('footmark_model');
    }

    /**
     *主页面
     */
    function index()
    {
        if( get_cookie ('classname')==null)
        {
            show_msg('没有找到你的班级 请先设置班级！', 'index.php?d=teacher&c=class_list&m=index');
        }
        else {
            $classname = get_cookie('classname');
            $value=$this->classroom_model->get_class_by_classname($classname);
            $searchsql = "1 AND classid=$value[id]";

            $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
            if ($keywords) {
                $this->baseurl .= "&keywords=" . rawurlencode($keywords);
                $searchsql .= " AND name like '%{$keywords}%' ";
            }

            $data['list'] = array();
            $count = $this->student_model->counts($searchsql);
            $data['count'] = $count;

            $this->config->load('pagination', TRUE);
            $pagination = $this->config->item('pagination');
            $pagination['base_url'] = $this->baseurl;
            $pagination['total_rows'] = $count;
            $this->load->library('pagination');
            $this->pagination->initialize($pagination);
            $data['pages'] = $this->pagination->create_links();


            $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;
            $gender=$this->config->item('gender');
            $list = $this->student_model->get_list('*',$searchsql,$offset,20);
            foreach($list as &$item) {
                if($item ['thumb']) {
                    $item ['thumb'] = new_thumbname ( $item ['thumb'], 100, 100 );
                }
                $item['gender']=$gender[$item['gender']];
            }
            $data['list'] =$this->classroom_model->append_list($list);

            $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
            $this->load->view('teacher/' . $this->list_view, $data);
        }

    }

    /**
     * 添加
     *
     */
    public function add()
    {
        $classname = get_cookie('classname');
        $class=$this->classroom_model->get_class_by_classname($classname);
        $data ['value']['classname']=setClassname($classname);
        $data ['value']['classid']=$class['id'];
        $data ['value'] ['birthday'] = '2011-01-01';
        $data ['value'] ['pubdate'] = date('Y',time()).'-09-01';
        $this->load->view ( 'teacher/' . $this->add_view, $data );
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->student_model->get_one($id);
        $data['value']=$this->classroom_model->append_item($value);

        $data['id'] = $id;

        $this->load->view('teacher/' . $this->edit_view, $data);
    }

    /**
     *保存
     */
    public function save()
    {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $data['schoolid']=$this->schoolid;
        if ($data ['classid'] == "") {
            show_msg ( '班级名称不能为空' );
        }
        if ($data ['name'] == "") {
            show_msg ( '学生姓名不能为空' );
        }
        if ($data ['birthday']=='' ) {
            unset($data ['birthday']);
        }
        if ($data ['pubdate']=='' ) {
            unset($data ['pubdate']);
        }
        if ($data ['thumb'] ) {
            thumb($data ['thumb']);
        }
        if ($id) { // 修改 ===========
            $this->student_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $this->student_model->insert($data);

            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
    /**
     *详情
     */
    public function detail()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->student_model->get_one($id);
        $data['value'] =$value;
        $classinfo=$this->classroom_model->get_one($value['classid']);
        $data['classinfo']=$classinfo;
        $data['manage_teacher']=$this->teacher_base_model->get_manage_teacher_by_class($classinfo['classname']);
        $data['teach_teacher']=$this->teacher_base_model->get_teach_teacher_by_classid($classinfo['classname']);//$data['manage_teacher']
        $data['parents']=$this->parents_model->get_parents_by_studentid($id);
        $data['footmark']=$this->footmark_model->get_footmark_by_studentid($id);
        $data['id'] = $id;
        $this->load->view('teacher/student_detail', $data);
    }
    public function reason()
    {
        $re= $this->student_model->statistic_reason($this->schoolid);

        foreach ($re as $key=>$item) {
            $list[$key]['name']=$item['reason'];
            $list[$key]['value']=$item['num'];
        }
        $data['value']=$list;var_dump($list);
        $this->load->view ( 'teacher/student_reason',$data);
    }
    public function import()
    {
        $this->load->view ( 'teacher/student_import');
    }
    /**
     *导入学生
     */
    public function excelIn()
    {
        $classname = get_cookie('classname');
        $value=$this->classroom_model->get_class_by_classname($classname);
        if($this->input->post('filename'))
        {
            $filename=$this->input->post('filename');
            require_once APPPATH . 'libraries/Spreadsheet_Excel_Reader.php'; // 加载类
            $data = new Spreadsheet_Excel_Reader (); // 实例化
            $data->setOutputEncoding('utf-8'); // 设置编码

            // 读取电子表格
            $gender=array_flip(config_item('gender'));
            foreach($filename as $itemFile)
            {
                $data->read($itemFile); // read函数读取所需EXCEL表，支持中文
                // print_r($data->sheets[0]['cells']);
                foreach ($data->sheets [0] ['cells'] as $key => $row) {
                    if ($key == 1 || $key == 2) continue; // 第一行是 标题 不用导入
                    if(isset($row[1])==false || isset($row [4])==false)continue;//家长姓名，学生姓名不能为空
                    $stu ['name'] = $row [1];
                    if(isset($row[2]))
                    {
                        $stu ['gender'] = $gender[$row [2]];
                    }
                    if(isset($row [3]))
                    {
                        $stu ['birthday'] = date('Y-m-d',strtotime("-1 days",strtotime(excelTime($row [3]))));
                    }
                    $result=$this->classroom_model->get_class_by_nickname($row [4]);
                    if(empty($result) || $result['nickname']!=$value['nickname'])
                    {
                        continue;
                    }
                    $stu ['classid'] = $result['id'];
                    if(isset($row[5]))
                    {
                        $stu ['number'] = $row [5];
                    }
                    if(isset($row [6]))
                    {
                        $stu ['nation'] = $row [6];
                    }
                    if(isset($row [7]))
                    {
                        $stu ['place'] = $row [7];
                    }

                    if(isset($row [8]))
                    {
                        $stu ['pubdate'] = date('Y-m-d',strtotime("-1 days",strtotime(excelTime($row [8]))));
                    }
                    if(isset($row [9]))
                    {
                        $stu ['tel'] = $row [9];
                    }
                    if(isset($row [10]))
                    {
                        $stu ['address'] = $row [10];
                    }
                    if(isset($row [11]))
                    {
                        $stu ['allergic'] = $row [11];
                    }
                    if(isset($row [12]))
                    {
                        $stu ['content'] = $row [12];
                    }

                    $stu ['addtime'] = time();
                    $stu ['schoolid'] = $this->schoolid;
                    $this->student_model->insert($stu);   // 插入学生数据库
                }
            }
            echo 1;exit;
            /*show_msg("导入完成！", 'index.php?d=admin&c=student&m=index');*/
        }
    }
    function export()
    {
        $this->load->view('teacher/student_export');
    }
    function export_save()
    {
        $classname = get_cookie('classname');
        $value=$this->classroom_model->get_class_by_classname($classname);
        $searchsql = "1 AND classid=$value[id]";
        $type=$this->input->get('type');
        if(in_array($type,array('base','detail')))
        {
            switch($type)
            {
                case 'base':
                    $url='student_base_export';
                    $data['title']='幼儿基本信息表';
                    break;
                case 'detail':
                    $url='student_detail_export';
                    $data['title']='幼儿详细信息表';
                    break;
            }
            $list = $this->student_model->get_list('*',$searchsql,0,1000);
            $data['list']=$this->classroom_model->append_list($list);

            $this->load->view('teacher/'.$url,$data);
        }

    }
    // 弹出框
    function dialog() {
        $classid = getNumber ( $_GET ['classid'] );

        $data ['list'] = $this->student_model->get_student_by_classid($classid);

        $this->load->view ( 'teacher/student_dialog', $data );
    }
}