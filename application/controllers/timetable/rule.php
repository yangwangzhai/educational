<?php

if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

// 规则设置

include 'content.php';

class rule extends Content
{

    function __construct()
    {
        $this->name = '班级列表';
        $this->control = 'rule';
        $this->baseurl = 'index.php?d=timetable&c=rule';
        $this->table = 'fly_rule';
        $this->list_view = 'rule'; // 列表页
        $this->add_view = 'class_add'; // 添加页
        parent::__construct();
        $this->load->model('timetable/rule_model');
        $this->load->model('timetable/label_model');
        $this->load->model('timetable/course_plan_model');
        $this->load->model('timetable/teacher_model');
        $this->load->model('timetable/timetable_model');
    }

    function rule_set()
    {
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type";
        //判断是否已经导入基础信息，如果没有导入，给出提示并返回到基础信息导入页面
        $num=$this->course_plan_model->counts("fly_course_plan",$where);
        if($num==0){
            show_msg ( '请先导入基础信息！', "index.php?d=admin&c=task&m=base_message" );
        }else{
            // 根据session中的schoolid，$term，$school_type从fly_course_plan表获取每个年级的所有班级
            $column="grade,classname";
            $table="fly_course_plan";
            $message =$this->course_plan_model->get_column($column,$table,$where);
            $i=0;
            $j=0;
            foreach($message as $key=>$value){
                if($message[$key]['grade']==$message[$key+1]['grade']){
                    $arr_grade[$i]['grade']=$message[$key]['grade'];
                    if($message[$key]['classname']==$message[$key+1]['classname']){
                        $arr_classname[$i][$j]=$message[$key]['classname'];
                    }else{
                        $j++;
                    }
                }else{
                    $i++;
                }
            }
            $data['grade']=$arr_grade;
            $data['classname']=$arr_classname;
            //从fly_label获取标签
            $data['label_list']=$this->label_model->get_column('*',"fly_label",$where);
            $data['sections']=$this->session->userdata('section');
            $data['weeks']=$this->session->userdata('week');

            $this->load->view('timetable/' .'rule_list',$data);
        }
    }

    function forbid_course(){
        /*$term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade="初二";
        $where_classname="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade'";
        $column="classname";
        $table="fly_course_plan";
        $res_classname=$this->course_plan_model->get_column($column,$table,$where_classname);
        $arr_classname=unique($res_classname);
        echo "<pre>";
        print_r($arr_classname);
        echo "<pre/>";
        exit;*/

        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type";
        $column="grade,classname";
        $table="fly_course_plan";
        $message =$this->course_plan_model->get_column($column,$table,$where);
        $i=0;
        $j=0;
        foreach($message as $key=>$value){
            if($message[$key]['grade']==$message[$key+1]['grade']){
                $arr_grade[$i]['grade']=$message[$key]['grade'];
                if($message[$key]['classname']==$message[$key+1]['classname']){
                    $arr_classname[$i][$j]=$message[$key]['classname'];
                }else{
                    $j++;
                }
            }else{
                $i++;
            }
        }
        $data['grade']=$arr_grade;
        $data['classname']=$arr_classname;

        //获取各个年级的课程
        foreach($arr_grade as $key=>$value){
            $res[$key]=array();
            $where_course="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$value[grade]' AND course_num!=0";
            $mes=$this->course_plan_model->get_column("course","fly_course_plan",$where_course);
            foreach($mes as $k=>$val){
                if(!in_array($val['course'],$res[$key])){
                    $res[$key][]=$val['course'];
                }
            }
        }
        $data['classes']=$res;
        $data['forbid_name']='课程不排课时间';
        $data['sections']=$this->session->userdata('section');
        $data['weeks']=$this->session->userdata('week');

        $this->load->view('timetable/' .'rule_forbid_course',$data);
    }

