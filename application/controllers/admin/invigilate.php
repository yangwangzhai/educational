<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * 学生成绩管理
 * @ author qcl 2016-01-11
 */

include 'content.php';
require_once APPPATH.'libraries/PHPExcel.php';
require_once APPPATH.'libraries/Spreadsheet_Excel_Reader.php';
class Invigilate extends Content
{

    function __construct()
    {
        $class_name = 'invigilate';
        $this->name = '学生成绩';
        $this->list_view = $class_name . '_list';
        $this->add_view = $class_name . '_add';
        $this->edit_view = $class_name . '_edit';
        $this->table = 'fly_' . $class_name;
        $this->baseurl = 'index.php?d=admin&c=invigilate'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('invigilate_model');
    }

    public function index(){
        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $total_rows=$this->invigilate_model->rows_query();
        $pagination['total_rows'] =$total_rows;
        $pagination['base_url'] = $this->baseurl;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('pn') ? intval($this->input->get('pn')) : 0;
        $data['list'] = $this->invigilate_model->get_list2('*',"",'fly_invigilate_list',$offset,10);

        $this->load->view('admin/' . $this->list_view,$data);
    }

    public function save_invigilate_list(){
        $invigilate_list_id=$this->input->get('id');
        $data['test_name']=$this->input->post('test_name');
        $data['term']=$this->input->post('term');
        $data['date']=$this->input->post('date');
        $_SESSION ['url_forward']=$this->baseurl;
        if($invigilate_list_id){    //修改
            $this->invigilate_model->db_update_table("fly_invigilate_list",$data,$invigilate_list_id);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        }else{  //添加
            $this->invigilate_model->db_insert_table("fly_invigilate_list",$data);
            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }

    public function invigilate_rule(){
        $invigilate_list_id=$this->input->get('id');
        $mess['title']=$data['title']=$this->invigilate_model->get_column2("id,test_name,term,date","fly_invigilate_list","id=$invigilate_list_id");
        $date_arr_result=$this->invigilate_model->get_column("date","fly_invigilate","invigilate_list_id=$invigilate_list_id order by date asc");
        $date_arr_temp=unique($date_arr_result);
        foreach($date_arr_temp as $value){
            $date_arr[]=$value;
        }
        $grade_arr_result=$this->invigilate_model->get_column("grade","fly_invigilate","invigilate_list_id=$invigilate_list_id");
        $grade_arr_temp=unique($grade_arr_result);
        $i=7;
        foreach($grade_arr_temp as $value){
            $grade_arr[$i]=$value;
            $i++;
        }
        $date_section_arr=array("morning","afternoon");
        if(!empty($date_arr)){
            foreach($date_arr as $date_arr_key=>$date_arr_value){
                $list[$date_arr_key]['date']=$date_arr_value;
                foreach($date_section_arr as $date_section_arr_key=>$date_section_arr_value){
                    foreach($grade_arr as $grade_arr_key=>$grade_arr_value){
                        $where="invigilate_list_id=$invigilate_list_id AND date='$date_arr_value' AND date_section='$date_section_arr_value' AND grade='$grade_arr_value'";
                        $list[$date_arr_key][$date_section_arr_value][$grade_arr_key]=$this->invigilate_model->get_column("course,time_begin,time_end","fly_invigilate",$where);
                    }
                }

            }
        }

        if(empty($list)){
            $this->load->view('admin/invigilate_rule',$data);
        }else{
            $mess['list']=$list;
            $this->load->view('admin/invigilate_rule_edit',$mess);
        }

    }

    public function invigilate_rule_save(){
        $insert['invigilate_list_id']=$this->input->get('id');
        $flag=$this->input->get('flag');
        $invigilate=$this->input->post('value');
        $_SESSION ['url_forward']=$this->baseurl;
        if($flag){  //修改
            //先删除原来的记录
            $delete['invigilate_list_id']=$insert['invigilate_list_id'];
            $this->invigilate_model->db_delete2("fly_invigilate",$delete);

            foreach($invigilate as $invigilate_key=>$invigilate_value){
                $insert['date']=$invigilate_value['date'];
                foreach($invigilate_value[7] as $key=>$value){
                    foreach($value as $k=>$v){
                        $insert['grade']="七年级";
                        $insert['course']=$v['course'];
                        $insert['date_section']=$key;
                        $insert['time_begin']=$v['time1'];
                        $insert['time_end']=$v['time2'];
                        //插入fly_invigilate表
                        $this->invigilate_model->db_insert_table("fly_invigilate",$insert);
                    }
                }

                foreach($invigilate_value[8] as $key=>$value){
                    foreach($value as $k=>$v){
                        $insert['grade']="八年级";
                        $insert['course']=$v['course'];
                        $insert['date_section']=$key;
                        $insert['time_begin']=$v['time1'];
                        $insert['time_end']=$v['time2'];
                        //插入fly_invigilate表
                        $this->invigilate_model->db_insert_table("fly_invigilate",$insert);
                    }
                }

                foreach($invigilate_value[9] as $key=>$value){
                    foreach($value as $k=>$v){
                        $insert['grade']="九年级";
                        $insert['course']=$v['course'];
                        $insert['date_section']=$key;
                        $insert['time_begin']=$v['time1'];
                        $insert['time_end']=$v['time2'];
                        //插入fly_invigilate表
                        $this->invigilate_model->db_insert_table("fly_invigilate",$insert);
                    }
                }

            }
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );

        }else{  //添加
            foreach($invigilate as $invigilate_key=>$invigilate_value){
                $insert['date']=$invigilate_value['date'];
                foreach($invigilate_value[7] as $key=>$value){
                    foreach($value as $k=>$v){
                        $insert['grade']="七年级";
                        $insert['course']=$v['course'];
                        $insert['date_section']=$key;
                        $insert['time_begin']=$v['time1'];
                        $insert['time_end']=$v['time2'];
                        //插入fly_invigilate表
                        $this->invigilate_model->db_insert_table("fly_invigilate",$insert);
                    }
                }

                foreach($invigilate_value[8] as $key=>$value){
                    foreach($value as $k=>$v){
                        $insert['grade']="八年级";
                        $insert['course']=$v['course'];
                        $insert['date_section']=$key;
                        $insert['time_begin']=$v['time1'];
                        $insert['time_end']=$v['time2'];
                        //插入fly_invigilate表
                        $this->invigilate_model->db_insert_table("fly_invigilate",$insert);
                    }
                }

                foreach($invigilate_value[9] as $key=>$value){
                    foreach($value as $k=>$v){
                        $insert['grade']="九年级";
                        $insert['course']=$v['course'];
                        $insert['date_section']=$key;
                        $insert['time_begin']=$v['time1'];
                        $insert['time_end']=$v['time2'];
                        //插入fly_invigilate表
                        $this->invigilate_model->db_insert_table("fly_invigilate",$insert);
                    }
                }

            }

            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }


    }

