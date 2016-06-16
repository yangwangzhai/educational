<?php

if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

// 每日刷卡统计

include 'content.php';
require_once APPPATH.'libraries/PHPExcel.php';
require_once APPPATH.'libraries/Spreadsheet_Excel_Reader.php';
class task extends Content
{
    function __construct()
    {
        $this->name = '排课任务列表';
        $this->control = 'task';
        $this->baseurl = 'index.php?d=timetable&c=task';
        $this->table = 'fly_task';
        $this->list_view = 'task'; // 列表页
        $this->add_view = 'task_add'; // 添加页
        parent::__construct();
        $this->load->model('timetable/task_model');
        $this->load->model('timetable/course_plan_model');
        $this->load->model('timetable/teacher_model');
    }

    // 首页
    public function index()
    {
        $schoolid=$this->schoolid;
        $school_type=$this->school_type;
        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $total_rows=$this->task_model->rows_query();
        $pagination['total_rows'] =$total_rows;
        $pagination['base_url'] = $this->baseurl;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('per_page') ? intval($this->input->get('per_page')) : 0;
        $data['list'] = $this->task_model->get_list('*',"schoolid=$schoolid AND school_type=$school_type",$offset,10);

        $this->load->view('timetable/task',$data);
    }

    public function add(){
        $this->load->view('timetable/task_add');
    }

    public function edit(){
        $id=$this->input->get('id');
        $data['list']=$this->task_model->get_column2("id,task_name,task_term,days_oneweek,section_oneday",$this->table,"id=$id");
        $data['list']['copy']="";
        $this->load->view('timetable/task_add',$data);
    }

    public function copy(){
        $id=$this->input->get('id');
        $data['list']=$this->task_model->get_column2("id,task_name,task_term,days_oneweek,section_oneday",$this->table,"id=$id");
        $data['list']['task_name']=$data['list']['task_name']."-副本";
        //标记
        $data['list']['copy']="copy";
        $this->load->view('timetable/task_add',$data);
    }

    public function save(){
        $id=$this->input->post('id');
        $copy=$this->input->post('copy');
        $value['task_name']=$this->input->post('task_name');
        $value['task_term']=$this->input->post('task_term');
        $value['days_oneweek']=$this->input->post('days_oneweek');
        $value['section_oneday']=$this->input->post('section_oneday');
        $value['schoolid']=$this->schoolid;
        $value['school_type']=$this->school_type;
        if(empty($id)&&empty($copy)){
            //插入
            $this->task_model->db_insert_table($this->table,$value);
        }else if(!empty($id)&&empty($copy)){
            //更新
            $this->task_model->db_update_table($this->table,$value,$id);
        }else if(!empty($id)&&!empty($copy)){
            //复用
            //排课任务副本插入fly_task表
            $copy_task_id=$this->task_model->db_insert_table($this->table,$value);
            //复制信息，并插入fly_course_plan表
            $where="schoolid=$value[schoolid] AND school_type=$value[school_type] AND term=$id";
            $this->task_model->copy_table("*","fly_course_plan",$where,$copy_task_id);
            $this->task_model->copy_table("*","fly_label",$where,$copy_task_id);
            $this->task_model->copy_table("*","fly_rule",$where,$copy_task_id);
            $this->task_model->copy_table("*","fly_teacher",$where,$copy_task_id);
            $this->task_model->copy_table("*","fly_timetable",$where,$copy_task_id);
            $this->task_model->copy_table("*","fly_warning",$where,$copy_task_id);

        }
    }

    public function delete(){
        $id=$this->input->get('id');
        if($id){
            //删除其他表的信息
            $delete['schoolid']=$this->schoolid;
            $delete['school_type']=$this->school_type;
            $delete['term']=$id;

            $this->course_plan_model->db_delete2("fly_course_plan",$delete);
            $this->course_plan_model->db_delete2("fly_label",$delete);
            $this->course_plan_model->db_delete2("fly_rule",$delete);
            $this->course_plan_model->db_delete2("fly_teacher",$delete);
            $this->course_plan_model->db_delete2("fly_timetable",$delete);
            $this->course_plan_model->db_delete2("fly_warning",$delete);
            $this->task_model->db_delete_table($this->table,$id);
        }else{
            $ids = $_POST['delete'];
            foreach($ids as $key=>$value){
                $this->task_model->db_delete_table($this->table,$value);
                $delete['schoolid']=$this->schoolid;
                $delete['school_type']=$this->school_type;
                $delete['term']=$value;
                $this->course_plan_model->db_delete2("fly_course_plan",$delete);
                $this->course_plan_model->db_delete2("fly_label",$delete);
                $this->course_plan_model->db_delete2("fly_rule",$delete);
                $this->course_plan_model->db_delete2("fly_teacher",$delete);
                $this->course_plan_model->db_delete2("fly_timetable",$delete);
                $this->course_plan_model->db_delete2("fly_warning",$delete);
            }
        }
        $this->index();

    }

