<?php

if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

// 规则设置

include 'content.php';

class course_plan extends Content
{

    function __construct()
    {
        $this->name = '课程计划';
        $this->control = 'course_plan';
        $this->baseurl = 'index.php?d=admin&c=course_plan';
        $this->table = 'fly_course_plan';
        $this->list_view = 'course_plan'; // 列表页
        $this->add_view = 'course_plan_add'; // 添加页
        parent::__construct();

    }

    // 首页
    public function index()
    {
        // 根据session中的schoolid，$term，$school_type从fly_class表获取每个年级的所有班级
        $term=$this->session->userdata('term');
        $school_type=$this->session->userdata('school_type');
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type";
        $column="classes";
        $table="fly_class";
        $class_arr =$this->timetable_model->get_column($column,$table,$where);
        $grade=$this->timetable_model->get_column('grade',$table,$where);
        $arr=array();
        foreach($class_arr as $value){
            $arr[]=explode(",",$value['classes']);
        }
        //判断年级类型 小学 中学
        if(count($class_arr)==6){   //小学 或中学
            $b=array('一','二','三','四','五','六');
            foreach ($arr as $k1=>$v1) {
                foreach ($v1 as $k2=>$v2) {
                    $res=substr ( $arr[$k1][$k2],4 );
                    $classes[$k1][$k2] = ( $b[$k1].'（'.$res.'）班');
                }
            }
        }else{
            $c=array('七','八','九');
            foreach ($arr as $k1=>$v1) {
                foreach ($v1 as $k2=>$v2) {
                    $res=substr ( $arr[$k1][$k2],4 );
                    $classes[$k1][$k2] = ( $c[$k1].'（'.$res.'）班');
                }
            }
        }
        $this->session->set_userdata('list1',$arr);
        $this->session->set_userdata('list2',$classes);

        $data['grade']=$grade;      //年级
        $data['classname']=$arr;        //班级的数字表达 20151
        $data['classes']=$classes;  //班级的中文表达 七（1）

        $this->load->view ( 'admin/course_plan',$data);

    }

    public function plan()
    {
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->session->userdata('school_type');
        $classname=$this->input->get('classname');  //获取点击的班级
        //根据获取的班级从数据库取出该班级所有课程
        $where_get_colum = "classes like '%$classname%' AND schoolid=$schoolid AND term=$term AND school_type=$school_type";
        $couseres= $this->course_plan_model->get_column2("major,minor", "fly_class", $where_get_colum);
        foreach($couseres as $value){
            $arr[]=explode(",",$value);
        }
        foreach($arr as $value){
            foreach($value as $val){
                $data['list'][]=$val;
            }
        }

        $data['classname']=$classname;
        $data['list1']=$this->session->userdata('list1');
        $data['list2']=$this->session->userdata('list2');
        //查询 课程计划表是否已经存在数据，有则取出来
        $data['arr']=$this->course_plan_model->get_column("*","fly_course_plan","classname=$classname AND schoolid=$schoolid AND term=$term AND school_type=$school_type");

        $this->load->view ( 'admin/course_plan_add',$data );

    }

    //添加、更新都在这里
    public function save()
    {
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->session->userdata('school_type');
        $classname=$this->input->post('classname');
        $list=$this->input->post('value');
        foreach($list as $key=>$value){
            $list[$key]['schoolid']=$schoolid;
            $list[$key]['term']=$term;
            $list[$key]['school_type']=$school_type;
        }

        if(empty($list[0]['id'])){
            $this->course_plan_model->insert_plan($list);  //添加
        }else{
            $this->course_plan_model->update_plan($list);   //更新
        }

        //根据获取的班级从数据库取出该班级所有课程
        $where_get_colum = "classes like '%$classname%' AND schoolid=$schoolid and term=$term AND school_type=$school_type";
        $couseres= $this->course_plan_model->get_column2("major,minor", "fly_class", $where_get_colum);
        foreach($couseres as $value){
            $arr[]=explode(",",$value);
        }

        foreach($arr as $value){
            foreach($value as $val){
                $data['list'][]=$val;
            }
        }

        $data['classname']=$classname;
        $data['arr']=$this->course_plan_model->get_column("*","fly_course_plan","classname=$classname AND schoolid=$schoolid and term=$term AND school_type=$school_type");

        $this->load->view ( 'admin/course_plan_add',$data );
    }

    function copy()
    {
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->session->userdata('school_type');
        $copy_from=$this->input->post('copy_from');
        $copy_to=$this->input->post('copy_to');
        //获取要复制信息
        $list=$this->course_plan_model->get_column("course,course_num,continue_times","fly_course_plan","classname=$copy_from AND schoolid=$schoolid AND term=$term AND school_type=$school_type");
        foreach($list as $key=>$value){
            $list[$key]['classname']=$copy_to;
            $list[$key]['schoolid']=$schoolid;
            $list[$key]['term']=$term;
            $list[$key]['school_type']=$school_type;
        }
        //删除原有的信息
        $this->course_plan_model->db_delete2("fly_course_plan",array('classname'=>$copy_to));

        $this->course_plan_model->insert_plan($list);  //添加

        show_msg ( '复制成功！', $this->baseurl."&m=plan&classname=$copy_from" );

    }












}
