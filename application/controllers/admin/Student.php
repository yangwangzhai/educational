<?php

include 'content.php';

/**
 * 学生控制器
 * @author qcl 2016/01/06
 *
 */
class Student extends Content {
    /**
     * 构造器
     */
    function __construct ()
    {
        $class_name = 'student';
        $this->name = "学生";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=student'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('student_model');
        $this->load->model('parents_model');
        $this->load->model('classroom_model');
        $this->load->model('teacher_base_model');
    }

    /**
     *主页面
     */
    function index()
    {
        $data['grade']=$grade = $this->input->post('grade')?trim($this->input->post('grade')):'2015';
        $data['class']=$class = $this->input->post('class')?trim($this->input->post('class')):'1';
        $classname=$grade.$class;
        $searchsql = "1 AND classname=$classname";
        //默认获取2015级所有班级
        $data['class_num']=$this->student_model->db_counts("fly_classroom","grade=2015");
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
                $thumb=small_name($item ['thumb']);
                $item ['thumb'] ="<img src='$thumb' width='40'>";
            }
            $item['gender']=$gender[$item['gender']];
        }
        $data['list'] =$this->classroom_model->append_list($list);

        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

    /**
     * 添加
     *
     */
    public function add()
    {
        $data ['value'] ['birthday'] = '2011-01-01';
        $data ['value'] ['pubdate'] = date('Y',time()).'-09-01';
        $this->load->view ( 'admin/' . $this->add_view, $data );
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

        $this->load->view('admin/' . $this->edit_view, $data);
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
        $data['manage_teacher']=$this->teacher_base_model->get_manage_teacher_by_classid($value['classid']);
        $data['teach_teacher']=$this->teacher_base_model->get_teach_teacher_by_classid($value['classid']);//$data['manage_teacher']
        $data['parents']=$this->parents_model->get_parents_by_studentid($id);
        $data['id'] = $id;
        $this->load->view('admin/student_detail', $data);
    }
    public function reason()
    {
        $sql = "1 AND schoolid=$this->schoolid";
        $sqls = "1 AND schoolid=$this->schoolid";
        $begintime=date('Y-m-d',strtotime('-3 month',time()));
        $endtime=date('Y-m-d',time());
        if($this->input->post('begintime') AND $this->input->post('endtime'))
        {
            $begintime=$this->input->post('begintime');
            $endtime=$this->input->post('endtime');
            $sql.=" AND leaving_date between '$begintime' AND '$endtime'";
        }
        $data['begintime']=$begintime;
        $data['endtime']=$endtime;
        //离园原因
        $re_leaving=$this->student_model->statistic_leaving($sql);
        $leaving=$this->config->item('leaving');

        foreach ($re_leaving as $key=>$item) {
            $temp_leaving[$key]['name']=$leaving[$item['leaving']];
            $temp_leaving[$key]['value']=$item['num'];
        }
        $data['leaving']=$temp_leaving;
        //择园原因
        $re_reason=$this->student_model->statistic_reason($sqls);
        $reason=$this->config->item('reason');

        foreach ($re_reason as $key=>$item) {
            $temp_reason[$key]['name']=$reason[$item['reason']];
            $temp_reason[$key]['value']=$item['num'];
        }
        $data['reason']=$temp_reason;
        $this->load->view ( 'admin/student_reason',$data);
    }
    public function leaving()
    {
        $id=$this->input->get('id');
        $data['id']=$id;
        $this->load->view ( 'admin/student_leaving',$data);
    }
    public function leaving_save()
    {

        if($this->input->post('id'))
        {
            $id=$this->input->post('id');
            $leaving=$this->input->post('leaving');
            $type=$this->input->post('type');

            if($type=='true')
            {
                $this->student_model->delete($id);
                echo 1;exit;
            }
            else
            {
                $data=array(
                    'status'=>2,
                    'leaving'=>$leaving,
                    'leaving_date'=>date('Y-m-d',time())
                );
                $this->student_model->update($id,$data);
                echo 1;exit;
            }
        }
    }
    //返园
    public function updatestatus()
    {
        $id = $this->input->get('id');
        $data=array(
            'status'=>1,
            'leaving'=>1,
            'leaving_date'=>'0000-00-00'
        );
        $this->student_model->update($id,$data);
        redirect('d=admin&c=student&status=1&m=index&status=2');
    }
    public function import()
    {
        $this->load->view ( 'admin/student_import');
    }
    /**
     *导入学生
     */
    public function excelIn()
    {
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
                    if ($key == 1) continue; // 第一行是 标题 不用导入

                    if(isset($row[1]))
                    {
                        $stu ['classname'] = $row [1];
                    }
                    if(isset($row[2]))
                    {
                        $stu ['number'] = $row [2];
                    }
                    if(isset($row[3]))
                    {
                        $stu ['name'] = $row [3];
                    }
                    if(isset($row[4]))
                    {
                        $stu ['gender'] = $gender[$row [4]];
                    }
                    if(isset($row[5]))
                    {
                        $stu ['place'] = $row [5];
                    }
                    if(isset($row[6]))
                    {
                        $stu ['idcard'] = $row [6];
                    }
                    if(isset($row[7]))
                    {
                        $stu ['bloodtype'] = $row [7];
                    }
                    if(isset($row[8]))
                    {
                        $stu ['birthday'] =$row [8];
                    }
                    if(isset($row[9]))
                    {
                        $stu ['nation'] = $row [9];
                    }
                    if(isset($row[10]))
                    {
                        $stu ['bir_address'] = $row [10];
                    }
                    if(isset($row[11]))
                    {
                        $stu ['account'] = $row [11];
                    }
                    if(isset($row[12]))
                    {
                        $stu ['heath_status'] = $row [12];
                    }
                    if(isset($row[13]))
                    {
                        $stu ['political_status'] = $row [13];
                    }
                    if(isset($row[14]))
                    {
                        $stu ['account_address'] = $row [14];
                    }
                    if(isset($row[15]))
                    {
                        $stu ['address'] = $row [15];
                    }
                    if(isset($row[16]))
                    {
                        $stu ['father'] = $row [16];
                    }
                    if(isset($row[17]))
                    {
                        $stu ['f_workplace'] = $row [17];
                    }
                    if(isset($row[18]))
                    {
                        $stu ['f_tel'] = $row [18];
                    }
                    if(isset($row[19]))
                    {
                        $stu ['mother'] = $row [19];
                    }
                    if(isset($row[20]))
                    {
                        $stu ['m_workplace'] = $row [20];
                    }
                    if(isset($row[21]))
                    {
                        $stu ['m_tel'] = $row [21];
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
        $grade=$this->config->item('grade');
        $grade[0]='未选择';
        ksort($grade);
        $data['grade']=$grade;
        $this->load->view('admin/student_export',$data);
    }
    function export_save()
    {
        $type=$this->input->get('type');
        $where="schoolid=$this->schoolid";
        $grade=$this->input->get('grade')?$this->input->get('grade'):0;
        $classid=$this->input->get('classid')?$this->input->get('classid'):0;
        if($classid!=0)
        {
            $where.=" AND classid =$classid";
        }
        elseif($grade!=0)
        {
            $cla=$this->classroom_model->get_list('id',"grade=$grade");
            if($cla)
            {
                $result=array();
                foreach($cla as $value) {
                    $result[] = $value['id'];
                }
                $classids=implode(',',$result);
            }
            $where.=" AND classid in($classids)";
        }
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
            $list = $this->student_model->get_list('*',$where,0,1000);
            $data['list']=$this->classroom_model->append_list($list);

            $this->load->view('admin/'.$url,$data);
        }

    }
    // 弹出框
    function dialog() {
        $classid = getNumber( $_GET ['classid'] );
        $data ['list'] = $this->student_model->get_student_by_classid($classid);
        $this->load->view ( 'admin/student_dialog', $data );
    }
}