    public function delete_inligilate(){
        $id=$this->input->get('id');
        $delete['id']=$id;
        $this->invigilate_model->db_delete2("fly_invigilate_list",$delete);
        $delete2['invigilate_list_id']=$id;
        $this->invigilate_model->db_delete2("fly_invigilate",$delete2);
        $_SESSION ['url_forward']=$this->baseurl;
        show_msg ( '删除成功！', $_SESSION ['url_forward'] );
    }

    public function invigilate_auto(){
        $id=$this->input->get('id');
        //判断是否已经排好
        $flag=$this->invigilate_model->get_column2("flag","fly_invigilate_list","id=$id");
        if($flag['flag']){
            show_msg ( '已安排，请查看！', $_SESSION ['url_forward'] );
        }else{
            //年级数组  （以后动态获取）
            $garde_arr=array("七年级","八年级","九年级");
            foreach($garde_arr as $garde_arr_key=>$garde_arr_value){
                //获取所有考试日期，科目，开始时间，结束时间等信息
                $invigilate_arr=$this->invigilate_model->get_column("invigilate_list_id,grade,date,course,date_section,time_begin,time_end","fly_invigilate","invigilate_list_id=$id AND grade='$garde_arr_value' order by date asc");
                /*echo $garde_arr_value."的所有考试日期，科目，开始时间，结束时间等信息：";
                echo "<br>";
                echo "<pre>";
                print_r($invigilate_arr);
                echo "<pre/>";*/
                //获取该年级所有班级（先手动，后自动获取）
                switch($garde_arr_value){
                    case "七年级":
                        $class_arr=array("1班","2班","3班","4班","5班","6班","7班","8班","9班","六辅");
                        break;
                    case "八年级":
                        $class_arr=array("1班","2班","3班","4班","5班","6班","7班","8班","二辅");
                        break;
                    case "九年级":
                        $class_arr=array("1班","2班","3班","4班","5班","6班","7班","8班","9班","五辅");
                        break;
                }
                //获取该年级的所有老师（不包括领导、行政人员）
                $teacher_arr_result=$this->invigilate_model->get_column("truename","fly_teacher_base","grade_group='$garde_arr_value' AND middle_leader=0");
                //教师数组转为一维数组
                $teacher_arr='';
                foreach($teacher_arr_result as $teacher_arr_result_value){
                    $teacher_arr[]=$teacher_arr_result_value['truename'];
                }
                /*echo $garde_arr_value."的所有老师：";
                echo "<pre>";
                print_r($teacher_arr);
                echo "<pre/>";*/
                //获取后勤人员，当老师排完时候，后勤人员补上
                $logistics_member_result=$this->invigilate_model->get_column("truename","fly_teacher_base","grade_group='' AND course='' AND middle_leader=0");
                //后勤人员数组转为一维数组
                $logistics_member_arr='';
                foreach($logistics_member_result as $logistics_member_result_value){
                    $logistics_member_arr[]=$logistics_member_result_value['truename'];
                }
                /*echo "所有后勤人员：";
                echo "<pre>";
                print_r($logistics_member_arr);
                echo "<pre/>";*/
                //按日期，各个班级依次安排监考老师
                foreach($invigilate_arr as $invigilate_arr_key=>$invigilate_arr_value){
                    //判断教师数组是否为空，空则用后勤人员数组代替
                    if(empty($teacher_arr)){
                        $teacher_arr_temp=$logistics_member_arr;
                        /*echo "教师数组为空，重新赋值：";
                        echo "<pre>";
                        print_r($teacher_arr_temp);
                        echo "<pre/>";*/
                    }else{
                        $teacher_arr_temp=$teacher_arr;
                        /*echo "教师数组不为空：";
                        echo "<pre>";
                        print_r($teacher_arr_temp);
                        echo "<pre/>";*/
                    }
                    foreach($class_arr as $class_arr_key=>$class_arr_value){
                        //随机获取一个老师
                        if(empty($teacher_arr_temp)){
                            $teacher_arr_temp=$logistics_member_arr;
                            /*echo "随机获取教师的数组为空，重新赋值：";
                            echo "<pre>";
                            print_r($teacher_arr_temp);
                            echo "<pre/>";*/
                        }
                        $teacher=rand_arr($teacher_arr_temp);
                        /*echo "随机获取的老师为：".$teacher;
                        echo "<br>";*/
                        //从fly_invigilate_table表统计该老师安排了几次监考
                        $num=$this->invigilate_model->db_counts("fly_invigilate_table","invigilate_list_id=$id AND grade='$garde_arr_value' AND teacher='$teacher'");
                        /*echo $teacher."老师已经安排的次数为：".$num;
                        echo "<br>";*/
                        //判断该老师是否为班主任
                        $manage_flag=$this->invigilate_model->get_column2("manage_class","fly_teacher_base","grade_group='$garde_arr_value' AND truename='$teacher'");
                        /*echo "判断该老师是否为班主任：";
                        echo "<pre>";
                        print_r($manage_flag);
                        echo "<pre/>";*/
                        //判断该老师是否为主科老师
                        $major_flag=$this->invigilate_model->get_column2("course","fly_teacher_base","grade_group='$garde_arr_value' AND truename='$teacher' AND manage_class=''");
                        /*echo "判断该老师是否为主科老师：";
                        echo "<pre>";
                        print_r($major_flag);
                        echo "<pre/>";*/
                        if(!empty($manage_flag['manage_class'])){
                            //不为空，说明是班主任，班主任不安排超过2次
                            if($num<=1){
                                //存入数据库
                                $insert=array();
                                $insert='';
                                $insert=$invigilate_arr_value;
                                $insert['teacher']=$teacher;
                                $insert['classname']=$class_arr_value;
                                $res=$this->invigilate_model->db_insert_table("fly_invigilate_table",$insert);
                                if($res){   //插入成功后
                                    $teacher_key=arr_key($teacher_arr_temp,$teacher);
                                    unset($teacher_arr_temp[$teacher_key]);
                                    /*echo $teacher."（班主任）插入成功，临时教师数组为：";
                                    echo "<pre>";
                                    print_r($teacher_arr_temp);
                                    echo "<pre/>";*/
                                }
                                //从fly_invigilate_table表统计该老师安排了几次监考，如果达到2次，则将该老师从教师数组中注销
                                $num_total=$this->invigilate_model->db_counts("fly_invigilate_table","invigilate_list_id=$id AND grade='$garde_arr_value' AND teacher='$teacher'");
                                if($num_total==2){
                                    $teacher_key=arr_key($teacher_arr,$teacher);
                                    unset($teacher_arr[$teacher_key]);
                                    /*echo $teacher."（班主任）插入数据库后，该老师已安排：$num_total，从教师数组中删除该老师：";
                                    echo "<pre>";
                                    print_r($teacher_arr);
                                    echo "<pre/>";*/
                                }
                            }
                        }elseif($major_flag['course']=='语文'||$major_flag['course']=='数学'||$major_flag['course']=='英语'){
                            //主科老师，不安排超过3次
                            if($num<=2){
                                //存入数据库
                                $insert=array();
                                $insert='';
                                $insert=$invigilate_arr_value;
                                $insert['teacher']=$teacher;
                                $insert['classname']=$class_arr_value;
                                $res=$this->invigilate_model->db_insert_table("fly_invigilate_table",$insert);
                                if($res){   //插入成功后
                                    $teacher_key=arr_key($teacher_arr_temp,$teacher);
                                    unset($teacher_arr_temp[$teacher_key]);
                                    /*echo $teacher."（主科老师）插入成功，临时教师数组为：";
                                    echo "<pre>";
                                    print_r($teacher_arr_temp);
                                    echo "<pre/>";*/
                                }
                                //从fly_invigilate_table表统计该老师安排了几次监考，如果达到3次，则将该老师从教师数组中注销
                                $num_total=$this->invigilate_model->db_counts("fly_invigilate_table","invigilate_list_id=$id AND grade='$garde_arr_value' AND teacher='$teacher'");
                                if($num_total==3){
                                    $teacher_key=arr_key($teacher_arr,$teacher);
                                    unset($teacher_arr[$teacher_key]);
                                    /*echo $teacher."（主科老师）插入数据库后，该老师已安排：$num_total，从教师数组中删除该老师：";
                                    echo "<pre>";
                                    print_r($teacher_arr);
                                    echo "<pre/>";*/
                                }
                            }
                        }else{
                            //副科老师，不安排超过4次
                            if($num<=3){
                                //存入数据库
                                $insert=array();
                                $insert='';
                                $insert=$invigilate_arr_value;
                                $insert['teacher']=$teacher;
                                $insert['classname']=$class_arr_value;
                                $res=$this->invigilate_model->db_insert_table("fly_invigilate_table",$insert);
                                if($res){   //插入成功后
                                    $teacher_key=arr_key($teacher_arr_temp,$teacher);
                                    unset($teacher_arr_temp[$teacher_key]);
                                    /*echo $teacher."（副科老师）插入成功，临时教师数组为：";
                                    echo "<pre>";
                                    print_r($teacher_arr_temp);
                                    echo "<pre/>";*/
                                }
                                //从fly_invigilate_table表统计该老师安排了几次监考，如果达到4次，则将该老师从教师数组中注销
                                $num_total=$this->invigilate_model->db_counts("fly_invigilate_table","invigilate_list_id=$id AND grade='$garde_arr_value' AND teacher='$teacher'");
                                if($num_total==4){
                                    $teacher_key=arr_key($teacher_arr,$teacher);
                                    unset($teacher_arr[$teacher_key]);
                                    /*echo $teacher."（副科老师）插入数据库后，该老师已安排：$num_total，从教师数组中删除该老师：";
                                    echo "<pre>";
                                    print_r($teacher_arr);
                                    echo "<pre/>";*/
                                }
                            }
                        }
                    }
                }

            }
        }


    }

