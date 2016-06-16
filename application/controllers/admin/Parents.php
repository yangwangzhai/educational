<?php

include 'content.php';

/**
 * 家长控制器
 * @author qcl 2016/01/07
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
        $this->baseurl = 'index.php?d=admin&c=parents'; // 本控制器的前段URL
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
        $searchsql = " schoolid=$this->schoolid";
        $relatives = $this->input->post('relatives')?$this->input->post('relatives'):'';
        $fit = $this->input->post('fit')?$this->input->post('fit'):'';
        $experience = $this->input->post('experience')?$this->input->post('experience'):'';
        $degrees = $this->input->post('degrees')?$this->input->post('degrees'):'';
        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($relatives) {
            $this->baseurl .= "&relatives=" . rawurlencode ( $relatives );
            $searchsql .= " AND relatives='$relatives' ";
        }
        $data['relatives_s']=$relatives;
        if ($fit) {
            $this->baseurl .= "&fit=" . rawurlencode ( $fit );
            $searchsql .= " AND fit='$fit' ";
        }
        $data['fit_s']=$fit;
        if ($experience) {
            $this->baseurl .= "&experience=" . rawurlencode ( $experience );
            $searchsql .= " AND experience='$experience' ";
        }
        $data['experience_s']=$experience;
        if ($degrees) {
            $this->baseurl .= "&degrees=" . rawurlencode ( $degrees );
            $searchsql .= " AND degrees='$degrees' ";
        }
        $data['degrees_s']=$degrees;
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


        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->parents_model->get_list('*',$searchsql,$offset,20);
        $relatives=$this->config->item('relatives');
        $transport=$this->config->item('transport');
        $environment=$this->config->item('environment');
        $fit=$this->config->item('fit');
        $experience=$this->config->item('experience');
        $degrees=$this->config->item('degrees');
        foreach($list as &$item) {
            $str = utf_substr($item['content'],30);
            if(strlen($item['content'])>30)
                $str .= '...';
            $item['content'] = $str;
            $item['transport']=$transport[$item['transport']];
            $item['environment']=$environment[$item['environment']];
            $item['fit']=$fit[$item['fit']];
            $item['experience']=$experience[$item['experience']];
            $item['degrees']=$degrees[$item['degrees']];
        }
        $data['list'] = $this->student_model->append_list($list);
        $data['list'] = $this->classroom_model->append_list($data['list']);

        array_unshift($relatives,'不限');
        $data['relatives']=$relatives;

        array_unshift($fit,'不限');
        $data['fit']=$fit;

        array_unshift($experience,'不限');
        $data['experience']=$experience;

        array_unshift($degrees,'不限');
        $data['degrees']=$degrees;
        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);  /**/
    }
   public function main()
   {
       $where="schoolid=$this->schoolid";
       $data['selected']=array('all1','all2','all3');


       $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;
       $vo = $this->volunteer_info_model->get_volunteer_info($where,$offset,20);
       if($this->input->get('data'))
       {
           $ar=explode(',',$this->input->get('data'));
           $data['selected']=$ar;
           foreach ($ar as $k=>$v)
           {
               switch ($v)
               {
                   case 'all1':
                       unset($ar[$k]);
                       break;
                   case 'all2':
                       unset($ar[$k]);
                       break;
                   case 'all3':
                       unset($ar[$k]);
                       break;
               }

           }
           /*sort($value);*/

           if(!empty($ar))
           {
               foreach($vo as $k=>$item) {

                   $arrs=$this->volunteer_info_model->get_field($this->schoolid,$item['parentid']);
                   $list[$k]=$this->parents_model->get_one($item['parentid']);

                   foreach($ar as $val)
                   {
                       if(in_array($val,$arrs)==false)
                       {
                           unset($list[$k]);
                           break;
                       }
                   }
               }
               sort($list);
           }
           else
           {
               foreach($vo as $item) {
                   $list[]=$this->parents_model->get_one($item['parentid']);
               }
           }

       }
       else
       {
           foreach($vo as $item) {
               $list[]=$this->parents_model->get_one($item['parentid']);
           }
       }
       $data['count'] =count($list);


       $this->config->load('pagination', TRUE);
       $pagination = $this->config->item('pagination');
       $pagination['base_url'] = $this->baseurl;
       $pagination['total_rows'] = $data['count'];
       $this->load->library('pagination');
       $this->pagination->initialize($pagination);
       $data['pages'] = $this->pagination->create_links();
       $data['list'] = $this->student_model->append_list($list);
       $data['list'] = $this->volunteer_info_model->append_list($data['list']);
       $data['list'] = $this->classroom_model->append_list($data['list']);

       $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
       $data['volunteer']=$this->volunteer_model->get_volunteer_by_type($this->schoolid);
       $this->load->view('admin/parents_main',$data);
   }
    /**
     *图表分析
     */
    function statistic()
    {
        $grade=$this->config->item('grade');
        $grade[0]='未选择';
        ksort($grade);
        $data['grade']=$grade;
        $this->load->view('admin/parents_statistic',$data);
    }
    function ajax_statistic()
    {
        $types=$this->input->post('types');
        $grade=$this->input->post('grade');
        $classid=$this->input->post('classid');
        $where="schoolid=$this->schoolid";
        if($classid!='all')
        {
            $where.=" AND classid=$classid";
        }
        elseif($grade!='all')
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
        switch ($types) {
            case 'relatives':

                $re = $this->parents_model->statistic_relatives($where);
                $relatives = $this->config->item('relatives');
                foreach ($re as $key=>$item) {
                    $list[$key]['name']=$relatives[$item['relatives']];
                    $list[$key]['value']=$item['num'];
                }
                break;
            case 'fit':

                $re = $this->parents_model->statistic_fit($where);
                $fit = $this->config->item('fit');
                foreach ($re as $key=>$item) {
                    $list[$key]['name']=$fit[$item['fit']];
                    $list[$key]['value']=$item['num'];
                }
                break;
            case 'environment':

                $re = $this->parents_model->statistic_environment($where);
                $environment = $this->config->item('environment');
                foreach ($re as $key=>$item) {
                    $list[$key]['name']=$environment[$item['environment']];
                    $list[$key]['value']=$item['num'];
                }
                break;
            case 'experience':

                $re = $this->parents_model->statistic_experience($where);
                $experience = $this->config->item('experience');
                foreach ($re as $key=>$item) {
                    $list[$key]['name']=$experience[$item['experience']];
                    $list[$key]['value']=$item['num'];
                }
                break;
            case 'degrees':

                $re = $this->parents_model->statistic_degrees($where);
                $degrees = $this->config->item('degrees');
                foreach ($re as $key=>$item) {
                    $list[$key]['name']=$degrees[$item['degrees']];
                    $list[$key]['value']=$item['num'];
                }
                break;
            case 'transport':

                $re = $this->parents_model->statistic_transport($where);
                $transport = $this->config->item('transport');
                foreach ($re as $key=>$item) {
                    $list[$key]['name']=$transport[$item['transport']];
                    $list[$key]['value']=$item['num'];
                }
                break;

        }
        echo json_encode($list);exit;
    }
    /**
     * 添加
     *
     */
    public function add() {
        $data['value']['birthday'] = '1986-01-01';

        $data['list']=$this->volunteer_model->get_volunteer_by_type($this->schoolid);
        $this->load->view('admin/' . $this->add_view, $data);
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
        $data['value'] = $this->classroom_model->append_item($data['value']);

        $data['id'] = $id;

        $this->load->view('admin/' . $this->edit_view, $data);
    }
    // 删除
    public function delete ()
    {
        $ids = $this->input->get('id')?$this->input->get('id'):$this->input->post('delete[]');
        if ($ids)
        {
            $this->parents_model->delete($ids);
            if(is_array($ids))
            {
                foreach($ids as $id)
                {
                    $this->volunteer_info_model->delete_by_parentid($id);
                }
            }
            else
            {
                $this->volunteer_info_model->delete_by_parentid($ids);
            }
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
            $this->volunteer_info_model->delete_by_parentid($id);
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
                        'parentid'=>$id
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
                        'parentid'=>$insert_id
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

        $this->load->view('admin/parents_dialog', $data);
    }
    public function import()
    {
        $this->load->view ( 'admin/parents_import');
    }
    /**
     *导入家长
     */
    public function excelIn()
    {
        if($this->input->post('filename'))
        {
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
                    if (empty($result)) {
                        continue;
                    }
                    $parents ['studentid'] = $result['id'];
                    $parents ['classid'] = $result['classid'];
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
    function export_dialog()
    {
        $grade=$this->config->item('grade');
        array_unshift($grade,'未选择');
        $data['grade']=$grade;
        $this->load->view('admin/parents_export_dialog',$data);
    }
    function export()
    {
        $where="schoolid=$this->schoolid";
        $grade=$this->input->get('grade');
        $classid=$this->input->get('classid');
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

        $list = $this->parents_model->get_list('*',"$where",0,1000);
        $list = $this->student_model->append_list($list);
        $data['list']=$this->classroom_model->append_list($list);
        $this->load->view('admin/parents_export',$data);
    }
}