    public function base_message(){
        $id=$this->input->get('id');
        if(!empty($id)){
            $this->session->set_userdata ( 'term', $id);
        }else{
            $id=$this->session->userdata ( 'term');
        }
        //排课任务名字放入session
        $task_name=$this->task_model->get_column2("task_name","fly_task","id=$id");
        $this->session->set_userdata ( 'task_name', $task_name['task_name']);

        $schoolid=$this->schoolid;
        $school_type=$this->school_type;
        $where="schoolid=$schoolid AND school_type=$school_type AND term=$id";
        $data=$this->course_plan_model->get_column("grade,classname,course,course_num,continue_times,teacher","fly_course_plan",$where);
        $i=1;
        $arr[0]=array();

        foreach($data as $key=>$value){
                if($data[$key]['grade']==$data[$key+1]['grade']&&$data[$key]['classname']==$data[$key+1]['classname']){
                    $arr[$i]['grade']=$value['grade'];
                    $arr[$i]['classname']=$value['classname'];
                    if(empty($value['continue_times'])){
                        $arr[$i][]=$value['course_num'];
                    }else{
                        $arr[$i][]=($value['course_num']-2*$value['continue_times'])."+".$value['continue_times'];
                    }
                    if(!in_array($value['course'],$arr[0])){
                        $arr[0]['grade']="年级";
                        $arr[0]['classname']="班级";
                        $arr[0][]=$value['course'];
                    }
                }else{
                    $arr[$i]['grade']=$value['grade'];
                    $arr[$i]['classname']=$value['classname'];
                    if(empty($value['continue_times'])){
                        $arr[$i][]=$value['course_num'];
                    }else{
                        $arr[$i][]=($value['course_num']-2*$value['continue_times'])."+".$value['continue_times'];
                    }
                    if(!in_array($value['course'],$arr[0])){
                        $arr[0]['grade']="年级";
                        $arr[0]['classname']="班级";
                        $arr[0][]=$value['course'];
                    }
                    $i++;
                }
        }
        $message['list']=$arr;
        $message['flag']="base";
        //从fly_task表获取每天上课节数，每星期上课几天。
        $mes=$this->task_model->get_column2("days_oneweek,section_oneday","fly_task","id=$id");
        foreach(config_item('section') as $key=>$value){
            if($mes['section_oneday']==count($value)){
                $this->session->set_userdata ( 'section', $value);
            }
        }
        foreach(config_item('section2') as $key=>$value){
            if($mes['section_oneday']==count($value)){
                $this->session->set_userdata ( 'section2', $value);
            }
        }

        foreach(config_item('week') as $key=>$value){
            if($mes['days_oneweek']==count($value)){
                $this->session->set_userdata('week',$value);
            }
        }
        foreach(config_item('week2') as $key=>$value){
            if($mes['days_oneweek']==count($value)){
                $this->session->set_userdata('week2',$value);
            }
        }

        $this->load->view('timetable/base_message',$message);
    }

    public function excel_import_list()
    {
        $this->load->view('timetable/excel_import_list');
    }

