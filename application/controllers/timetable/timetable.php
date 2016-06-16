<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// 课程表

include 'content.php';
class timetable extends Content {

	function __construct() {
		$this->name = '课程表';
		$this->control = 'timetable';
		$this->baseurl = 'index.php?d=timetable&c=timetable';
		$this->table = 'fly_timetable';
		$this->list_view = 'timetable_list'; // 列表页
		$this->add_view = 'timetable_add'; // 添加
		parent::__construct ();
        $this->load->model('timetable/task_model');
        $this->load->model('timetable/rule_model');
        $this->load->model('timetable/label_model');
        $this->load->model('timetable/course_plan_model');
        $this->load->model('timetable/teacher_model');
        $this->load->model('timetable/timetable_model');
        $this->load->model('timetable/temporary_model');

	}

    //调整课表
    public function course_move(){

        /*$grade='初三';
        $classname='9班';
        $teacher='刘爱玲';
        $week=1;
        $section=6;
        $course='政治';
        //根据年级，班级获取已排的所有课程
        $result=$this->timetable_model->move_timetable($grade,$classname,$week,$section,$course);

        echo "<pre>";
        print_r($result);
        echo "</pre>";
        exit;
        exit;*/

        /*$grade="初一";
        $classname="1班";
        $teacher="";
        $week="4";
        $section="7";
        $course="历史";
        $result=$this->timetable_model->move_timetable($grade,$classname,$teacher,$week,$section,$course);
        echo "可调数组为：";
        echo "<pre>";
        print_r($result);
        echo "<pre/>";
        exit;*/
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        //判断是否已经导入基础信息，如果没有导入，给出提示并返回到基础信息导入页面
        $num=$this->course_plan_model->counts("fly_course_plan","schoolid=$this->schoolid AND term=$term AND school_type=$school_type");
        if($num==0){
            show_msg ( '请先导入基础信息！', "index.php?d=timetable&c=task&m=base_message" );
        }else{
            $grade=$this->input->post("grade");
            $classname=$this->input->post("classname");
            if(empty($grade)&&empty($classname)){  //为空，默认取出一年级1班的所有课程
                $where_one_grade="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND course_num!=0 order by id asc limit 1";
                $grade_result=$this->timetable_model->get_column2("grade,classname","fly_course_plan",$where_one_grade);
                $grade=$grade_result['grade'];
                $classname=$grade_result['classname'];
            }

            $class[] = array(
                'grade'=>$grade,
                'classname' => $classname,
                'table' => $this->getTable($this->schoolid,$term,$school_type,$grade,$classname)
            );

            //获取所有年级
            $where_grade="schoolid=$this->schoolid AND term=$term AND school_type=$school_type ";
            $grades=$this->course_plan_model->get_column("grade","fly_course_plan",$where_grade);
            $result=array();
            foreach($grades as $key=>$value){
                if(!in_array($value['grade'],$result)){
                    $result[]=$value['grade'];
                }
            }
            //根据年级，从fly_course_plan表获取年级所有班级。
            $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade'";
            $classese=$this->course_plan_model->get_column("classname","fly_course_plan",$where);
            $res=array();
            foreach($classese as $key=>$value){
                if(!in_array($value['classname'],$res)){
                    $res[]=$value['classname'];
                }
            }
            //根据年级，班级取出调课时未安排上的课
            $where_temporary="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname'";
            $result_temporary=$this->temporary_model->get_column("course,teacher","fly_temporary",$where_temporary);;

            $data['list']=$class;
            $data['grades']=$result;
            $data['classnames']=$res;
            $data['grade']=$grade;
            $data['classname']=$classname;
            $data['sections']=$this->session->userdata('section');
            $data['weeks']=$this->session->userdata('week');
            $data['temporary']=$result_temporary;

            $this->load->view ( 'timetable/timetable_move', $data );
        }

    }

