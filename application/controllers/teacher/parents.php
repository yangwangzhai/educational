<?php

include 'content.php';

/**
 * 监护人控制器
 * @author ryo 2015/05/04
 *
 */
class Parents extends Content {
    /**
     * 构造器
     */
    function __construct ()
    {
        $class_name = 'parents';
        $this->name = "家长";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=parents'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('parents_model');
        $this->load->model('student_model');
        $this->load->model('classroom_model');
        $this->load->model('volunteer_model');
        $this->load->model('volunteer_info_model');
    }

    /**
     *首页
     */
    function index() {
        if( get_cookie ('classname')==null)
        {
            show_msg('没有找到你的班级 请先设置班级！', 'index.php?d=teacher&c=class_list&m=index');
        }
        else
        {
            $classname = get_cookie('classname');
            $class = $this->classroom_model->get_class_by_classname($classname);
            $ids = implode(',', $this->student_model->get_ids_by_classid($class['id']));
            $searchsql = "1 AND studentid in ($ids)";
            $relatives = $this->input->post('relatives') ? $this->input->post('relatives') : '';
            $fit = $this->input->post('fit') ? $this->input->post('fit') : '';
            $experience = $this->input->post('experience') ? $this->input->post('experience') : '';
            $degrees = $this->input->post('degrees') ? $this->input->post('degrees') : '';
            $keywords = $this->input->post('keywords') ? trim($this->input->post('keywords')) : '';
            if ($relatives) {
                $this->baseurl .= "&relatives=" . rawurlencode($relatives);
                $searchsql .= " AND relatives='$relatives' ";
            }
            $data['relatives_s'] = $relatives;
            if ($fit) {
                $this->baseurl .= "&fit=" . rawurlencode($fit);
                $searchsql .= " AND fit='$fit' ";
            }
            $data['fit_s'] = $fit;
            if ($experience) {
                $this->baseurl .= "&experience=" . rawurlencode($experience);
                $searchsql .= " AND experience='$experience' ";
            }
            $data['experience_s'] = $experience;
            if ($degrees) {
                $this->baseurl .= "&degrees=" . rawurlencode($degrees);
                $searchsql .= " AND degrees='$degrees' ";
            }
            $data['degrees_s'] = $degrees;
            if ($keywords) {
                $this->baseurl .= "&keywords=" . rawurlencode($keywords);
                $searchsql .= " AND username like '%{$keywords}%' ";
            }

            $data['list'] = array();
            $count = $this->parents_model->counts($searchsql);
            $data['count'] = $count;


            $this->config->load('pagination', TRUE);
            $pagination = $this->config->item('pagination');
            $pagination['base_url'] = $this->baseurl;
            $pagination['total_rows'] = $count;
            $this->load->library('pagination');
            $this->pagination->initialize($pagination);
            $data['pages'] = $this->pagination->create_links();


            $offset = $this->input->get('per_page') ? intval($this->input->get('per_page')) : 0;

            $list = $this->parents_model->get_list('*', $searchsql, $offset, 20);
            $relatives = $this->config->item('relatives');
            $transport = $this->config->item('transport');
            $environment = $this->config->item('environment');
            $fit = $this->config->item('fit');
            $experience = $this->config->item('experience');
            $degrees = $this->config->item('degrees');
            foreach ($list as &$item) {
                $str = utf_substr($item['content'], 30);
                if (strlen($item['content']) > 30)
                    $str .= '...';
                $item['content'] = $str;
                $item['transport'] = $transport[$item['transport']];
                $item['environment'] = $environment[$item['environment']];
                $item['fit'] = $fit[$item['fit']];
                $item['experience'] = $experience[$item['experience']];
                $item['degrees'] = $degrees[$item['degrees']];
            }
            $data['list'] = $this->student_model->append_list($list);
            $data['list'] = $this->classroom_model->append_list($data['list']);

            $relatives[0] = '不限';
            ksort($relatives);
            $data['relatives'] = $relatives;

            $fit[0] = '不限';
            ksort($fit);
            $data['fit'] = $fit;

            $experience[0] = '不限';
            ksort($experience);
            $data['experience'] = $experience;

            $degrees[0] = '不限';
            ksort($degrees);
            $data['degrees'] = $degrees;
            $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
            $this->load->view('teacher/' . $this->list_view, $data);  /**/
        }
    }
    /**
     * 添加
     *
     */
    public function add() {
        $data['value']['birthday'] = '1986-01-01';
        $classname = get_cookie('classname');
        $class=$this->classroom_model->get_class_by_classname($classname);
        $data ['value']['classname']=setClassname($classname);
        $data ['value']['classid']=$class['id'];
        $data['list']=$this->volunteer_model->get_volunteer_by_type($this->schoolid);
        $this->load->view('teacher/' . $this->add_view, $data);
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $data['list']=$this->volunteer_model->get_volunteer_by_type($this->schoolid);
        $value = $this->parents_model->get_one($id);
        $volunteer=$this->volunteer_info_model->get_field($this->schoolid,$id);
        if(empty($volunteer))
        {
            $volunteer=array();
        }
        $data['volunteer']= $volunteer;
        $data['value'] = $this->student_model->append_item($value);

        $data['id'] = $id;
        $classname = get_cookie('classname');
        $class=$this->classroom_model->get_class_by_classname($classname);
        $data ['value']['classname']=setClassname($classname);
        $data ['value']['classid']=$class['id'];
        $this->load->view('teacher/' . $this->edit_view, $data);
    }
    // 删除
    public function delete ()
    {
        $ids = $this->input->get('id')?$this->input->get('id'):$this->input->post('delete[]');
        if ($ids)
        {
            $this->parents_model->delete($ids);
            show_msg('删除成功！', $_SESSION['url_forward']);
        }
    }
    /**
     *保存
     */
    public function save()
    {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $volunteer=trims ( $this->input->post('volunteer'));
        $data['schoolid'] = $this->schoolid;
        if ($data ['studentid'] == "") {
            show_msg ( '学生姓名不能为空' );
        }
        if ($data ['username'] == "") {
            show_msg ( '家长姓名不能为空' );
        }
        if ($data ['birthday'] == "") {
            unset ($data['birthday']);
        }
        // 检查手机号码
        if (empty($data ['tel'])) {
            show_msg ( '手机号码不能为空' );
        }
        if($this->parents_model->is_tel_exist($data['tel'], $id)){
            show_msg ( '手机号码已经存在，请更换' );
        }
        if ($data ['thumb']) {
            thumb ( $data ['thumb'] );
        }

        if ($id) { // 修改 ===========
            $data['status2'] = 1;
            $this->parents_model->update($id,$data);
            $this->volunteer_info_model->delete_by_teacherid($id);
            if(!empty($volunteer))
            {
                $addtime=time();
                $schoolid=$this->schoolid;
                foreach($volunteer as $val)
                {
                    $data=array(
                        'schoolid'=>$schoolid,
                        'addtime'=>$addtime,
                        'volunteer_id'=>$val,
                        'uid'=>$id
                    );
                    $this->volunteer_info_model->insert($data);
                }
            }
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );

        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $insert_id=$this->parents_model->insert($data);
            if(!empty($volunteer) AND $insert_id>=1)
            {
                $addtime=time();
                $schoolid=$this->schoolid;
                foreach($volunteer as $val)
                {
                    $data=array(
                        'schoolid'=>$schoolid,
                        'addtime'=>$addtime,
                        'volunteer_id'=>$val,
                        'uid'=>$insert_id
                    );
                    $this->volunteer_info_model->insert($data);
                }
            }
            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
    // 弹出框
    function dialog ()
    {
        $where="schoolid=$this->schoolid";


        $data['list'] = $this->parents_model->get_list('id,username',$where,0,50);

        $this->load->view('teacher/parents_dialog', $data);
    }
    public function import()
    {
        $this->load->view ( 'teacher/parents_import');
    }
    /**
     *导入家长
     */
    public function excelIn()
    {
        if($this->input->post('filename'))
        {
            $classname = get_cookie('classname');
            $class = $this->classroom_model->get_class_by_classname($classname);
            $ids = $this->student_model->get_ids_by_classid($class['id']);

            $filename=$this->input->post('filename');
            require_once APPPATH . 'libraries/Spreadsheet_Excel_Reader.php'; // 加载类
            $data = new Spreadsheet_Excel_Reader (); // 实例化
            $data->setOutputEncoding('utf-8'); // 设置编码

            $relatives = array_flip(config_item('relatives'));
            $transport = array_flip(config_item('transport'));
            $environment = array_flip(config_item('environment'));
            $fit = array_flip(config_item('fit'));
            $experience = array_flip(config_item('experience'));
            $degrees = array_flip(config_item('degrees'));
            // 读取电子表格
            foreach($filename as $itemFile) {
                $data->read($itemFile); // read函数读取所需EXCEL表，支持中文
                // print_r($data->sheets[0]['cells']);
                $parents = array();
                foreach ($data->sheets [0] ['cells'] as $key => $row) {
                    if ($key == 1) continue; // 第一行是 标题 不用导入
                    if(isset($row[1])==false || isset($row [3])==false)continue;//家长姓名，学生姓名不能为空
                    $parents ['username'] = $row [1];
                    if(isset($row[2]))
                    {
                        $parents ['relatives'] = $relatives[$row [2]];
                    }
                    $result = $this->student_model->get_student_by_name($row [3]);
                    if (empty($result) || in_array($result['id'],$ids)==false) {
                        continue;
                    }
                    $parents ['studentid'] = $result['id'];
                    if(isset($row[4]))
                    {
                        $parents ['transport'] = $transport[$row [4]];
                    }
                    if(isset($row[5]))
                    {
                        $parents ['place'] = $row [5];
                    }
                    if(isset($row[6]))
                    {
                        $parents ['environment'] = $environment[$row [6]];
                    }
                    if(isset($row[7]))
                    {
                        $parents ['degrees'] = $degrees[$row [7]];
                    }
                    if(isset($row[8]))
                    {
                        $parents ['fit'] = $fit[$row [8]];
                    }
                    if(isset($row[9]))
                    {
                        $parents ['experience'] = $experience[$row [9]];
                    }
                    if(isset($row[10]))
                    {
                        $parents ['activities'] = $row [10];
                    }
                    if(isset($row[11]))
                    {
                        $parents ['tel'] = $row [11];
                    }
                    if(isset($row[12]))
                    {
                        $parents ['content'] = $row [12];
                    }
                    $parents ['addtime'] = time();
                    $parents ['schoolid'] = $this->schoolid;
                    $this->parents_model->insert($parents);    // 插入学生数据库
                }
            }
            echo 1;exit;
        }
    }
}