    function forbid_teacher()
    {
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $teacher=$this->input->post('teacher');
        $searchsql = "schoolid='$this->schoolid' AND term=$term AND school_type=$school_type";

        $data ['list'] = array ();
        $query = $this->db->query ( "SELECT COUNT(*) AS num FROM fly_teacher WHERE $searchsql" );
        $count = $query->row_array ();
        $data ['count'] = $count ['num'];

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl."&m=forbid_teacher";
        $pagination ['total_rows'] = $count ['num'];
        $pagination['per_page'] = 10;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();
        if(empty($teacher)){
            $offset = $_GET ['pn'] ? intval ( $_GET ['pn'] ) : 0;
        }else{
            $teacher_all=$this->rule_model->get_column('teacher','fly_teacher',$searchsql);
            foreach($teacher_all as $teacher_key=>$teacher_value){
                if($teacher_value['teacher']==$teacher){
                    $num=$teacher_key;
                }
            }
            $offset=floor($num/10)*10;
            $where_teacherid="schoolid='$this->schoolid' AND term=$term AND school_type=$school_type AND teacher='$teacher'";
            $teacher_id=$this->rule_model->get_column2('id','fly_teacher',$where_teacherid);
            $where="schoolid='$this->schoolid' AND term=$term AND school_type=$school_type AND forbid_teacher=$teacher_id[id]";
            $data['week_section']=$this->rule_model->get_column2('week,section','fly_rule',$where);
            $data['teacher_id']=$teacher_id['id'];
            $data['teacher']=$teacher;
        }

        $sql = "SELECT id, teacher,teach_course FROM fly_teacher WHERE $searchsql limit $offset,10";
        $query = $this->db->query ( $sql );
        $list = $query->result_array ();

        $data ['list'] = $list;
        $data['forbid_name']='教师不排课时间';
        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $data['sections']=$this->session->userdata('section');
        $data['weeks']=$this->session->userdata('week');

        $this->load->view ( 'timetable/' . 'rule_forbid_teacher', $data );
    }


    //插入新的和更新都在这
    function insert_forbid_class(){
        $data['schoolid']=$this->schoolid;
        $data['term']=$this->session->userdata('term');
        $data['school_type']=$this->school_type;
        $data['grade']=$this->input->post('grade');
        $data['classname']=$this->input->post('classname');
        $data['week']=$this->input->post('week');
        $data['section']=$this->input->post('section');
        $message=$this->input->post('message');
        $label=$this->input->post('label');

        $where="schoolid=$data[schoolid] AND term=$data[term] AND school_type=$data[school_type] AND grade='$data[grade]' AND classname='$data[classname]' AND week=$data[week] AND section=$data[section]";
        $num=$this->rule_model->counts("fly_rule",$where);

        if($num==0){
            //插入fly_rule数据表
            $data['forbid_class']=0;
            $res=$this->rule_model->db_insert_table("fly_rule",$data);
            if(!empty($label)){
                //标签不为空，插入fly_timetabl数据库
                unset($data['forbid_class']);
                $data['title']=$label;
                $data['title_flag']=1;
                $this->timetable_model->db_insert_table("fly_timetable",$data);
            }
        }else{
            //更新
            if(empty($message)){
                $update['forbid_class']=0;
                $res=$this-> rule_model->db_update_table("fly_rule", $update, $data);
                if(!empty($label)){
                    //标签不为空，插入fly_timetabl数据库
                    $data['title']=$label;
                    $data['title_flag']=1;
                    $this->timetable_model->db_insert_table("fly_timetable",$data);
                }
            }else{
                $update['forbid_class']=1;
                $res=$this-> rule_model->db_update_table("fly_rule", $update, $data);
                //删除fly_timetable对应的这节课
                $this->timetable_model->db_delete2("fly_timetable",$data);
            }
        }
            //echo $message;

    }
    function insert_forbid_class_all(){
        $data['schoolid']=$this->schoolid;
        $data['term']=$term=$this->session->userdata('term');
        $data['school_type']=$school_type=$this->school_type;
        $data['grade']=$grade=$this->input->post('grade');
        $data['week']=$this->input->post('week');
        $data['section']=$this->input->post('section');
        $message=$this->input->post('message');
        $label=$this->input->post('label');
        //获取该年级全部班级
        $where_classname="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade'";
        $column="classname";
        $table="fly_course_plan";
        $res_classname=$this->course_plan_model->get_column($column,$table,$where_classname);
        $arr_classname=unique($res_classname);
        foreach($arr_classname as $classname_value){
            $data['classname']="$classname_value";
            $where="schoolid=$data[schoolid] AND term=$data[term] AND school_type=$data[school_type] AND grade='$data[grade]' AND classname='$classname_value' AND week=$data[week] AND section=$data[section]";
            $num=$this->rule_model->counts("fly_rule",$where);
            if($num==0){
                //插入fly_rule数据表
                $data['forbid_class']=0;
                $this->rule_model->db_insert_table("fly_rule",$data);
                if(!empty($label)){
                    //标签不为空，插入fly_timetabl数据库
                    unset($data['forbid_class']);
                    $data['title']=$label;
                    $data['title_flag']=1;
                    $this->timetable_model->db_insert_table("fly_timetable",$data);
                    unset($data['title']);
                    unset($data['title_flag']);
                }
            }else{
                //更新
                if(empty($message)){
                    $update['forbid_class']=0;
                    $this-> rule_model->db_update_table("fly_rule", $update, $data);
                    if(!empty($label)){
                        unset($data['forbid_class']);
                        //标签不为空，插入fly_timetabl数据库
                        $data['title']=$label;
                        $data['title_flag']=1;
                        $this->timetable_model->db_insert_table("fly_timetable",$data);
                        unset($data['title']);
                        unset($data['title_flag']);
                    }
                }else{
                    $update['forbid_class']=1;
                    $res=$this-> rule_model->db_update_table("fly_rule", $update, $data);
                    //删除fly_timetable对应的这节课
                    $this->timetable_model->db_delete2("fly_timetable",$data);
                }
            }
        }




    }