    public function excel_import_save()
    {
        $schoolid=$this->schoolid;
        $school_type=$this->school_type;
        $term=$this->session->userdata('term');
        $thumb=$this->input->post('thumb');
        //创建 Reader
        $data = new Spreadsheet_Excel_Reader();
        //设置文本输出编码
        $data->setOutputEncoding('utf-8');
        //读取Excel文件
        $data->read($thumb);
        $data=$data->sheets [0] ['cells'];
        $title=$data[1];

        foreach($data as $key=>$value){
            foreach($value as $k=>$val){
                if($key>1){
                    if($k>3 && $k%2==0){
                        $teacher_message[$key][$k]=$val;
                    }else{
                        $course_message[$key][$k]=$val;
                    }
                }
            }
        }

        foreach($course_message as $key=>$value){
            foreach($value as $k=>$val){
                if($k>2){
                    $arr=explode("+",$val);
                    $course[$key][$k]['course_num']=$arr[0]+2*$arr[1];
                    if(!empty($arr[1])){
                        $course[$key][$k]['continue_times']=$arr[1];
                    }else{
                        $course[$key][$k]['continue_times']=0;
                    }
                }
            }
        }
        static $grade;
        static $classname;
        static $i;
        $i=0;
        foreach($course_message as $key=>$value){
            foreach($value as $k=>$val){
                if($k==1){
                    $grade=$val;
                }else if($k==2){
                    $classname=$val;
                }else{
                    $insert_message[$i]['schoolid']=$schoolid;
                    $insert_message[$i]['school_type']=$school_type;
                    $insert_message[$i]['term']=$term;
                    $insert_message[$i]['grade']=$grade;
                    $insert_message[$i]['classname']=$classname;
                    $insert_message[$i]['course']=$title[$k];
                    $insert_message[$i]['course_num']=$course[$key][$k]['course_num'];
                    $insert_message[$i]['continue_times']=$course[$key][$k]['continue_times'];
                    $insert_message[$i]['teacher']=$teacher_message[$key][$k+1];
                    $i++;
                }
            }
        }
        //是否已经导入过了，若已导入则先删除，再重新保存
        $delete['schoolid']=$schoolid;
        $delete['school_type']=$school_type;
        $delete['term']=$term;
        $this->course_plan_model->db_delete2("fly_course_plan",$delete);
        //插入fly_course_plan表
        foreach($insert_message as $key=>$value){
            $this->course_plan_model->db_insert_table("fly_course_plan",$value);
        }

        //插入fly_teacher表
        $teacher_list="schoolid=$schoolid AND school_type=$school_type AND term=$term AND teacher IS not NULL";
        static $teacher;
        static $temp;
        $teacher=$temp=$this->course_plan_model->get_column("course,teacher","fly_course_plan",$teacher_list);
        $j=0;
        foreach($teacher as $key=>$value){
            foreach($temp as $k=>$val){
                if(in_array($value['teacher'],$val)){
                    $teacher_arr[$j]['teacher']=$val['teacher'];
                    if(!in_array($val['course'],$teacher_arr[$j])){
                        $teacher_arr[$j][]=$val['course'];
                        $result[$j]['teacher']=$val['teacher'];
                        $result[$j]['teach_course']=ltrim($result[$j]['teach_course'].",".$val['course'],",");
                        $result[$j]['schoolid']=$schoolid;
                        $result[$j]['school_type']=$school_type;
                        $result[$j]['term']=$term;
                    }
                    unset($temp[$k]);
                }
            }
            $j++;
        }
        foreach($result as $key=>$value){
            $item_where="schoolid=$schoolid AND school_type=$school_type AND term=$term AND teacher='$value[teacher]'";
            $item[$key]=$this->course_plan_model->get_column("grade,classname,course,course_num,teacher","fly_course_plan",$item_where);
        }

        foreach($item as $key=>$value){
            foreach($value as $k=>$val){
                $temp_item[$key][]=$val['grade'].$val['classname'];
            }
        }

        foreach($temp_item as $key=>$value){
            $result[$key]['teach_class_num']=count(array_unique($temp_item[$key]));
        }
        foreach($result as $key=>$value){
            $teach_total_where="schoolid=$schoolid AND school_type=$school_type AND term=$term AND teacher='$value[teacher]'";
            $teach_total=$this->course_plan_model->get_column("course_num","fly_course_plan",$teach_total_where);
            $total=0;
            foreach($teach_total as $teach_total_key=>$teach_total_value){
                $total=$total+$teach_total_value['course_num'];
            }
            $result[$key]['teach_total']=$total;
        }

        //是否已经导入过了，若已导入则先删除，再重新保存
        $delete['schoolid']=$schoolid;
        $delete['school_type']=$school_type;
        $delete['term']=$term;
        $this->course_plan_model->db_delete2("fly_teacher",$delete);
        foreach($result as $key=>$value){
            $check_result=$this->teacher_model->db_insert_table("fly_teacher",$value);
        }
        if($check_result!=0){
            echo 1;
            exit ;
        }else{
            echo 0;
            exit;
        }

    }

