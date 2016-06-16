<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

// timetable
include_once 'content_model.php';
    class timetable_model extends content_model {

        function __construct() {
            parent::__construct ();
            $this->table = 'fly_timetable';
        }

        function insert_after_school($insert_class){
            $sql="insert into $this->table() VALUES ()";
        }

        /**
         * @param   $classname  班级（20151）
         * @param   $class_chiname  （一（1））
         * @param   $week       星期几
         * @param   $section     第几节课
         * @param   $title      课程名称
         * @param   $uid        老师id
         * @param   $schoolid   学校id
         */
        function auto_pk($grade,$classname,$week,$section,$title)
        {
            //根据课程名称获取对应的老师
            $schoolid = $this->schoolid;
            $term = $this->session->userdata('term');
            $school_type = $this->school_type;
            $where_teacher="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND course='$title'";
            $teacher=$this->course_plan_model->get_column2("teacher","fly_course_plan",$where_teacher);
            $insert_class= array(
                'grade' => $grade,
                'classname' => $classname,
                'week'=>$week,
                'section'=>$section,
                'title'=>$title,
                'teacher_truename'=>$teacher['teacher'],
                'schoolid'=>$schoolid,
                'term'=>$term,
                'school_type'=>$school_type,
            );
            $this->timetable_model->insert($insert_class);
        }

        /**
         *判断该位置是否已经排有课
         *
         **/
        function timetable_rule1($grade,$classname,$week,$section)
        {
            $schoolid=$this->schoolid;
            $term=$this->session->userdata('term');
            $school_type=$this->school_type;
            $where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND week=$week AND section=$section";
            $num=$this->timetable_model->counts($this->table,$where);
            /*echo "<br/>";
            echo $grade."-".$classname."-"."星期".$week."-第".$section."节排了：".$num."节";
            echo "<br/>";*/
            if($num==0){    //未排有课
                return true;
            }else{          //排有课
                return false;
            }
        }

        /**
         *  判断该位置是否设置禁止排任何科目
         *  返回数组
         **/
        function timetable_rule2($grade,$classname,$week,$section)
        {
            $schoolid=$this->schoolid;
            $term=$this->session->userdata('term');
            $school_type=$this->school_type;
            $where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND week=$week AND section=$section";
            $timetable_rule2_result=$this->rule_model->get_column2("forbid_class","fly_rule",$where);
            /*echo "<br/>";
            echo $grade."-".$classname."-"."星期".$week."-第".$section."节是否设置班级禁排（1或者空表示没设置）:".$timetable_rule2_result['forbid_class'];
            echo "<br/>";*/
            if($timetable_rule2_result['forbid_class']==1||empty($timetable_rule2_result)){   //班级没设置禁课
                return true;
            }else{      //设置禁课
                return false;
            }
        }

        public function fun_continue_times($grade,$classname,$title){
            //判断连堂次数是否小于预设值
            $schoolid=$this->schoolid;
            $term=$this->session->userdata('term');
            $school_type=$this->school_type;
            $where_week_section="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND title='$title' order by id desc";
            $arr_week_section =$this->course_plan_model->get_column("week,section", "fly_timetable", $where_week_section);
            $where_continue_times="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND course='$title'";
            $continue_times=$this->course_plan_model->get_column2("continue_times","fly_course_plan",$where_continue_times);
            $num=count($arr_week_section);
            $times=0;
            foreach($arr_week_section as $key=>$value){
                if($key<($num-1)){
                    if(($arr_week_section[$key]['week']==$arr_week_section[$key+1]['week'])&&($arr_week_section[$key]['section']==$arr_week_section[$key+1]['section']-1)){
                        $times++;
                    }
                }
            }
            /*echo "<br/>";
            echo "<pre>";
            print_r($arr_week_section);
            echo "<pre/>";
            echo "<br/>";
            echo "连堂:（".$grade.$classname."：".$title."||已连堂次数：".$times."||计划连堂次数：".$continue_times['continue_times']."）。";
            echo "<br/>";*/
            if($times<$continue_times['continue_times']){   //已连堂次数小于计划连堂次数
                return true;
            }else{
                return false;
            }
        }

        public function fun_outnumber_two($grade,$classname,$week,$title)
        {
            //查看某个科目，在某一天是否已经排有课（有些科目不允许一天排超过一节）
            $schoolid = $this->schoolid;
            $term = $this->session->userdata('term');
            $school_type = $this->school_type;
            $where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND week='$week' AND title='$title' ";
            $num=$this->timetable_model->counts("fly_timetable",$where );
            /*echo "<br/>";
            echo $grade."-".$classname."-".$title."-"."星期".$week."已排：".$num."节";
            echo "<br/>";*/
            if($num>0){
                return false;   //这一天已经排有课
            }else{  //这一天没排
                return true;
            }
        }

        public function fun_course_full($grade,$classname,$title){
            //根据班级和课程，从数据库里查询，已经排了几节课,计划排几节，并最终判断是否已经排满
            $schoolid = $this->schoolid;
            $term = $this->session->userdata('term');
            $school_type = $this->school_type;
            $where_num="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND title='$title'";
            $minor_num = $this->timetable_model->counts("fly_timetable",$where_num );
            //根据班级和课程，从数据库里查询，计划排几节
            $arr_plan_num = $this->course_plan_model->get_column2("course_num", "fly_course_plan", "grade='$grade' AND classname='$classname' AND course='$title' AND schoolid='$schoolid' AND term='$term' AND school_type='$school_type'");
            /*echo "<br/>";
            echo "比较已排，计划排:（".$grade."-".$classname."-".$title."-"."：".$title."||已排：".$minor_num."||计划排：".$arr_plan_num['course_num']."）。";
            echo "<br/>";*/
            $arr_plan_num = $this->course_plan_model->get_column2("course_num", "fly_course_plan", "grade='$grade' AND classname='$classname' AND course='$title' AND schoolid='$schoolid' AND term='$term' AND school_type='$school_type'");
            if($minor_num <= $arr_plan_num['course_num'] - 1){
                return true;  //未排满
            }else{
                return false;   //已经排满
            }
        }

        public function fun_forbid_teacher($grade,$classname,$week,$section,$title){
            //根据课程名称获取对应的老师
            $schoolid = $this->schoolid;
            $term = $this->session->userdata('term');
            $school_type = $this->school_type;
            $where_teacher="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND course='$title'";
            $teacher=$this->course_plan_model->get_column2("teacher","fly_course_plan",$where_teacher);
            $where_teacher_id="schoolid=$schoolid AND term=$term AND school_type=$school_type AND teacher='$teacher[teacher]'";
            $teacher_id=$this->course_plan_model->get_column2("id","fly_teacher",$where_teacher_id);
            //获取该位置是否设置老师禁排
            $where_forbid_teacher="schoolid=$schoolid AND term=$term AND school_type=$school_type AND week=$week AND section=$section AND forbid_teacher=$teacher_id[id]";
            $result=$this->rule_model->counts("fly_rule",$where_forbid_teacher);//二维数组
            /*echo "<br/>";
            echo "老师是否禁排:（".$grade."-".$classname."-".$title."||"."老师名：".$teacher['teacher']."||该老师在该位置是否禁排（0代表不禁，1代表禁）：".$result."）。";
            echo "<br/>";*/
            if($result==0){
                return true;    //没有设置老师禁排
            }else{
                return false;   //设置老师禁排
            }
        }

        public function fun_same_teacher($grade,$classname,$week,$section,$title){
            //从fly_timetable查看该老师在该位置在其他班级是否已经排有课。
            $schoolid = $this->schoolid;
            $term = $this->session->userdata('term');
            $school_type = $this->school_type;
            $where_teacher="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND course='$title'";
            $teacher=$this->course_plan_model->get_column2("teacher","fly_course_plan",$where_teacher);
            $counts_where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND week=$week AND section=$section AND teacher_truename='$teacher[teacher]'";
            $num=$this->timetable_model->counts("fly_timetable",$counts_where);
            /*echo "<br/>";
            echo "该老师在其他班级是否已安排:（".$grade."-".$classname."-".$title."||"."老师名：".$teacher['teacher']."||已安排".$num."节）。";
            echo "<br/>";*/
            if($num==0){
                return true;//该老师在该位置在其他班级没排有课
            }else{
                return false;//该老师在该位置在其他班级排有课
            }
        }

        public function fun_forbid_course($grade,$classname,$week,$section,$title){
            //获取该位置是否设置该课程禁排
            $schoolid = $this->schoolid;
            $term = $this->session->userdata('term');
            $school_type = $this->school_type;
            $where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND week=$week AND section=$section";
            $forbid_course=$this->rule_model->get_column("forbid_course","fly_rule",$where);
            /*echo "<br/>";
            echo "查看是否有禁排课程：（".$grade."-".$classname."-".$title."-"."禁排科目名称：".$forbid_course['forbid_course']."）。";
            echo "<br/>";*/
            $flag='';
            foreach($forbid_course as $key=>$value){
                if($title!=$value['forbid_course']){  //该位置没有设置该课程禁排
                    $flag=1;
                    //return true;
                }else{
                    $flag=0;
                    break;
                    //return false;   //该位置设置该课程禁排
                }
            }
            if(empty($forbid_course)){
                return true;
            }else{
                return $flag;
            }

        }

        public function fun_course_num($grade,$classname,$title){
            //根据班级和课程，从数据库里查询，已经排了几节课,计划排几节，并最终判断是否已经排满
            $schoolid = $this->schoolid;
            $term = $this->session->userdata('term');
            $school_type = $this->school_type;
            $where_num="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND title='$title'";
            $minor_num = $this->timetable_model->counts("fly_timetable",$where_num );
            //根据班级和课程，从数据库里查询，计划排几节
            $arr_plan_num = $this->course_plan_model->get_column2("course_num", "fly_course_plan", "grade='$grade' AND classname='$classname' AND course='$title' AND schoolid='$schoolid' AND term='$term' AND school_type='$school_type'");
            if($minor_num == $arr_plan_num['course_num']){  //已排满
                /*echo "<br/>";
                echo "插入数据库后，已排满：（".$grade.$classname."：".$title."||已排：".$minor_num."||计划排：".($arr_plan_num['course_num'])."）。";
                echo "<br/>";*/
                return true;
            }else{  //未排满
                /*echo "<br/>";
                echo "插入数据库后，未排满：（".$grade.$classname."：".$title."||已排：".$minor_num."||计划排：".($arr_plan_num['course_num'])."）。";
                echo "<br/>";*/
                return false;
            }
        }

        public function fun_teach_reasonable($grade,$classname,$major,$week){
            $schoolid = $this->schoolid;
            $term = $this->session->userdata('term');
            $school_type = $this->school_type;
            //计算该科目对应的老师每天排课数的范围
            $a=count($this->session->userdata('week2'));   //计算一周上天课
            $t=ceil($major['teach_total']/$a)+3;           //教师每天排课数不超过$t
            //统计该天该老师已经安排了多少节课
            $where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND teacher_truename='$major[teacher]' AND week=$week";
            $num=$this->timetable_model->counts("fly_timetable",$where);
            /*echo "<br/>";
            echo $grade."-".$classname."-".$major['course']."-".$major['teacher']."星期".$week."：(已经排了:".$num."节,最多不安排超过：".$t."节）。";
            echo "<br/>";*/
            if($num<$t){
                return true;
            }else{
                return false;
            }

        }

        public function fun_week($major){
            $schoolid = $this->schoolid;
            $term = $this->session->userdata('term');
            $school_type = $this->school_type;
            $week=$this->session->userdata('week2');
            foreach($week as $value){
                $where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND teacher_truename='$major[teacher]' AND week=$value";
                $res[$value]=$this->timetable_model->counts("fly_timetable",$where);
            }
            //升序排序
            asort($res);
            /*echo "<pre>";
            print_r($res);
            echo "<pre/>";*/
            foreach($res as $res_key=>$res_value){
                $result[]=$res_key;
            }
            return $result;
        }

        public function fun_section($minor){
            $section=$this->session->userdata('section2');
            //判断主科还是副科
            global $section_first;
            global $section_second;
            if($minor['course_num']>4){
                switch(count($section)){
                    case 5:
                        $section_first=array(1,2,3);
                        $section_second=array(4,5);
                        break;
                    case 6:
                        $section_first=array(1,2,3,4);
                        $section_second=array(5,6);
                        break;
                    case 7:
                        $section_first=array(1,2,3,4);
                        $section_second=array(5,6,7);
                        break;
                    case 8://主科先排上午1-5节
                        $section_first=array(1,2,3,4,5);
                        $section_second=array(6,7,8);
                        break;
                    case 9:
                        $section_first=array(1,2,3,4,5,6);
                        $section_second=array(7,8,9);
                        break;
                    default:
                        $section_first=array(1,2,3,4,5,6,7);
                        $section_second=array(8,9,10,11,12);
                }
            }else{
                switch(count($section)){
                    case 5:
                        $section_second=array(1,2);
                        $section_first=array(3,4,5);
                        break;
                    case 6:
                        $section_second=array(1,2);
                        $section_first=array(3,4,5,6);
                        break;
                    case 7:
                        $section_second=array(1,2);
                        $section_first=array(3,4,5,6,7);
                        break;
                    case 8:
                        $section_second=array(1,2);
                        $section_first=array(3,4,5,6,7,8);
                        break;
                    case 9:
                        $section_second=array(1,2);
                        $section_first=array(3,4,5,6,7,8,9);
                        break;
                    default:
                        $section_second=array(1,2);
                        $section_first=array(3,4,5,6,7,8,9,10,11,12);
                }
            }

        }

        //主科排课
        public function major_paike($grade,$classname,$major){
            //判断主科是否有连堂
            if($major['continue_times']>0){ //有连堂
                //判断连堂次数是否已满
                $continue_times_result=$this->fun_continue_times($grade,$classname,$major['course']);
                if($continue_times_result){
                    //连堂次数未满，开始排连堂课
                    return $this->fun_double($grade,$classname,$major);
                }
            }else{
                return $this->minor_paike($grade,$classname,$major);
            }
        }

        public function minor_paike($grade,$classname,$minor){
            /*echo $minor['course']."不是连堂科目：";*/
            $week_arr=$this->fun_week($minor);
            $this->fun_section($minor);
            $section_arr=$GLOBALS['section_first'];
            /*echo "<pre>";
            print_r($week_arr);
            print_r($section_arr);
            echo "<pre/>";*/
            static $cycle_fun_mimor_paike;
            $cycle_fun_mimor_paike=0;
            return $this->fun_minor_paike($grade,$classname,$minor,$week_arr,$section_arr,$cycle_fun_mimor_paike);
        }

        public function fun_minor_paike($grade,$classname,$minor,$week_arr,$section_arr,$cycle_fun_mimor_paike){
            $cycle_fun_mimor_paike++;
            foreach($week_arr as $week_key=>$week_value){
                shuffle($section_arr);
                foreach($section_arr as $section_key=>$section_value){
                    /* echo "<br/>";
                     * echo "不是连堂科目，获取的星期和节次：星期".$week_value."-第".$section_value."节";
                     * echo "<br/>";
                     * */
                    //判断该课程，该课程对应的教师，该位置是否设置禁排等规则
                    $rule_all_result=$this->rule_all($grade,$classname,$minor['course'],$week_value,$section_value,$minor);
                    if($rule_all_result){
                        //插入数据库
                        /*echo $grade."-".$classname."-".$week_value."-".$section_value."-".$minor['course']."准备插入数据库(不是连堂科目)。";
                        echo "<br/>";*/
                        $this->auto_pk($grade,$classname,$week_value,$section_value,$minor['course']);
                        $course_num=$this->fun_course_num($grade,$classname,$minor['course']);
                        if($course_num){
                            //这门科目已经排满
                            return true;
                        }else{
                            //未排满
                            if($week_value==end($week_arr)){  //最后一个位置
                                if($cycle_fun_mimor_paike==2){
                                    /*echo "<br/>";
                                    echo "已经排到最后一节，开始调课：";
                                    echo "<br/>";*/
                                    $cycle_fun_mimor_paike=0;
                                    $adjust_result=$this->fun_adjust($grade,$classname);
                                    /*echo "已排课程排序后的数组：";
                                    echo "<pre>";
                                    print_r($adjust_result);
                                    echo "<pre/>";*/
                                    return $this->fun_adjust_paike($grade,$classname,$minor,$adjust_result);
                                }else{
                                    $section_arr=$GLOBALS['section_second'];
                                    return $this->fun_minor_paike($grade,$classname,$minor,$week_arr,$section_arr,$cycle_fun_mimor_paike);
                                }
                            }else{
                                continue 2;
                            }
                        }
                    }else{  //不满足条件
                        //判断是否所有位置都不合适，调课
                        if($section_value==end($section_arr)&&$week_value==end($week_arr)){  //最后一个位置
                            if($cycle_fun_mimor_paike==2){
                                /*echo "<br/>";
                                echo "已经排到最后一节，开始调课：";
                                echo "<br/>";*/
                                $cycle_fun_mimor_paike=0;
                                $adjust_result=$this->fun_adjust($grade,$classname);
                                /*echo "已排课程排序后的数组：";
                                echo "<pre>";
                                print_r($adjust_result);
                                echo "<pre/>";*/
                                return $this->fun_adjust_paike($grade,$classname,$minor,$adjust_result);
                            }else{
                                $section_arr=$GLOBALS['section_second'];
                                return $this->fun_minor_paike($grade,$classname,$minor,$week_arr,$section_arr,$cycle_fun_mimor_paike);
                            }
                        }
                    }
                }
            }
        }

        public function fun_adjust_paike($grade,$classname,$minor,$adjust_result){
            foreach($adjust_result as $adjust_key=>$adjust_value){
                /*echo "目前调换的课程是：".$adjust_value['title']."||总的已排课程数".count($adjust_result)."||键名：".$adjust_key;
                echo "<br/>";*/
                //判断该课程，该课程对应的教师，该位置是否设置禁排等规则
                $rule_all_result1=$this->rule_all2($grade,$classname,$minor['course'],$adjust_value['week'],$adjust_value['section'],$minor);
                if($rule_all_result1){
                    /*echo "找到的合适的调课位置：";
                    echo "<pre>";
                    print_r($adjust_value);
                    echo "<pre/>";*/
                    $schoolid = $this->schoolid;
                    $term = $this->session->userdata('term');
                    $school_type = $this->school_type;
                    $where_delete=array(
                        "schoolid"=>$schoolid ,
                        "term"=>$term ,
                        "school_type"=>$school_type ,
                        "grade"=>"$grade" ,
                        "classname"=>"$classname",
                        "week"=>"$adjust_value[week]",
                        "section"=>"$adjust_value[section]"
                    );
                    //给被调的这门课，重新找位置排，如果能排上，则调换，不能循环下一门
                    $course_num2=$this->rand_insert_course($grade,$classname,$adjust_value['title'],$adjust_value['week'],$minor);
                    if($course_num2){
                        /*echo $grade."-".$classname."-".$adjust_value['week']."-".$adjust_value['section']."-".$minor['course']."调课插入(不是连堂科目)。";
                        echo "<br/>";*/
                        $this->timetable_model->db_delete2("fly_timetable",$where_delete);
                        $this->timetable_model->auto_pk($grade,$classname,$adjust_value['week'],$adjust_value['section'],$minor['course']);
                        $course_num1=$this->fun_course_num($grade,$classname,$minor['course']);
                        if($course_num2&&$course_num1){
                            return true;
                        }
                    }else{
                        if($adjust_key==count($adjust_result)-1){   //循环到最后一个也无法满足调课
                            //重新排整个班级
                            return $GLOBALS['again_flag']=true;
                        }
                    }
                }
                if($adjust_key==count($adjust_result)-1){   //循环到最后一个也无法满足调课
                    //重新排整个班级
                    return $GLOBALS['again_flag']=true;
                }
            }
        }

        public function fun_double($grade,$classname,$major){
            //循环次数
            static $cycle_index;
            $cycle_index=0;
            global $time_am;
            $time_am='';
            $i=0;
            $section=$this->session->userdata('section2');
            switch(count($section)){
                case 5:
                    $section_arr_double_am=array(2,2,3);
                    $section_arr_double_pm=array(5);
                    break;
                case 6:
                    $section_arr_double_am=array(2,2,2,3,4);
                    $section_arr_double_pm=array(6);
                    break;
                case 7:
                    $section_arr_double_am=array(2,2,2,3,4);
                    $section_arr_double_pm=array(6,6,7);
                    break;
                case 8:
                    $section_arr_double_am=array(2,2,2,3,4,5);
                    $section_arr_double_pm=array(7,7,8);
                    break;
                default:
                    $section_arr_double_am=array(2,2,2,3,4,5);
                    $section_arr_double_pm=array(7,7,8,9);
            }

            $week_arr_double_am=$this->session->userdata('week2');
            foreach($section_arr_double_am as $section_value){
                foreach($week_arr_double_am as $week_value){
                    $time_am[$i]['section']=$section_value;
                    $time_am[$i]['week']=$week_value;
                    $i++;
                }
            }
            global $time_pm;
            $time_pm='';
            $j=0;
            $week_arr_double_pm=$this->session->userdata('week2');
            foreach($section_arr_double_pm as $section_value){
                foreach($week_arr_double_pm as $week_value){
                    $time_pm[$j]['section']=$section_value;
                    $time_pm[$j]['week']=$week_value;
                    $j++;
                }
            }
            shuffle($time_am);
            shuffle($time_pm);
            $time_am_arr=$GLOBALS['time_am'];
            $this->fun_double_paike($grade,$classname,$major,$time_am_arr,$cycle_index);
        }

        public function fun_double_paike($grade,$classname,$major,$time_am_arr,$cycle_index){
            foreach($time_am_arr as $time_am_key=>$time_am_value){
                //每循环一次，自增1；如果循环完上下午两个数组都没排完，则重新排过
                $cycle_index++;
                /*echo "循环次数：".$cycle_index;
                echo "<br/>";*/
                if($cycle_index==count($GLOBALS['time_am'])+count($GLOBALS['time_pm'])){
                    /*echo "进入重排程序：";
                    echo "<br/>";*/
                    //先删除
                    $term=$this->session->userdata('term');
                    $school_type=$this->school_type;
                    $sql="delete from fly_timetable WHERE schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND title='$major[course]' AND title_flag=0";
                    $query = $this->db->query($sql);
                    //重排
                    /*$cycle_index=0;
                    $time_am_arr=$GLOBALS['time_am'];
                    $time_pm_arr=$GLOBALS['time_pm'];*/
                    return $this->fun_double($grade,$classname,$major);
                }else{
                    $week=$time_am_value['week'];  //随机获取”星期“
                    $section=$time_am_value['section'];    //随机获取”节次“
                    /*echo "<br/>";
                    echo "随机获取的星期和节次："."星期".$week."-"."第".$section."节";
                    echo "<br/>";*/
                    //判断该课程，该课程对应的教师，该位置是否设置禁排等规则
                    /*echo "判断这节课的规则情况：";
                    echo "<br/>";*/
                    $rule_all_result1=$this->rule_all($grade,$classname,$major['course'],$week,$section,$major);
                    $before_section=$section-1;
                    /*echo "判断上节课的规则情况：";
                    echo "<br/>";*/
                    $rule_all_result2=$this->rule_all($grade,$classname,$major['course'],$week,$before_section,$major);
                    if($rule_all_result1&&$rule_all_result2){
                        //都满足要求情况下，将该课程放入这两个位置
                        /*echo $grade."-".$classname."-".$week."-".$section."-".$major['course']."准备插入数据库(连堂)";
                        echo "<br/>";*/
                        $this->auto_pk($grade,$classname,$week,$section,$major['course']);
                        $this->auto_pk($grade,$classname,$week,$section-1,$major['course']);
                        //判断连堂次数是否已满
                        $continue_times_result=$this->fun_continue_times($grade,$classname,$major['course']);
                        if(!$continue_times_result){ //连堂次数已满
                            //判断这门科目是否已经排完
                            $course_num_result=$this->fun_course_num($grade,$classname,$major['course']);
                            if(!$course_num_result){
                                return $this->minor_paike($grade,$classname,$major);
                            }else{  //这门科目已经全部排完,返回
                                return true;
                            }
                        }else{
                            if($time_am_key==count($time_am_arr)-1){
                                $time_am_arr=$GLOBALS['time_pm'];
                                return $this->fun_double_paike($grade,$classname,$major,$time_am_arr,$cycle_index);
                            }
                        }
                    }else{
                        if($time_am_key==count($time_am_arr)-1){
                            $time_am_arr=$GLOBALS['time_pm'];
                            return $this->fun_double_paike($grade,$classname,$major,$time_am_arr,$cycle_index);
                        }
                    }
                }
            }
        }

        //判断某个科目，在某个位置是否允许排课
        public function rule_all($grade,$classname,$title,$week,$section,$major){
            $timetable_rule1_result=$this->timetable_rule1($grade,$classname,$week,$section);//①判断该位置是否已经排有课
            if($timetable_rule1_result){
                $same_teacher_result=$this->fun_same_teacher($grade,$classname,$week,$section,$title);  //④判断该老师是否已经在其他班在相同位置已经有课
                if($same_teacher_result){
                    $teach_reasonable_result=$this->fun_teach_reasonable($grade,$classname,$major,$week);//⑦统计该老师这一天已经排了多少节，是否超过设定范围
                    if($teach_reasonable_result=1){
                        $outnumber_two_result=$this->fun_outnumber_two($grade,$classname,$week,$title); //⑥查看这个班这一天是否已经排有这门科目（预防出现连堂）
                        if($outnumber_two_result){
                            $timetable_rule2_result=$this->timetable_rule2($grade,$classname,$week, $section);// ②判断该位置是否设置禁排任何科目
                            if($timetable_rule2_result){
                                $forbid_course_result=$this->fun_forbid_course($grade,$classname,$week,$section,$title);//⑤该位置是否设置禁止排这门科目
                                if($forbid_course_result){
                                    $forbid_teacher_result=$this->fun_forbid_teacher($grade,$classname,$week,$section,$title);  //③判断该科目对应的老师在这个位置是否禁排
                                    if($forbid_teacher_result){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }else{
                                    return false;
                                }
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        //判断某个科目，在某个位置是否允许排课
        public function rule_all2($grade,$classname,$title,$week,$section,$major){
            $same_teacher_result=$this->fun_same_teacher($grade,$classname,$week,$section,$title);  //④判断该老师是否已经在其他班在相同位置已经有课
            if($same_teacher_result){
                $outnumber_two_result=$this->fun_outnumber_two($grade,$classname,$week,$title); //⑥查看这一天是否已经排有这门科目（预防一天排同一科目过多）
                if($outnumber_two_result){
                    $forbid_course_result=$this->fun_forbid_course($grade,$classname,$week,$section,$title);    //⑤该位置是否设置禁止排这门科目
                    if($forbid_course_result){
                        $forbid_teacher_result=$this->fun_forbid_teacher($grade,$classname,$week,$section,$title);  //③判断该科目对应的老师在这个位置是否禁排
                        if($forbid_teacher_result){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        //判断某个科目，在某个位置是否允许排课
        public function rule_all3($grade,$classname,$title,$week,$section){
            $timetable_rule1_result=$this->timetable_rule1($grade,$classname,$week,$section);//①判断该位置是否已经排有课
            if($timetable_rule1_result){
                $same_teacher_result=$this->fun_same_teacher($grade,$classname,$week,$section,$title);  //④判断该老师是否已经在其他班在相同位置已经有课
                if($same_teacher_result){
                    $timetable_rule2_result=$this->timetable_rule2($grade,$classname,$week, $section);// ②判断该位置是否设置禁排任何科目
                    if($timetable_rule2_result){
                        $forbid_course_result=$this->fun_forbid_course($grade,$classname,$week,$section,$title);    //⑤该位置是否设置禁止排这门科目
                        if($forbid_course_result){
                            $forbid_teacher_result=$this->fun_forbid_teacher($grade,$classname,$week,$section,$title);  //③判断该科目对应的老师在这个位置是否禁排
                            if($forbid_teacher_result){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public function fun_adjust($grade,$classname){
            $schoolid = $this->schoolid;
            $term = $this->session->userdata('term');
            $school_type = $this->school_type;
            $where="schoolid=$schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND title_flag!=1";
            $result=$this->timetable_model->get_column("week,section,title,teacher_truename","fly_timetable",$where);
            //依次从课程数组中取出每个课程对应的老师，并从fly_course_plan表里面统计出该老师一共教几个班
            unset($teach_class_num_result);
            foreach($result as $key=>$value){
                $teach_class_num="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND teacher='$value[teacher_truename]' ";
                $teach_class_num_result[] =$this->course_plan_model->get_column("grade,classname,teacher","fly_course_plan",$teach_class_num);
            }
            foreach($teach_class_num_result as $key=>$value){
                foreach($value as $k=>$val){
                    $temp[$key][]=$val['grade'].$val['classname'];
                }
            }
            foreach($result as $key=>$value){
                $result[$key]['teach_class_num']=count(array_unique($temp[$key]));
                $course_num_where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND course='$value[title]'";
                $course_num_result=$this->course_plan_model->get_column2("course_num","fly_course_plan",$course_num_where);
                $result[$key]['course_num']=$course_num_result['course_num'];
            }
            //优先级排序
            foreach($result as $key=>$value){
                if($value['course_num']>3){  //认定为主科
                    $arr_temp_1[]=$value;
                }else{                      //副科
                    $arr_temp_2[]=$value;
                }
            }
            if(!empty($arr_temp_2)){
                $arr_temp_2=array_sort($arr_temp_2,"teach_class_num",$sort="SORT_ASC");//按教师授课班级数从低到高排
            }
            //合并为一个数组
            unset($adjust_arr);
            $adjust_arr=array();
            if(!empty($arr_temp_2)){
                foreach($arr_temp_2 as $key=>$value){
                    $adjust_arr[]=$value;
                }
            }
            if(!empty($arr_temp_1)){
                foreach($arr_temp_1 as $key=>$value){
                    $adjust_arr[]=$value;
                }
            }
            return $adjust_arr;
        }

        //给排好的课，重新找个位置排（调课）
        public function rand_insert_course($grade,$classname,$title,$week,$major){
            $section_arr=$this->session->userdata('section2');
            $week_arr=$this->session->userdata('week2');
            foreach($section_arr as $section_key=>$section_value){
                foreach($week_arr as $week_key=>$week_value){
                    //判断该课程，该课程对应的教师，该位置是否设置禁排等规则
                    /*echo "已排的课被调换后，重新找位置判断规则：";
                    echo "<br/>";
                    echo "被调的星期为：".$week."||当前星期为：".$week_value;
                    echo "<br/>";*/
                    if($week_value==$week){
                        $rule_all_result=$this->rule_all3($grade,$classname,$title,$week_value,$section_value);
                    }else{
                        $rule_all_result=$this->rule_all($grade,$classname,$title,$week_value,$section_value,$major);
                    }
                    if($rule_all_result){
                        //插入数据库
                        /*echo $grade."-".$classname."-".$week_value."-".$section_value."-".$title."（已排的课被调换后，准备插入）";
                        echo "<br/>";*/
                        $this->auto_pk($grade,$classname,$week_value,$section_value,$title);
                        return true;
                    }/*else{
                        //判断是否达到数组最后一个元素，如达到最后一个元素则说明调课失败，返回false
                        if($section_value==end($section_arr)&&$week_value==end($week_arr)){
                            return false;
                        }
                    }*/
                }
            }
        }

        public function delete_class($grade,$classname){
            //先删除当前整个班级所有已经排的课程
            $GLOBALS['again_flag']=false;
            $term=$this->session->userdata('term');
            $school_type=$this->school_type;
            $sql="delete from fly_timetable WHERE schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND title_flag=0";
            $query = $this->db->query($sql);
           /* echo "删除：".$grade.$classname."所有排的课程，从当前班级重新开始排。";
            echo "<br/>";*/
        }

        public function delete_grade($grade){
            //删除整个年级已经排的课，从一年级开始排起。
            $GLOBALS['cycle_table_all']=0;
            /*echo "删除整个年级课程，全部循环次数：".$GLOBALS['cycle'];
            echo "<br/>";*/
            $term=$this->session->userdata('term');
            $school_type=$this->school_type;
            $sql="delete from fly_timetable WHERE schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND title_flag=0";
            $query = $this->db->query($sql);
        }

        public function move_timetable($grade,$classname,$week,$section,$course){
            $schoolid=$this->schoolid;
            $term=$this->session->userdata('term');
            $school_type=$this->school_type;
            //根据年级，班级获取已排的所有课程
            $arr_adjust_where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND title_flag=0";
            $arr_adjust=$this->timetable_model->get_column("week,section,title,teacher_truename","fly_timetable",$arr_adjust_where);

            foreach($arr_adjust as $key=>$value){
                if($week==$value['week']){
                    $move_timetable_rule_result=$this->move_timetable_rule2($grade,$classname,$course,$value['week'],$value['section']);
                    if($move_timetable_rule_result){//找到可安排的位置，但是未必可以对调
                        if(empty($value['title'])){ //如果找到的位置是空的，没排有课，则可放入“直接对调数组”
                            $result[$key]['week']=$value['week'];
                            $result[$key]['section']=$value['section'];
                        }else{
                            $result_half[$key]['week']=$value['week'];
                            $result_half[$key]['section']=$value['section'];
                            $res1=$this->move_timetable_rule2($grade,$classname,$value['title'],$week,$section);
                            if($res1){
                                $result[$key]['week']=$value['week'];
                                $result[$key]['section']=$value['section'];
                                unset($result_half[$key]);//如果满足直接对调条件，注销
                            }
                        }
                    }
                }else{
                    $move_timetable_rule_result=$this->move_timetable_rule1($grade,$classname,$course,$value['week'],$value['section']);
                    if($move_timetable_rule_result){//找到可安排的位置，但是未必可以对调
                        if(empty($value['title'])){ //如果找到的位置是空的，没排有课，则可放入“直接对调数组”
                            $result[$key]['week']=$value['week'];
                            $result[$key]['section']=$value['section'];
                        }else{
                            $result_half[$key]['week']=$value['week'];
                            $result_half[$key]['section']=$value['section'];
                            $res2=$this->move_timetable_rule1($grade,$classname,$value['title'],$week,$section);
                            if($res2){
                                $result[$key]['week']=$value['week'];
                                $result[$key]['section']=$value['section'];
                                unset($result_half[$key]);//如何满足直接对调条件，注销
                            }
                        }
                    }
                }
            }
            $result_all[0]=$result;
            $result_all[1]=$result_half;
            return $result_all;
        }

        public function temporary_move_timetable($grade,$classname,$course){
            $schoolid=$this->schoolid;
            $term=$this->session->userdata('term');
            $school_type=$this->school_type;
            //根据年级，班级获取已排的所有课程
            $arr_adjust_where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type AND grade='$grade' AND classname='$classname' AND title_flag=0";
            $arr_adjust=$this->timetable_model->get_column("week,section,title,teacher_truename","fly_timetable",$arr_adjust_where);
            foreach($arr_adjust as $key=>$value){
                $move_timetable_rule_result=$this->move_timetable_rule1($grade,$classname,$course,$value['week'],$value['section']);
                if($move_timetable_rule_result){    //找到可安排的位置
                    $result[$key]['week']=$value['week'];
                    $result[$key]['section']=$value['section'];
                }
            }
            return $result;

        }


        public function move_timetable_rule1($grade,$classname,$title,$week,$section){
            $same_teacher_result=$this->fun_same_teacher($grade,$classname,$week,$section,$title);  //④判断该老师是否已经在其他班在相同位置已经有课
            if($same_teacher_result){
                $outnumber_two_result=$this->fun_outnumber_two($grade,$classname,$week,$title); //⑥查看这一天是否已经排有这门科目（预防一天排同一科目过多）
                if($outnumber_two_result){
                    $forbid_course_result=$this->fun_forbid_course($grade,$classname,$week,$section,$title);    //⑤该位置是否设置禁止排这门科目
                    if($forbid_course_result){
                        $forbid_teacher_result=$this->fun_forbid_teacher($grade,$classname,$week,$section,$title);  //③判断该科目对应的老师在这个位置是否禁排
                        if($forbid_teacher_result){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public function move_timetable_rule2($grade,$classname,$title,$week,$section){
            $same_teacher_result=$this->fun_same_teacher($grade,$classname,$week,$section,$title);  //④判断该老师是否已经在其他班在相同位置已经有课
            if($same_teacher_result){
                $forbid_course_result=$this->fun_forbid_course($grade,$classname,$week,$section,$title);    //⑤该位置是否设置禁止排这门科目
                if($forbid_course_result){
                    $forbid_teacher_result=$this->fun_forbid_teacher($grade,$classname,$week,$section,$title);  //③判断该科目对应的老师在这个位置是否禁排
                    if($forbid_teacher_result){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }



































    }