    function get_forbid_class_message()
    {
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade=$this->input->post('grade');
        $classname=$this->input->post('classname');
        //获取该班级禁排信息
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND forbid_class=0";
        $forbid_class_message =$this->rule_model->get_column("week,section","fly_rule",$where);
        foreach($forbid_class_message as $key=>$value){
            $where_timetable="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND week=$value[week] AND section=$value[section]";
            $result =$this->rule_model->get_column2("title","fly_timetable",$where_timetable);
            $forbid_class_message[$key]['title']=$result['title'];
        }
        echo json_encode($forbid_class_message);
    }

    function get_forbid_class_message_all()
    {
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade=$this->input->post('grade');
        //获取该年级全部班级
        $where_classname="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade'";
        $column="classname";
        $table="fly_course_plan";
        $res_classname=$this->course_plan_model->get_column($column,$table,$where_classname);
        $arr_classname=unique($res_classname);
        //取班级数组中第一个值（即取第一个班级）
        $classname=reset($arr_classname);
        //获取该班级禁排信息
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND forbid_class=0";
        $forbid_class_message =$this->rule_model->get_column("week,section","fly_rule",$where);
        foreach($forbid_class_message as $key=>$value){
            $where_timetable="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND week=$value[week] AND section=$value[section]";
            $result =$this->rule_model->get_column2("title","fly_timetable",$where_timetable);
            $forbid_class_message[$key]['title']=$result['title'];
        }
        echo json_encode($forbid_class_message);
    }

    function insert_forbid_course()
    {
        $data['week']=$this->input->post('week');
        $data['section']=$this->input->post('section');
        $data['forbid_course']=$this->input->post('coursename');
        $data['grade']=$grade=$this->input->post('grade');

        $data['schoolid']=$this->schoolid;
        $data['term']=$term=$this->session->userdata('term');
        $data['school_type']=$school_type=$this->school_type;
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type";
        $column="grade,classname";
        $table="fly_course_plan";
        $message =$this->course_plan_model->get_column($column,$table,$where);
        $i=0;
        $j=0;
        foreach($message as $key=>$value){
            if($message[$key]['grade']==$message[$key+1]['grade']){
                $arr_grade[$i]['grade']=$message[$key]['grade'];
                if($message[$key]['classname']==$message[$key+1]['classname']){
                    $arr_classname[$i][$j]=$message[$key]['classname'];
                }else{
                    $j++;
                }
            }else{
                $i++;
            }
        }
        //所有班级
        foreach($arr_grade as $key=>$value){
            if($value['grade']==$grade){
                $arr=$arr_classname[$key];
            }
        }
        foreach($arr as $key=>$value){
            $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$value' AND week=$data[week] AND section=$data[section] AND forbid_course='$data[forbid_course]'";
            $num=$this->rule_model->counts("fly_rule",$where);
            if($num==0){
                //插入fly_timetabl数据库
                $data['classname']="$value";
                $this->rule_model->db_insert_table("fly_rule",$data);
            }else{
                //删除
                $data['classname']="$value";
                $this->rule_model->db_delete2("fly_rule",$data);
            }
        }
    }

    function get_forbid_course_message()
    {
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade=$this->input->post('grade');
        $coursename=$this->input->post('coursename');

        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type";
        $column="grade,classname";
        $table="fly_course_plan";
        $message =$this->course_plan_model->get_column($column,$table,$where);
        $i=0;
        $j=0;
        foreach($message as $key=>$value){
            if($message[$key]['grade']==$message[$key+1]['grade']){
                $arr_grade[$i]['grade']=$message[$key]['grade'];
                if($message[$key]['classname']==$message[$key+1]['classname']){
                    $arr_classname[$i][$j]=$message[$key]['classname'];
                }else{
                    $j++;
                }
            }else{
                $i++;
                $j=0;
            }
        }
        //所有班级
        foreach($arr_grade as $key=>$value){
            if($value['grade']==$grade){
                $arr=$arr_classname[$key];
            }
        }
        //获取该课程禁排信息
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$arr[0]' AND forbid_course='$coursename'";
        $forbid_course_message =$this->rule_model->get_column("week,section","fly_rule",$where);

        echo json_encode($forbid_course_message);
    }