    public function teacher_message(){
        $term=$this->session->userdata ( 'term');
        $schoolid=$this->schoolid;
        $school_type=$this->school_type;
        $where="schoolid=$schoolid AND school_type=$school_type AND term=$term";
        $data=$this->course_plan_model->get_column("grade,classname,course,teacher","fly_course_plan",$where);
        $i=1;
        $arr[0]=array();
        foreach($data as $key=>$value){
            if($data[$key]['grade']==$data[$key+1]['grade']&&$data[$key]['classname']==$data[$key+1]['classname']){
                $arr[$i]['grade']=$value['grade'];
                $arr[$i]['classname']=$value['classname'];
                $arr[$i][]=$value['teacher'];
                if(!in_array($value['course'],$arr[0])){
                    $arr[0]['grade']="年级";
                    $arr[0]['classname']="班级";
                    $arr[0][]=$value['course'];
                }

            }else{
                $i++;
            }
        }
        $message['list']=$arr;
        $message['flag']="teacher";
        $this->load->view('timetable/base_message',$message);
    }

    public function excel_out_list(){
        $term=$this->session->userdata ( 'term');
        $schoolid=$this->schoolid;
        $school_type=$this->school_type;
        $where="schoolid=$schoolid AND school_type=$school_type AND term=$term";
        //判断是否已经导入基础信息，如果没有导入，给出提示并返回到基础信息导入页面
        $num=$this->course_plan_model->counts("fly_course_plan",$where);
        if($num==0){
            show_msg ( '请先导入基础信息！', "index.php?d=timetable&c=task&m=base_message" );
        }else{
            $data=$this->course_plan_model->get_column("grade,classname,course,course_num,continue_times,teacher","fly_course_plan",$where);
            $i=1;
            $arr[0]=array();
            foreach($data as $key=>$value){
                if($data[$key]['grade']==$data[$key+1]['grade']&&$data[$key]['classname']==$data[$key+1]['classname']){
                    $arr[$i]['grade']=$value['grade'];
                    $arr[$i]['classname']=$value['classname'];
                    if(empty($value['continue_times'])){
                        $arr[$i][]=$value['course_num'];
                    }else{
                        $arr[$i][]=($value['course_num']-2*$value['continue_times'])."+".$value['continue_times'];
                    }
                    if(!in_array($value['course'],$arr[0])){
                        $arr[0]['grade']="年级";
                        $arr[0]['classname']="班级";
                        $arr[0][]=$value['course'];
                    }
                }else{
                    $i++;
                }
            }
            $message['list']=$arr;
            $this->load->view('timetable/out_base_message',$message);
        }
    }

    public function excel_out_teacher(){
        $term=$this->session->userdata ( 'term');
        $schoolid=$this->schoolid;
        $school_type=$this->school_type;
        $where="schoolid=$schoolid AND school_type=$school_type AND term=$term";
        //判断是否已经导入基础信息，如果没有导入，给出提示并返回到基础信息导入页面
        $num=$this->course_plan_model->counts("fly_course_plan",$where);
        if($num==0){
            show_msg ( '请先导入基础信息！', "index.php?d=timetable&c=task&m=base_message" );
        }else{
            $data=$this->course_plan_model->get_column("grade,classname,course,teacher","fly_course_plan",$where);
            $i=1;
            $arr[0]=array();
            foreach($data as $key=>$value){
                if($data[$key]['grade']==$data[$key+1]['grade']&&$data[$key]['classname']==$data[$key+1]['classname']){
                    $arr[$i]['grade']=$value['grade'];
                    $arr[$i]['classname']=$value['classname'];
                    $arr[$i][]=$value['teacher'];
                    if(!in_array($value['course'],$arr[0])){
                        $arr[0]['grade']="年级";
                        $arr[0]['classname']="班级";
                        $arr[0][]=$value['course'];
                    }

                }else{
                    $i++;
                }
            }
            $message['list']=$arr;
            $this->load->view('timetable/out_teacher',$message);
        }

    }


















}