    //查看课表
    public function course_list(){
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        //判断是否已经导入基础信息，如果没有导入，给出提示并返回到基础信息导入页面
        $num=$this->course_plan_model->counts("fly_course_plan","schoolid=$this->schoolid AND term=$term AND school_type=$school_type");
        if($num==0){
            show_msg ( '请先导入基础信息！', "index.php?d=timetable&c=task&m=base_message" );
        }else{
            $grade=$this->input->post("grade");
            if(empty($grade)){  //为空，默认取出一年级的所有课程
                $where_one_grade="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND course_num!=0 order by id asc limit 1";
                $grade_result=$this->timetable_model->get_column2("grade","fly_course_plan",$where_one_grade);
                $grade=$grade_result['grade'];
            }
            //根据年级，从fly_course_plan表获取年级所有班级。
            $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade'";
            $classese=$this->course_plan_model->get_column("classname","fly_course_plan",$where);
            $res=array();
            foreach($classese as $key=>$value){
                if(!in_array($value['classname'],$res)){
                    $res[]=$value['classname'];
                }
            }
            foreach($res as $k=>$v){
                $class[] = array(
                    'grade'=>$grade,
                    'classname' => $v,
                    'table' => $this->getTable($this->schoolid,$term,$school_type,$grade,$v)
                );
            }
            //获取所有年级
            $where_grade="schoolid=$this->schoolid AND term=$term AND school_type=$school_type ";
            $grades=$this->course_plan_model->get_column("grade","fly_course_plan",$where_grade);
            $result=array();
            foreach($grades as $key=>$value){
                if(!in_array($value['grade'],$result)){
                    $result[]=$value['grade'];
                }
            }
            $data['list']=$class;
            $data['grades']=$result;
            $data['grade']=$grade;
            $data['sections']=$this->session->userdata('section');
            $data['weeks']=$this->session->userdata('week');
            
            $this->load->view('timetable/timetable_list',$data);
        }

    }

    public function table_state(){
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type";
        //判断是否已经导入基础信息，如果没有导入，给出提示并返回到基础信息导入页面
        $num=$this->course_plan_model->counts("fly_course_plan",$where);
        if($num==0){
            show_msg ( '请先导入基础信息！', "index.php?d=timetable&c=task&m=base_message" );
        }else{
            $term=$this->session->userdata('term');
            $where="id=$term";
            $task_state=$this->timetable_model->get_column2("task_state","fly_task",$where);

            if($task_state['task_state']){
                //已经排好
                $this->load->view('timetable/timetable_auto');
            }else{
                //未排
                $this->load->view('timetable/timetable_state');
            }
        }

    }

    //重新随机排课
    public function table_replace()
    {
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $sql="delete from fly_timetable WHERE schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND title_flag=0";
        $query = $this->db->query($sql);
        /*echo "删除全部课程。";
        echo "<br/>";*/
        $this->table_all();
    }