    function insert_forbid_teacher()
    {
        $data['schoolid']=$this->schoolid;
        $data['term']=$this->session->userdata('term');
        $data['school_type']=$this->school_type;
        $data['week']=$this->input->post('week');
        $data['section']=$this->input->post('section');
        $teacher_id=$this->input->post('teacher_id');
        $where="schoolid=$data[schoolid] AND term=$data[term] AND school_type=$data[school_type] AND week=$data[week] AND section=$data[section] AND forbid_teacher=$teacher_id";
        $num=$this->rule_model->counts("fly_rule",$where);
        if($num==0){
            //插入fly_rule数据库
            $data['forbid_teacher']=$teacher_id;
            $this->rule_model->db_insert_table("fly_rule",$data);
        }else{
            //删除
            $data['forbid_teacher']=$teacher_id;
            $this->rule_model->db_delete2("fly_rule",$data);
        }


    }

    function get_forbid_teacher_message()
    {
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $teacher_id=$this->input->post('teacher_id');

        //获取该课程禁排信息
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND forbid_teacher=$teacher_id";
        $forbid_teacher_message =$this->rule_model->get_column("week,section","fly_rule",$where);

        echo json_encode($forbid_teacher_message);
    }

    function firstly()
    {
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type";
        $column="grade,classname";
        $table="fly_course_plan";
        $message =$this->course_plan_model->get_column($column,$table,$where);
        $i=0;
        $j=0;
        foreach($message as $key=>$value){
            if($message[$key]['grade']==$message[$key+1]['grade']){
                $arr_grade[$i]['grade']=$message[$key]['grade'];
                if($message[$key]['classname']==$message[$key+1]['classname']){
                    $arr_classname[$i][$j]=$message[$key]['classname'];
                }else{
                    $j++;
                }
            }else{
                $i++;
            }
        }
        $data['grade']=$arr_grade;
        $data['classname']=$arr_classname;

        //获取各个年级的课程
        foreach($arr_grade as $key=>$value){
            $res[$key]=array();
            $where_course="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$value[grade]' AND course_num!=0";
            $mes=$this->course_plan_model->get_column("course","fly_course_plan",$where_course);
            foreach($mes as $k=>$val){
                if(!in_array($val['course'],$res[$key])){
                    $res[$key][]=$val['course'];
                }
            }
        }
        $data['course']=$res;
        $data['sections']=$this->session->userdata('section');
        $data['weeks']=$this->session->userdata('week');

        $this->load->view('timetable/' .'rule_firstly',$data);
    }

    function insert_firstly()
    {
        $data['schoolid']=$this->schoolid;
        $data['term']=$this->session->userdata('term');
        $data['school_type']=$this->school_type;
        $data['week']=$this->input->post('week');
        $data['section']=$this->input->post('section');
        $data['grade']=$this->input->post('grade');
        $data['classname']=$this->input->post('classname');

        //将优先要排的课插入数据库
        $where="schoolid=$data[schoolid] AND term=$data[term] AND school_type=$data[school_type] AND grade='$data[grade]' AND classname='$data[classname]' AND week=$data[week] AND section=$data[section]";
        $num=$this->rule_model->counts("fly_timetable",$where);

        if($num==0){    //添加
            $data['title']=$this->input->post('coursename');
            $data['title_flag']=1;
            $where_teacher="schoolid=$data[schoolid] AND school_type=$data[school_type] AND term=$data[term] AND grade='$data[grade]' AND classname='$data[classname]' AND course='$data[title]'";
            $teacher=$this->course_plan_model->get_column2("teacher","fly_course_plan",$where_teacher);//获取教该班，该课的老师的id,名字
            $data['teacher_truename']=$teacher['teacher'];
            $result=$this->timetable_model->db_insert_table("fly_timetable",$data);
        }else{
            $result=$this->timetable_model->db_delete2("fly_timetable",$data);
        }

    }

