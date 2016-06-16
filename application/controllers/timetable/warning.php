<?php

if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

// 每日刷卡统计

include 'content.php';

class warning extends Content
{

    function __construct()
    {
        $this->control = 'warning';
        $this->baseurl = 'index.php?d=admin&c=warning';
        $this->table = 'fly_warning';
        $this->list_view = 'warning_list'; // 列表页
        $this->add_view = 'class_add'; // 添加页
        parent::__construct();
    }

    function index(){
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        //数组 星期
        $week = config_item('week');
        //数组 每节课
        $section = config_item('section2');
        $where_teacher_id="schoolid=$schoolid AND term=$term AND school_type=$school_type";
        $teacher_id=$this->member_model->get_column("id","fly_member",$where_teacher_id);
        foreach($teacher_id as $key=>$value){
            foreach($week as $week_key=>$week_value){
                foreach($section as $section_key=>$section_value){
                    $where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND week=$week_key AND section=$section_key AND uid=$value[id]";
                    $result[]=$this->member_model->get_column("id","fly_timetable",$where);
                }
            }
        }

        foreach($result as $key=>$value){
            if(count($value)>1){
                $data[]=$key;
            }
        }
        echo "<pre>";
        print_r($result);
        print_r($data);
        echo "<pre/>";
        exit;



    }
















}
