<?php

include 'content.php';

/**
 * 学生体检数据
 * @author ryo 2015/05/04
 *
 */
class Physical extends Content {
    /**
     * 构造器
     */
    function __construct ()
    {
        $class_name = 'physical';
        $this->name = "体征数据";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=physical'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('physical_model');
        $this->load->model('student_model');
        $this->load->model('classroom_model');
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
            $classinfo = $this->classroom_model->get_class_by_classname($classname);
            $searchsql = "1 AND b.classid=$classinfo[id]";
            $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
            $semester = $this->input->post('semester')?$this->input->post('semester'):'';
            if ($semester) {
                $this->baseurl .= "&semester=" . rawurlencode ( $semester );
                $searchsql .= " AND a.semester='$semester' ";
            }
            $data['semester_s']=$semester;
            if ($keywords) {
                $this->baseurl .= "&keywords=" . rawurlencode($keywords);
                $searchsql .= " AND name like '%{$keywords}%' ";
            }

            $data['list'] = array();
            $count = $this->physical_model->counts($searchsql);
            $data['count'] = $count;

            $this->config->load('pagination', TRUE);
            $pagination = $this->config->item('pagination');
            $pagination['base_url'] = $this->baseurl;
            $pagination['total_rows'] = $count;
            $this->load->library('pagination');
            $this->pagination->initialize($pagination);
            $data['pages'] = $this->pagination->create_links();


            $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

            $list = $this->physical_model->get_physical($searchsql,$offset,20);
            $gender=$this->config->item('gender');
            $semester=$this->config->item('semester');
            foreach($list as &$item) {
                $item['semester']=$semester[$item['semester']];
                $item['gender']=$gender[$item['gender']];
                $item ['age']=get_age($item['birthday'],$item['dodate']);
            }

            $data['list'] = $this->classroom_model->append_list($list);

            $semester[0]='不限';
            ksort($semester);
            $data['semester']=$semester;
            $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
            $this->load->view('teacher/' . $this->list_view, $data);  /**/
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
        $data ['value'] ['pubdate'] = date('Y-m-d',time());
        $this->load->view ( 'teacher/' . $this->add_view,$data );
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->physical_model->get_one($id);
        $data['value'] =$this->student_model->append_item($value);
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
        if ($data ['studentid'] == "") {
            show_msg ( '学生姓名不能为空' );
        }
        if ($data ['dodate'] == "") {
            unset ($data['dodate']);
        }
        if(!is_numeric($data['temperature']))
        {
            show_msg ( '体温参数不正确' );
        }
        if ($id) { // 修改 ===========
            $this->physical_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $this->physical_model->insert($data);

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
        $value = $this->physical_model->get_physical_by_id($id);
        $data['value'] =$this->classroom_model->append_item($value);
        $data['id'] = $id;
        $this->load->view('teacher/physical_detail', $data);
    }
    public function import()
    {
        $this->load->view ( 'teacher/physical_import');
    }
    /**
     *导入学生体征数据
     */
    public function excelIn()
    {
        if($this->input->post('filename'))
        {
            $classname = get_cookie('classname');
            $classinfo = $this->classroom_model->get_class_by_classname($classname);
            $filename=$this->input->post('filename');
            require_once APPPATH . 'libraries/Spreadsheet_Excel_Reader.php'; // 加载类
            $data = new Spreadsheet_Excel_Reader (); // 实例化
            $data->setOutputEncoding('utf-8'); // 设置编码

            // 读取电子表格
            $semester = array_flip(config_item('semester'));
            foreach($filename as $itemFile) {
                $data->read($itemFile); // read函数读取所需EXCEL表，支持中文
                $physical = array();
                $schoolid = $this->schoolid;
                $physical['addtime'] = time();

                foreach ($data->sheets [0] ['cells'] as $key => $row) {
                    if ($key == 1) continue; // 第一行是 标题 不用导入
                    if(isset($row[1])==false || isset($row [2])==false)continue;//家长姓名，学生姓名不能为空
                    $physical ['semester'] = $semester[$row [2]];
                    $value = $this->student_model->get_student_by_name($row [1]);
                    if (empty($value) || $value['classid']!=$classinfo['id']) {
                        continue;
                    }
                    $physical ['studentid'] = $value['id'];
                    $physical ['schoolid'] = $schoolid;
                    if(isset($row[4]))
                    {
                        $physical ['weight'] = $row [4];
                    }
                    if(isset($row[5]))
                    {
                        $physical ['height'] = $row [5];
                    }
                    if(isset($row[6]))
                    {
                        $physical ['teeth'] = $row [6];
                    }
                    if(isset($row[7]))
                    {
                        $physical ['decay'] = $row [7];
                    }
                    if(isset($row[8]))
                    {
                        $physical ['listening'] = $row [8];
                    }
                    if(isset($row[9]))
                    {
                        $physical ['blindness'] = $row [9];
                    }
                    if(isset($row[10]))
                    {
                        $physical ['temperature'] = $row [10];
                    }
                    if(isset($row[11]))
                    {
                        $physical ['heart'] = $row [11];
                    }
                    if(isset($row[12]))
                    {
                        $physical ['content'] = $row [12];
                    }
                    if(isset($row[3]))
                    {
                        $date = date('Y-m-d', strtotime("-1 days", strtotime(excelTime($row [3]))));
                        $physical ['dodate'] = $date;
                    }
                    $this->physical_model->insert($physical);
                }
            }
            echo 1;exit;
        }
    }
}