    function insert_firstly_all(){
        $data['schoolid']=$this->schoolid;
        $data['term']=$term=$this->session->userdata('term');
        $data['school_type']=$school_type=$this->school_type;
        $data['week']=$this->input->post('week');
        $data['section']=$this->input->post('section');
        $data['grade']=$grade=$this->input->post('grade');
        $data['title']=$this->input->post('coursename');
        //获取该年级全部班级
        $where_classname="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade'";
        $column="classname";
        $table="fly_course_plan";
        $res_classname=$this->course_plan_model->get_column($column,$table,$where_classname);
        $arr_classname=unique($res_classname);

        foreach($arr_classname as $classname_key=>$classname_value){
            //将优先要排的课插入数据库
            $data['classname']="$classname_value";
            $where="schoolid=$data[schoolid] AND term=$data[term] AND school_type=$data[school_type] AND grade='$data[grade]' AND classname='$data[classname]' AND week=$data[week] AND section=$data[section]";
            $num=$this->rule_model->counts("fly_timetable",$where);
            if($num==0){    //添加
                $data['title_flag']=1;
                $where_teacher="schoolid=$data[schoolid] AND school_type=$data[school_type] AND term=$data[term] AND grade='$data[grade]' AND classname='$data[classname]' AND course='$data[title]'";
                $teacher=$this->course_plan_model->get_column2("teacher","fly_course_plan",$where_teacher);//获取教该班，该课的老师的id,名字
                $data['teacher_truename']=$teacher['teacher'];
                $result=$this->timetable_model->db_insert_table("fly_timetable",$data);
            }else{
                $result=$this->timetable_model->db_delete2("fly_timetable",$data);
            }
        }



    }

    function get_firstly_message()
    {
        $data['schoolid']=$this->schoolid;
        $data['term']=$this->session->userdata('term');
        $data['school_type']=$this->school_type;
        $data['grade']=$this->input->post('grade');
        $data['classname']=$this->input->post('classname');
        //获取该该班优先排课信息
        $where="schoolid=$data[schoolid] AND term=$data[term] AND school_type=$data[school_type] AND grade='$data[grade]' AND classname='$data[classname]' AND title_flag=1 AND teacher_truename IS NOT NULL";
        $firstly_message =$this->timetable_model->get_column("week,section,title","fly_timetable",$where);
        echo json_encode($firstly_message);

    }

    function get_firstly_message_all(){
        $data['schoolid']=$this->schoolid;
        $data['term']=$term=$this->session->userdata('term');
        $data['school_type']=$school_type=$this->school_type;
        $data['grade']=$grade=$this->input->post('grade');
        //获取该年级全部班级
        $where_classname="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade'";
        $column="classname";
        $table="fly_course_plan";
        $res_classname=$this->course_plan_model->get_column($column,$table,$where_classname);
        $arr_classname=unique($res_classname);
        //取班级数组中第一个值（即取第一个班级）
        $data['classname']=reset($arr_classname);
        //获取该该班优先排课信息
        $where="schoolid=$data[schoolid] AND term=$data[term] AND school_type=$data[school_type] AND grade='$data[grade]' AND classname='$data[classname]' AND title_flag=1 AND teacher_truename IS NOT NULL";
        $firstly_message =$this->timetable_model->get_column("week,section,title","fly_timetable",$where);
        echo json_encode($firstly_message);

    }

    function label_add(){
        $this->session->set_userdata('dialog_url',"index.php?d=admin&c=rule&m=rule_set");
        $this->load->view('timetable/' .'label_add');
    }

    function label_edit(){
        $data['schoolid']=$this->schoolid;
        $data['term']=$this->session->userdata('term');
        $data['school_type']=$this->school_type;
        $where="schoolid=$this->schoolid AND term=$data[term] AND school_type=$data[school_type]";
        $data['label_list']=$this->label_model->get_column('id,label_name',"fly_label",$where);
        $this->session->set_userdata('dialog_url',"index.php?d=admin&c=rule&m=rule_set");
        $this->load->view('timetable/' .'label_edit',$data);
    }

    //增加在这里
    function label_save_add(){
        $data['schoolid']=$this->schoolid;
        $data['term']=$this->session->userdata('term');
        $data['school_type']=$this->school_type;
        $value=$this->input->post("value");
        $data['label_name']=$value['label_name'];
        $this->label_model->db_insert_table("fly_label",$data);

        $this->load->view('timetable/' .'label_add',$data);
    }

    function label_save_edit(){
        $data['label_list']=$value=$this->input->post("value");
        foreach($value as $key=>$value){
            $this-> rule_model->db_update_table("fly_label", $value, $value['id']);
        }
        $this->load->view('timetable/' .'label_edit',$data);
    }

    function delete_label(){
        $id=$this->input->post('id');
        $res=$this->label_model->db_delete_table('fly_label',$id);
        $json = json_encode($res);
        echo $json;
    }










}