    //自动排课
    public function table_all(){
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type";
        //判断是否已经导入基础信息，如果没有导入，给出提示并返回到基础信息导入页面
        $num=$this->course_plan_model->counts("fly_course_plan",$where);
        if($num==0){
            show_msg ( '请先导入基础信息！', "index.php?d=timetable&c=task&m=base_message" );
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
            //数组 星期
            $week =$data['weeks']=$this->session->userdata('week');
            //数组 每节次
            $section = $data['sections']=$this->session->userdata('section');
            foreach($arr_grade as $arr_grade_key=>$arr_grade_value){
                foreach($arr_classname[$arr_grade_key] as $arr_classname_value) {
                    //获取全部课程，存入数组中
                    $where_course="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$arr_grade_value[grade]' AND classname='$arr_classname_value' AND course_num!=0";
                    $res=$this->course_plan_model->get_column("course,course_num,continue_times,teacher","fly_course_plan",$where_course);

                //对课程数组进行优先级排序
                    //并从fly_teacher表里面取出老师一共教几个班
                    foreach($res as $key=>$value){
                        $teach_class_num="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND teacher='$value[teacher]' ";
                        $teach_class_num_result=$this->course_plan_model->get_column2("teach_class_num,teach_total","fly_teacher",$teach_class_num);
                        $res[$key]['teach_class_num']=$teach_class_num_result['teach_class_num'];
                        $res[$key]['teach_total']=$teach_class_num_result['teach_total'];
                    }

                    //开始排序
                    //老师授课数大于1的分一组，小于4的另分一组
                    foreach($res as $key=>$value){
                        if($value['teach_class_num']>1&&$value['course_num']<4){
                            $arr_temp_1[]=$value;
                        }else if($value['course_num']>3){  //认定为主科
                            $arr_temp_2[]=$value;
                        }else{
                            $arr_temp_3[]=$value;
                        }
                    }
                    /*echo "<pre>";
                    print_r($arr_temp_1);
                    print_r($arr_temp_2);
                    print_r($arr_temp_3);
                    echo "<pre/>";*/

                    if(!empty($arr_temp_1)){
                        $arr_temp_1=array_sort($arr_temp_1,"course_num",$sort="SORT_DESC");
                    }
                    if(!empty($arr_temp_2)){
                        $arr_temp_2=array_sort($arr_temp_2,"course_num",$sort="SORT_DESC");
                    }
                    if(!empty($arr_temp_3)){
                        $arr_temp_3=array_sort($arr_temp_3,"course_num",$sort="SORT_DESC");
                    }

                    /*echo "<pre>";
                    print_r($arr_temp_1);
                    print_r($arr_temp_2);
                    print_r($arr_temp_3);
                    echo "<pre/>";*/

                    //合并为一个数组
                    unset($major_minor);
                    $major_minor=array();
                    if(!empty($arr_temp_2)){
                        foreach($arr_temp_2 as $key=>$value){
                            $major_minor[]=$value;
                        }
                    }
                    if(!empty($arr_temp_1)){
                        foreach($arr_temp_1 as $key=>$value){
                            $major_minor[]=$value;
                        }
                    }
                    if(!empty($arr_temp_3)){
                        foreach($arr_temp_3 as $key=>$value){
                            $major_minor[]=$value;
                        }
                    }
                    /*echo "<br/>";
                    echo $arr_grade_value['grade']."-".$arr_classname_value;
                    echo "<br/>";*/
                    /*echo "<pre>";
                    print_r($major_minor);
                    echo "</pre>";*/
                    //从课程数组中删除预先已经排满的课程
                    foreach($major_minor as $key=>$value){
                        $where_num="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$arr_grade_value[grade]'AND classname='$arr_classname_value' AND title='$value[course]'";
                        $minor_num[$key] = $this->timetable_model->counts("fly_timetable",$where_num );
                        $plan_num[$key]=$value['course_num'];
                    }
                    foreach($major_minor as $key=>$value){
                        if($minor_num[$key]>=$plan_num[$key]){
                            unset($major_minor[$key]);
                        }
                    }

                    unset($teach_class_num_result);
                    unset($temp);
                    unset($arr_temp_1);
                    unset($arr_temp_2);
                    unset($arr_temp_3);
                    //开始排课
                    foreach($major_minor as $key=>$value){
                        $course_num_result=$this->timetable_model->fun_course_num($arr_grade_value['grade'],$arr_classname_value,$value['course']);
                        if(!$course_num_result){    //未排满返回false 
                            /*echo "<br/>";
                            echo "要排的科目：".$value['course'];
                            echo "<br/>";*/
                            global $again_flag;         //删除该年级排课记录，并重排的标志
                            global $cycle_table_all;    //删除该年级课程记录，并重排的次数
                            global $cycle;              //删除整个学校课程记录，并重排的次数
                            //判断依次取出来的课程的优先级。
                            if($value['course_num']>4){    //主科
                                $this->timetable_model->major_paike($arr_grade_value['grade'],$arr_classname_value,$major_minor[$key]);
                            }else{
                                $this->timetable_model->minor_paike($arr_grade_value['grade'],$arr_classname_value,$major_minor[$key]);
                                //判断是否要重新排整个年级课程
                                /*echo "重排标志：".$GLOBALS['again_flag'];
                                echo "<br/>";*/
                                if($GLOBALS['again_flag']){
                                    $cycle_table=$GLOBALS['cycle_table_all'];
                                    $cycle_table++;
                                    $GLOBALS['cycle_table_all']=$cycle_table;
                                    /*echo "班级循环次数：".$GLOBALS['cycle_table_all'];
                                    echo "<br/>";*/
                                    if($GLOBALS['cycle_table_all']<60){
                                        $this->timetable_model->delete_class($arr_grade_value['grade'],$arr_classname_value);
                                        //重新从当前班级开始排(前面年级排好的，将不会被取代)
                                        $this->table_all();
                                        /*echo "删除该班级重排后，顺利排满";
                                        echo "<br/>";*/
                                        return;
                                    }else{
                                        $cycle_all=$GLOBALS['cycle'];
                                        $cycle_all++;
                                        $GLOBALS['cycle']=$cycle_all;
                                        if($GLOBALS['cycle']<6){
                                            $this->timetable_model->delete_grade($arr_grade_value['grade']);
                                            $this->table_all();
                                            /*echo "通过删除全校课程，重排，顺利完成";
                                            echo "<br/>";*/
                                            return;
                                        }else{
                                            //排课失败
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            foreach($arr_classname as $k=>$v){
                foreach($v as $kk=>$vv){
                    $class[] = array(
                        'grade'=>$arr_grade[$k]['grade'],
                        'classname' => $arr_classname[$k][$kk],
                        'table' => $this->getTable($this->schoolid,$term,$school_type,$arr_grade[$k]['grade'],$arr_classname[$k][$kk])
                    );
                }
            }
            $update_where['id'] = $term;  //学期
            $update['task_state']=1;
            $this->timetable_model->db_update_table("fly_task",$update,$update_where);
            $this->load->view ( 'timetable/timetable_auto');
        }

    }

    function getTable($schoolid, $term,$school_type,$grade,$classid)
    {
        // 构建一个空的课程表
        $table = array();
        $week = $this->session->userdata('week');
        $section = $this->session->userdata('section');

        foreach($section as $section_key=>$section_value) {
            foreach($week as $week_key=>$week_value) {
                $table[$section_key][$week_key]['id'] = '';
                $table[$section_key][$week_key]['title'] = '';
            }
        }

        $query = $this->db->query("select id,week,section,title,term,school_type,teacher_truename,tips from $this->table where schoolid='$schoolid' and term='$term' and school_type='$school_type' and grade='$grade'  AND classname='$classid' order by section,week limit 50");
        $result = $query->result_array();

        foreach($result as $r){
            $table[$r['section']][$r['week']]['id'] = $r['id'];
            $table[$r['section']][$r['week']]['title'] = $r['title'];
            $table[$r['section']][$r['week']]['term'] = $r['term'];
            $table[$r['section']][$r['week']]['school_type'] = $r['school_type'];
            $table[$r['section']][$r['week']]['teacher_truename'] = $r['teacher_truename'];
            $table[$r['section']][$r['week']]['tips'] = $r['tips'];
        }

        return $table;
    }

	// 添加
	public function add ()
	{
        $data['value']['grade'] = $_GET['grade'];
        $data['value']['classname'] = $_GET['classname'];
		$data['value']['week'] = $_GET['week'];
		$data['value']['section'] = $_GET['section'];

        $this->load->view('timetable/' . $this->add_view, $data);
	}	
	
	// 编辑
	public function edit() {
		$id = intval ( $_GET ['id'] );
		// 根据id获取该节课的信息
		$query = $this->db->get_where ( $this->table, 'id = ' . $id, 1 );
		$value = $query->row_array ();
        if(empty($value)){
            $value['grade']=$this->input->get('grade');
            $value['classname']=$this->input->get('classname');
            $value['week']=$this->input->get('week');
            $value['section']=$this->input->get('section');
            $data['value']=$value;
        }else{
            $data ['id'] = $id;
            $data ['value'] = $value;
        }

        //根据班级，星期几，第几节课到fly_warning表查看有无该节课的记录
        //$data['warning'][]=$this->warning_model->get_warning($value['section'],$value['week'],$value['grade'],$value['classname'],$value['schoolid'],$value['term'],$value['school_type']);

		$this->load->view ( 'timetable/' . $this->add_view, $data );
	}

    // 弹出选择课程对话框
    function chooseclass_dialog()
    {
        //根据班级名称(20151) 在表fly_class找到对应的主科，副科
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade=$this->input->get("grade");
        $classname=$this->input->get("classname");
        $where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND course_num!=0 ";
        $major_minor=$this->course_plan_model->get_column("course","fly_course_plan",$where);
        $data['list'] = $major_minor;

        $this->load->view('timetable/chooseclass_dialog', $data);
    }

    // 弹出选择老师对话框
    function dialog ()
    {
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade = $this->input->get("grade");
        $classname = $this->input->get("classname");
        $course=$this->input->get("course");
        $where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND course='$course' ";
        $major_minor=$this->course_plan_model->get_column("teacher","fly_course_plan",$where);
        $data['list']=$major_minor;

        $this->load->view('timetable/teacher_dialog', $data);
    }

	// 保存 添加和修改都是在这里
	public function save() {
		$id = intval ( $_POST ['id'] );
		$data = trims ( $_POST ['value'] );
		//$data['classname'] = getNumber($data['classid']);
		$data['schoolid'] = $this->schoolid;
        $data['term']=$this->session->userdata('term');
        $data['school_type']=$this->school_type;

        if ($id) { // 修改课程 ===========
            $this->db->where ( 'id', $id );
            $query = $this->db->update ( $this->table, $data );
            $insert_id=$id;
            //show_msg ( '修改成功！');
        } else { // ===========添加课程 ===========
            $insert_id = $this->timetable_model->db_insert_table ("fly_timetable",$data );
            //show_msg ( '添加成功！');
        }
        //$res=$this->member_model->get_truename($data['uid']); //获取老师的真实名字
        //$data['truename']=$res['truename'];
        $mession['value']=$data;
        $mession['id']=$insert_id;

        $this->load->view ( 'timetable/' . $this->add_view, $mession );




	}
	//删除某节课
    public function delete_timetable()
    {
        //$data用来删除fly_timetable表的记录
        //$data['id']=$this->input->get('id');
        $data['grade']=$this->input->post('grade');
        $data['classname']=$this->input->post('classname');
        $data['section']=$this->input->post('section');
        $data['week']=$this->input->post('week');
        $data['term']=$this->session->userdata('term');
        $data['school_type']=$this->school_type;
        $data['schoolid']=$this->schoolid;

        //$warning用来删除fly_warning表的记录
        $warning['grade']=$this->input->post('grade');
        $warning['classname']=$this->input->post('classname');
        $warning['section']=$this->input->post('section');
        $warning['week']=$this->input->post('week');
        $warning['term']=$this->session->userdata('term');
        $warning['school_type']=$this->school_type;
        $warning['schoolid']=$this->schoolid;

        //删除fly_timetable表的一条课程记录
        $res1=$this->timetable_model->db_delete2("fly_timetable",$data);
        echo 1;
        //如果提示信息表中存在该节课的提示信息，则删除之。
        //$res2=$this->warning_model->get_warning($warning['section'],$warning['week'],$warning['classname'],$warning['schoolid'],$warning['term'],$warning['school_type']);
        //$res3=$this->warning_model->db_delete2("fly_warning",$warning);
        //$url = "$this->baseurl&m=table_all";
        /*if($res1&&$res2&&$res3||$res1){
            echo 1;
        }*/
    }

//转换教师课表
    public function change_teacher()
    {
        // 从fly_course_plan表获取所有老师
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade=$this->input->post('grade');
        $course=$this->input->post('course');
        if(empty($grade)||empty($course)){
            $where_one_grade="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND course_num!=0 order by id asc limit 1";
            $grade_result=$this->timetable_model->get_column2("grade,course","fly_course_plan",$where_one_grade);
            $grade=$grade_result['grade'];
            $course=$grade_result['course'];
        }
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND course='$course' AND teacher IS NOT NULL";
        $column="teacher";
        $table="fly_course_plan";
        $teacher_arr =$this->course_plan_model->get_column($column,$table,$where);
        $arr=array();
        foreach($teacher_arr as $key=>$val){
            if(!in_array($val['teacher'],$arr)){
                $arr[]=$val['teacher'];     //获取所有老师
            }
        }
        //根据老师名字获取老师所教的全部课程
        foreach($arr as $key=>$value){
            $where_teach_course="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND teacher='$value'";
            $teach_course[$key] =$this->course_plan_model->get_column2("teach_course","fly_teacher",$where_teach_course);
        }

        foreach($arr as $k=>$v){
                $class[] = array(
                    'teacher_truename'=>$v,
                    'teach_course'=>$teach_course[$k]['teach_course'],
                    'table' => $this->getTable_teacher($this->schoolid,$term,$school_type,$v)
                );
        }
        //获取所有年级
        $where_grade="schoolid=$this->schoolid AND term=$term AND school_type=$school_type ";
        $grades=$this->course_plan_model->get_column("grade","fly_course_plan",$where_grade);
        $result=array();
        foreach($grades as $key=>$value){
            if(!in_array($value['grade'],$result)){
                $result[]=$value['grade'];
            }
        }
        //根据年级获取所有课程
        $course_all=array();
        $where_course="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND course_num!=0";

        $mes=$this->course_plan_model->get_column("course","fly_course_plan",$where_course);
        foreach($mes as $k=>$val){
            if(!in_array($val['course'],$course_all)){
                $course_all[]=$val['course'];
            }
        }
        $data['list']=$class;
        $data['grades']=$result;
        $data['grade']=$grade;
        $data['course']=$course;
        $data['course_all'] = $course_all;
        $data['sections']=$this->session->userdata('section');
        $data['weeks']=$this->session->userdata('week');
        $this->load->view ( 'timetable/timetable_teacher', $data );

    }

    function getTable_teacher($schoolid,$term,$school_type,$teacher_uid)
    {
        // 构建一个空的课程表
        $table = array();
        $week = $this->session->userdata('week');
        $section = $this->session->userdata('section');

        foreach($section as $section_key=>$section_value) {
            foreach($week as $week_key=>$week_value) {
                $table[$section_key][$week_key]['id'] = '';
                $table[$section_key][$week_key]['title'] = '';
                $table[$section_key][$week_key]['grade'] = '';
                $table[$section_key][$week_key]['classname'] = '';
            }
        }

        $query = $this->db->query("select id,week,section,title,tips,uid,grade,classname from $this->table where schoolid='$schoolid' AND term='$term' AND school_type='$school_type' and teacher_truename='$teacher_uid' order by section,week limit 40");
        $result = $query->result_array();

        foreach($result as $r){
            $table[$r['section']][$r['week']]['id'] = $r['id'];
            $table[$r['section']][$r['week']]['title'] = $r['title'];
            $table[$r['section']][$r['week']]['tips'] = $r['tips'];
            $table[$r['section']][$r['week']]['grade'] = $r['grade'];
            $table[$r['section']][$r['week']]['classname'] = $r['classname'];
        }

        return $table;
    }

    //异步获取某个教师的课程表（调课）
    public function get_teacher_timetable(){
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $teacher=$this->input->post('teacher');
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND teacher_truename='$teacher'";
        $result=$this->timetable_model->get_column("grade,classname,week,section","fly_timetable",$where);

        echo json_encode($result);
    }

    public function get_adjust_position(){
        $grade=$this->input->post('grade');
        $classname=$this->input->post('classname');
        $week=$this->input->post('week');
        $section=$this->input->post('section');
        $course=$this->input->post('course');
        //根据年级，班级获取已排的所有课程
        $result=$this->timetable_model->move_timetable($grade,$classname,$week,$section,$course);
        if(empty($result)){
            echo json_encode(0);
        }else{
            echo json_encode($result);
        }

    }

    public function get_temporary_adjust_position(){
        $grade=$this->input->post('grade');
        $classname=$this->input->post('classname');
        $course=$this->input->post('course');
        //根据年级，班级获取已排的所有课程
        $result=$this->timetable_model->temporary_move_timetable($grade,$classname,$course);
        if(empty($result)){
            echo json_encode(0);
        }else{
            echo json_encode($result);
        }
    }

    public function change_adjust_position(){
        $next_grade=$this->input->post('next_grade');
        $next_classname=$this->input->post('next_classname');
        $next_week=$this->input->post('next_week');
        $next_section=$this->input->post('next_section');
        $next_course=$this->input->post('next_course');
        $next_teacher=$this->input->post('next_teacher');
        $before_course=$this->input->post('before_course');
        $before_week=$this->input->post('before_week');
        $before_section=$this->input->post('before_section');
        $before_teacher=$this->input->post('before_teacher');
        //交换位置
        $next_where['schoolid']=$this->schoolid;
        $next_where['term']=$this->session->userdata('term');
        $next_where['school_type']=$this->school_type;
        $next_where['grade']=$next_grade;
        $next_where['classname']=$next_classname;
        $next_where['week']=$next_week;
        $next_where['section']=$next_section;
        $next_updata['title']=$before_course;
        $next_updata['teacher_truename']=$before_teacher;
        $res1=$this->timetable_model->db_update_table("fly_timetable", $next_updata, $next_where);

        $before_where['schoolid']=$this->schoolid;
        $before_where['term']=$this->session->userdata('term');
        $before_where['school_type']=$this->school_type;
        $before_where['grade']=$next_grade;
        $before_where['classname']=$next_classname;
        $before_where['week']=$before_week;
        $before_where['section']=$before_section;
        $before_updata['title']=$next_course;
        $before_updata['teacher_truename']=$next_teacher;
        $res2=$this->timetable_model->db_update_table("fly_timetable", $before_updata, $before_where);
        if($res1&&$res2){
            echo true;
        }else{
            echo false;
        }

    }

    public function arrange_adjust_position(){
        $next_grade=$this->input->post('next_grade');
        $next_classname=$this->input->post('next_classname');
        $next_week=$this->input->post('next_week');
        $next_section=$this->input->post('next_section');
        $next_course=$this->input->post('next_course');
        $next_teacher=$this->input->post('next_teacher');
        $before_course=$this->input->post('before_course');
        $before_week=$this->input->post('before_week');
        $before_section=$this->input->post('before_section');
        $before_teacher=$this->input->post('before_teacher');
        //交换可安排的位置
        $next_where['schoolid']=$this->schoolid;
        $next_where['term']=$this->session->userdata('term');
        $next_where['school_type']=$this->school_type;
        $next_where['grade']=$next_grade;
        $next_where['classname']=$next_classname;
        $next_where['week']=$next_week;
        $next_where['section']=$next_section;
        $next_updata['title']=$before_course;
        $next_updata['teacher_truename']=$before_teacher;
        $res1=$this->timetable_model->db_update_table("fly_timetable", $next_updata, $next_where);

        $before_where['schoolid']=$this->schoolid;
        $before_where['term']=$this->session->userdata('term');
        $before_where['school_type']=$this->school_type;
        $before_where['grade']=$next_grade;
        $before_where['classname']=$next_classname;
        $before_where['week']=$before_week;
        $before_where['section']=$before_section;
        $before_updata['title']='';
        $before_updata['teacher_truename']='';
        $res2=$this->timetable_model->db_update_table("fly_timetable", $before_updata, $before_where);
        if($res1&&$res2){
            //把暂存起来的课程插入fly_temporary表
            $insert['schoolid']=$this->schoolid;
            $insert['term']=$this->session->userdata('term');
            $insert['school_type']=$this->school_type;
            $insert['grade']=$next_grade;
            $insert['classname']=$next_classname;
            $insert['course']=$next_course;
            $insert['teacher']=$next_teacher;
            $this->timetable_model->db_insert_table ("fly_temporary",$insert );
            echo true;
        }else{
            echo false;
        }

    }

    public function access_adjust_position(){
        $next_grade=$this->input->post('next_grade');
        $next_classname=$this->input->post('next_classname');
        $next_week=$this->input->post('next_week');
        $next_section=$this->input->post('next_section');
        $next_course=$this->input->post('next_course');
        $next_teacher=$this->input->post('next_teacher');
        $before_course=$this->input->post('before_course');
        $before_teacher=$this->input->post('before_teacher');
        //交换可安排的位置
        $next_where['schoolid']=$this->schoolid;
        $next_where['term']=$this->session->userdata('term');
        $next_where['school_type']=$this->school_type;
        $next_where['grade']=$next_grade;
        $next_where['classname']=$next_classname;
        $next_where['week']=$next_week;
        $next_where['section']=$next_section;
        $next_updata['title']=$before_course;
        $next_updata['teacher_truename']=$before_teacher;
        $this->timetable_model->db_update_table("fly_timetable", $next_updata, $next_where);

        //删除fly_timetable对应的暂存的数据
        $before_delete_where['schoolid']=$this->schoolid;
        $before_delete_where['term']=$this->session->userdata('term');
        $before_delete_where['school_type']=$this->school_type;
        $before_delete_where['grade']="$next_grade";
        $before_delete_where['classname']="$next_classname";
        $before_delete_where['course']="$before_course";
        $before_delete_where['teacher']="$before_teacher";
        $this->timetable_model->db_delete2("fly_temporary",$before_delete_where);
        if(!empty($next_course)){  //
            //把新的课程暂存起来，并且插入fly_temporary表
            $insert['schoolid']=$this->schoolid;
            $insert['term']=$this->session->userdata('term');
            $insert['school_type']=$this->school_type;
            $insert['grade']=$next_grade;
            $insert['classname']=$next_classname;
            $insert['course']=$next_course;
            $insert['teacher']=$next_teacher;
            $this->timetable_model->db_insert_table ("fly_temporary",$insert );
        }
        echo true;

    }

    public function get_class_message(){
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade=$this->input->post("grade");
        //根据年级，从fly_course_plan表获取年级所有班级。
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade'";
        $classese=$this->course_plan_model->get_column("classname","fly_course_plan",$where);
        $res=array();
        foreach($classese as $key=>$value){
            if(!in_array($value['classname'],$res)){
                $res[]=$value['classname'];
            }
        }

        echo json_encode($res);
    }

    public function get_course_message(){
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade=$this->input->post("grade");
        $classname=$this->input->post("classname");
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname'";
        $result[0]=$this->timetable_model->get_column("grade,classname,week,section,title,teacher_truename","fly_timetable",$where);
        //根据年级，班级取出调课时未安排上的课
        $where_temporary="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname'";
        $result[1]=$this->temporary_model->get_column("course,teacher","fly_temporary",$where_temporary);;

        echo json_encode($result);
    }


    //转换总表
    public function change_total()
    {
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade=$this->input->post('grade');
        if(!empty($grade)){
            //根据年级，从fly_course_plan表获取年级所有班级。
            $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade'";
            $classese=$this->course_plan_model->get_column("classname","fly_course_plan",$where);
            $res=array();
            foreach($classese as $key=>$value){
                if(!in_array($value['classname'],$res)){
                    $res[]=$value['classname'];
                }
            }

            foreach($res as $k=>$v){
                    $class[] = array(
                        'grade'=>$grade,
                        'classname' => $v,
                        'table' => $this->getTable_total($this->schoolid,$term,$school_type,$grade,$v)
                    );
            }
        }else{
            // 根据session中的schoolid，$term，$school_type从fly_course_plan表获取每个年级的所有班级
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
            foreach($arr_classname as $k=>$v){
                foreach($v as $kk=>$vv){
                    $class[] = array(
                        'grade'=>$arr_grade[$k]['grade'],
                        'classname' => $arr_classname[$k][$kk],
                        'table' => $this->getTable_total($this->schoolid,$term,$school_type,$arr_grade[$k]['grade'],$arr_classname[$k][$kk])
                    );
                }
            }
        }
        //获取所有年级
        $where_grade="schoolid=$this->schoolid AND term=$term AND school_type=$school_type ";
        $grades=$this->course_plan_model->get_column("grade","fly_course_plan",$where_grade);
        $result=array();
        foreach($grades as $key=>$value){
            if(!in_array($value['grade'],$result)){
                $result[]=$value['grade'];
            }
        }
        $data['list'] = $class;
        $data['grades']=$result;
        $data['grade']=$grade;
        $data['sections']=$this->session->userdata('section');
        $data['weeks']=$this->session->userdata('week');

        $this->load->view ( 'timetable/timetable_total',$data);
    }

    function getTable_total($schoolid,$term,$school_type,$grade,$classid)
    {
        // 构建一个空的课程表
        $table = array();
        $week = $this->session->userdata('week');
        $section = $this->session->userdata('section');

        foreach($week as $week_key=>$week_value) {
            foreach($section as $section_key=>$section_value){
                $table[$week_key][$section_key]['id'] = '';
                $table[$week_key][$section_key]['title'] = '';
                $table[$week_key][$section_key]['teacher_truename'] = '';
            }
        }

        $query = $this->db->query("select id,week,section,title,tips,teacher_truename from $this->table where schoolid='$schoolid' AND term='$term' AND school_type='$school_type' AND grade='$grade' and classname='$classid' order by week,section limit 40");
        $result = $query->result_array();

        foreach($result as $r){
            $table[$r['week']][$r['section']]['id'] = $r['id'];
            $table[$r['week']][$r['section']]['title'] = $r['title'];
            $table[$r['week']][$r['section']]['tips'] = $r['tips'];
            $table[$r['week']][$r['section']]['teacher_truename'] = $r['teacher_truename'];
        }
        return $table;
    }

    //导出班级表
    public function out_class()
    {
        // 根据session中的schoolid，$term，$school_type从fly_course_plan表获取每个年级的所有班级
        $schoolid=$this->schoolid;
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

        foreach($arr_classname as $k=>$v){
            foreach($v as $kk=>$vv){
                $class[] = array(
                    'grade'=>$arr_grade[$k]['grade'],
                    'classname' => $arr_classname[$k][$kk],
                    'table' => $this->getTable($this->schoolid,$term,$school_type,$arr_grade[$k]['grade'],$arr_classname[$k][$kk])
                );
            }
        }
        $data['list'] = $class;
        $data['sections']=$this->session->userdata('section');
        $data['weeks']=$this->session->userdata('week');

        $this->load->view ( 'timetable/out_class', $data );
    }

    public function out_teacher()
    {
        //
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND teacher IS NOT NULL";
        $column="teacher";
        $table="fly_course_plan";
        $teacher_arr =$this->course_plan_model->get_column($column,$table,$where);
        $arr=array();
        foreach($teacher_arr as $key=>$val){
            if(!in_array($val['teacher'],$arr)){
                $arr[]=$val['teacher'];
            }
        }

        foreach($arr as $k=>$v){
            $class[] = array(
                'teacher_truename'=>$v,
                'table' => $this->getTable_teacher($this->schoolid,$term,$school_type,$v)
            );
        }
        $data['list'] = $class;
        $data['sections']=$this->session->userdata('section');
        $data['weeks']=$this->session->userdata('week');

        $this->load->view ( 'timetable/out_timetable_teacher', $data );
    }

    public function out_total()
    {
        // 根据session中的schoolid，$term，$school_type从fly_course_plan表获取每个年级的所有班级
        $schoolid=$this->schoolid;
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

        foreach($arr_classname as $k=>$v){
            foreach($v as $kk=>$vv){
                $class[] = array(
                    'grade'=>$arr_grade[$k]['grade'],
                    'classname' => $arr_classname[$k][$kk],
                    'table' => $this->getTable_total($this->schoolid,$term,$school_type,$arr_grade[$k]['grade'],$arr_classname[$k][$kk])
                );
            }
        }
        $data['list'] = $class;
        $data['sections']=$this->session->userdata('section');
        $data['weeks']=$this->session->userdata('week');

        $this->load->view ( 'timetable/out_total', $data );
    }

    function get_course_plan()
    {
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade=$this->input->post('grade');
        $classname=$this->input->post('classname');
        $res=$this->timetable_model->get_column("*","fly_course_plan","grade='$grade' AND classname='$classname' AND schoolid=$schoolid AND term=$term and school_type=$school_type");
        echo json_encode($res);
    }

    function get_have_course()
    {
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->school_type;
        $grade=$this->input->post('grade');
        $classname=$this->input->post('classname');
        $course=$this->input->post('course');
        $where="grade='$grade' and classname='$classname' and title='$course' and schoolid=$schoolid and term=$term and school_type=$school_type";
        $res=$this->timetable_model->get_count($where);
        echo json_encode($res);

    }






































	
}