    public function invigilate_look(){
        $invigilate_list_id=$this->input->get('id');
        $mess['title']=$data['title']=$this->invigilate_model->get_column2("id,test_name,term,date","fly_invigilate_list","id=$invigilate_list_id");
        $date_arr_result=$this->invigilate_model->get_column("date","fly_invigilate","invigilate_list_id=$invigilate_list_id order by date asc");
        $date_arr_temp=unique($date_arr_result);
        foreach($date_arr_temp as $value){
            $date_arr[]=$value;
        }
        $grade_arr_result=$this->invigilate_model->get_column("grade","fly_invigilate","invigilate_list_id=$invigilate_list_id");
        $grade_arr_temp=unique($grade_arr_result);
        $i=7;
        foreach($grade_arr_temp as $value){
            $grade_arr[$i]=$value;
            $i++;
        }
        $date_section_arr=array("morning","afternoon");
        if(!empty($date_arr)){
            foreach($date_arr as $date_arr_key=>$date_arr_value){
                $list[$date_arr_key]['date']=$date_arr_value;
                foreach($date_section_arr as $date_section_arr_key=>$date_section_arr_value){
                    foreach($grade_arr as $grade_arr_key=>$grade_arr_value){
                        $where="invigilate_list_id=$invigilate_list_id AND date='$date_arr_value' AND date_section='$date_section_arr_value' AND grade='$grade_arr_value'";
                        $list[$date_arr_key][$date_section_arr_value][$grade_arr_key]=$this->invigilate_model->get_column("course","fly_invigilate",$where);
                        foreach($list[$date_arr_key][$date_section_arr_value][$grade_arr_key] as $kk=>$vv){
                            $where_invigilate_table="$invigilate_list_id AND date='$date_arr_value' AND date_section='$date_section_arr_value' AND grade='$grade_arr_value' AND course='$vv[course]'";
                            $list[$date_arr_key][$date_section_arr_value][$grade_arr_key][$kk]=$this->invigilate_model->get_column("course,teacher,date,time_begin,time_end","fly_invigilate_table",$where_invigilate_table);
                        }
                    }
                }

            }
        }
        foreach($list as $key=>$value){
            $num_rowspan[]=count($value['morning'][7])+count($value['afternoon'][7]);
            $num_rowspan[]=count($value['morning'][8])+count($value['afternoon'][8]);
            $num_rowspan[]=count($value['morning'][9])+count($value['afternoon'][9]);
            rsort($num_rowspan);
            $date_rowspan_num[$key]=$num_rowspan[0]*2;
            unset($num_rowspan);
        }

        foreach($list as $key=>$value){
            $morning_section_num_rowspan[]=count($value['morning'][7]);
            $morning_section_num_rowspan[]=count($value['morning'][8]);
            $morning_section_num_rowspan[]=count($value['morning'][9]);
            rsort($morning_section_num_rowspan);
            $morning_section_rowspan_num[$key]=$morning_section_num_rowspan[0]*2;
            unset($morning_section_num_rowspan);
        }
        foreach($list as $key=>$value){
            $afternoon_section_num_rowspan[]=count($value['afternoon'][7]);
            $afternoon_section_num_rowspan[]=count($value['afternoon'][8]);
            $afternoon_section_num_rowspan[]=count($value['afternoon'][9]);
            rsort($afternoon_section_num_rowspan);
            $afternoon_section_rowspan_num[$key]=$afternoon_section_num_rowspan[0]*2;
            unset($afternoon_section_num_rowspan);
        }


        $mess['date_rowspan_num']=$date_rowspan_num;
        $mess['morning_section_rowspan_num']=$morning_section_rowspan_num;
        $mess['afternoon_section_rowspan_num']=$afternoon_section_rowspan_num;
        $mess['list']=$list;
        $mess['classes_num']=array("7"=>10,"8"=>9,"9"=>10);

        $this->load->view('admin/invigilate_look',$mess);
    }
















}