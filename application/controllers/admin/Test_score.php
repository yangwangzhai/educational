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
class Test_score extends Content
{

    function __construct ()
    {
        $class_name = 'test_score';
        $this->name = '学生成绩';
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=test_score'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('test_score_model');
        $this->load->model('test_list_model');
        $this->load->model('student_model');
        $this->load->model('classroom_model');
        $this->load->model('timetable/content_model');
    }

    // 首页
    public function index() {
        $searchsql = "1 AND a.schoolid=$this->schoolid";

        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';

        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode ( $keywords );
            $searchsql .= " AND b.name like '%{$keywords}%' ";
        }

        $data ['list'] = array ();
        $count = $this->test_score_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->test_score_model->get_score($searchsql,$offset,20);
        $list=$this->classroom_model->append_list($list);
        $exam_type=$this->config->item('exam_type');
        $subject=$this->config->item('subject');
        $semester=$this->config->item('semester');
        foreach($list as &$item)
        {
            $item['exam_type']=$exam_type[$item['exam_type']];
            $item['subject']=$subject[$item['subject']];
            $item['semester']=$semester[$item['semester']];
        }
        $data ['list'] = $list;

        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view ( 'admin/' . $this->list_view, $data );
    }
    /**
     * 添加
     *
     */
    public function add()
    {
        $data['exam_type']=$this->config->item('exam_type');
        $data['subject']=$this->config->item('subject');
        $data['semester']=$this->config->item('semester');
        $this->load->view ( 'admin/' . $this->add_view,$data );
    }
    /**
     * 编辑
     */
    public function edit ()
    {
        $data['exam_type']=$this->config->item('exam_type');
        $data['subject']=$this->config->item('subject');
        $data['semester']=$this->config->item('semester');
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->test_score_model->get_one($id);
        $student=$this->student_model->get_one($value['studentid']);
        $value['studentname']=$student['name'];
        $value['classid']=$student['classid'];
        $value=$this->classroom_model->append_item($value);

        $value['addtime']=times($value['addtime']);
        $data['value']=$value;
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
        if ($data ['studentid'] == "") {
            show_msg ( '学生不能为空' );
        }
        if ($data ['score'] == "" || !is_numeric($data ['score'])) {
            show_msg ( '考试成绩不能为空或者格式不对' );
        }
        if ($data ['pubdate'] == "") {
            show_msg ( '考试时间不能为空' );
        }
        if ($id) { // 修改 ===========
            $this->test_score_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $this->test_score_model->insert($data);

            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }

    public function statistic_list(){
        $grade=$this->input->get('grade');
        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $total_rows=$this->test_list_model->count_test_list("grade=$grade");
        $pagination['total_rows'] =$total_rows;
        $pagination['base_url'] = $this->baseurl;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('per_page') ? intval($this->input->get('per_page')) : 0;
        $data['list'] = $this->test_list_model->get_list('*',"grade=$grade",$offset,10);

        $this->load->view('admin/test_list', $data);
    }

    public function test_add(){
        $this->load->view('admin/test_add');
    }

    public function test_edit(){
        $id=$this->input->get('id');
        $data['list']=$this->test_list_model->get_column2("id,test_name,grade,date,thumb","fly_test_list","id=$id");
        $this->load->view('admin/test_add',$data);
    }

    public function test_save(){
        $id=$this->input->post('id');
        $value['test_name']=$this->input->post('test_name');
        $value['grade']=$this->input->post('grade');
        $value['date']=$this->input->post('date');
        $value['thumb']=$this->input->post('thumb');
        if(empty($id)){
            //插入
            $insert_id=$this->test_list_model->db_insert_table("fly_test_list",$value);
            $PHPReader=new PHPExcel_Reader_Excel2007();
            //为了可以读取所有版本Excel文件
            if(!$PHPReader->canRead($value['thumb']))
            {
                $PHPReader = new PHPExcel_Reader_Excel5();
                if(!$PHPReader->canRead($value['thumb']))
                {
                    echo '未发现Excel文件！';
                    return;
                }
            }
            //读取Excel文件
            $PHPExcel = $PHPReader->load($value['thumb']);
            //统计一个excel有多少个工作表
            $sheetCount = $PHPExcel->getSheetCount();
            //创建 Reader
            $excel = new Spreadsheet_Excel_Reader();
            //设置文本输出编码
            $excel->setOutputEncoding('utf-8');
            //读取Excel文件
            $excel->read($value['thumb']);
            $i=0;
            for($i;$i<$sheetCount;$i++){
                $data=$excel->sheets[$i]['cells'];
                foreach($data as $key=>$value){
                    if($key>1){
                        $insert_data['id']=$insert_id;
                        $insert_data['classname']=trim($value[1]."班");
                        $insert_data['student']=trim($value[2]);
                        $insert_data['subject']=trim($data[1][3]);
                        $insert_data['score']=$value[3];
                        $this->test_list_model->db_insert_table("fly_student_score",$insert_data);
                    }
                }
            }

        }else{
            $this->test_list_model->db_update_table("fly_test_list",$value,$id);
            $delete_arr['id']=$id;
            $this->test_list_model->db_delete2("fly_student_score",$delete_arr);
            $PHPReader=new PHPExcel_Reader_Excel2007();
            //为了可以读取所有版本Excel文件
            if(!$PHPReader->canRead($value['thumb']))
            {
                $PHPReader = new PHPExcel_Reader_Excel5();
                if(!$PHPReader->canRead($value['thumb']))
                {
                    echo '未发现Excel文件！';
                    return;
                }
            }
            //读取Excel文件
            $PHPExcel = $PHPReader->load($value['thumb']);
            //统计一个excel有多少个工作表
            $sheetCount = $PHPExcel->getSheetCount();
            //创建 Reader
            $excel = new Spreadsheet_Excel_Reader();
            //设置文本输出编码
            $excel->setOutputEncoding('utf-8');
            //读取Excel文件
            $excel->read($value['thumb']);
            $i=0;
            for($i;$i<$sheetCount;$i++){
                $data=$excel->sheets[$i]['cells'];
                foreach($data as $key=>$value){
                    if($key>1){
                        $insert_data['id']=$id;
                        $insert_data['classname']=$value[1]."班";
                        $insert_data['student']=$value[2];
                        $insert_data['subject']=$data[1][3];
                        $insert_data['score']=$value[3];
                        $this->test_list_model->db_insert_table("fly_student_score",$insert_data);
                    }
                }
            }
        }

    }

    public function test_delete(){
        $delete['id']=$this->input->get('id');
        $this->test_list_model->db_delete2("fly_test_list",$delete);
        $this->test_list_model->db_delete2("fly_student_score",$delete);
        $this->test_list_model->db_delete2("fly_score_rank",$delete);
        $this->statistic_list();
    }

    public function statistic_rank(){
        //加一个判断，是否已经分析过
        $id=$this->input->post('id');
        $falg=$this->test_list_model->get_column2("analysis_flag","fly_test_list","id=$id");
        if($falg['analysis_flag']){
            $ajax_result="已分析";
            echo $ajax_result;
            exit;
            //show_msg ( '已分析，去查看结果吧！', $this->baseurl."&m=statistic_list" );
        }else{
            //取出所有班级
            $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
            $classname_unique=unique($classname_arr);
            //取出所有科目
            $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
            $subject_unique=unique($subject_arr);
            //取出所有学生
            foreach($classname_unique as $classname_key=>$classname){
                foreach($subject_unique as $subject_unique_key=>$subject_unique_value){
                    $where="id=$id AND classname='$classname' AND subject='$subject_unique_value'";
                    $res[$subject_unique_key]=$this->test_list_model->get_column("student","fly_student_score",$where);
                }
                foreach($res as $key=>$value){
                    foreach($value as $k=>$val){
                        $student_temp[]=$val['student'];
                    }
                }
                $student_arr=array_unique($student_temp);

                foreach($student_arr as $key=>$value){
                    $student[$key]=array();
                    $student[$key]['student']=$value;
                    $student[$key]['score']=array();
                    foreach($subject_unique as $subject_value){
                        $where_score="id=$id AND subject='$subject_value' AND student='$value'";
                        $result=$this->test_list_model->get_column2("classname,score","fly_student_score",$where_score);
                        $student[$key]['score'][$subject_value]=$result['score'];
                        $student[$key]['classname']=$result['classname'];
                    }
                }
                $temp=array();
                foreach($student as $key=>$value){
                    $student[$key]['score']['total_score']=array_sum($value['score']);
                    $temp[$key]=array_sum($value['score']);
                }
                array_multisort($temp,SORT_DESC,$student);
                foreach($student as $student_key=>$student_value){
                    $insert_data['id']=$id;
                    $insert_data['classname']=$classname;
                    $insert_data['student']=$student_value['student'];
                    $insert_data['total_score']=$student_value['score']['total_score'];
                    $insert_data['class_rank']=$student_key+1;
                    $this->test_list_model->db_insert_table("fly_score_rank",$insert_data);
                }
                unset($student);
                unset($temp);
                unset($student_arr);
                unset($student_temp);

            }
            //计算年级排名，并存入数据库
            $result_rank=$this->test_list_model->get_column("classname,student","fly_score_rank","id=$id order by total_score desc");
            foreach($result_rank as $result_rank_key=>$result_rank_value){
                $update_where['classname']=$result_rank_value['classname'];
                $update_where['student']=$result_rank_value['student'];
                $update_where['id']=$id;
                $update['grade_rank']=$result_rank_key+1;
                $this->test_list_model->db_update_table("fly_score_rank",$update,$update_where);
            }
            $update_flag['analysis_flag']=1;
            $update_where_flag['id']=$id;
            $this->test_list_model->db_update_table("fly_test_list",$update_flag,$update_where_flag);
            echo 1;
            exit;
            //show_msg ( '分析完成！', $this->baseurl."&m=statistic_list" );
        }

    }

    public function analysis_state(){
        $this->load->view('admin/statistic_state');
    }

    public function statistic_subject(){
        $id=$this->input->get('id');
        if(!empty($id)){
            $this->session->set_userdata ( 'test_id', $id);
        }
        if(empty($id)){
            $id=$this->input->post("id");
            if(empty($id)){
                $id=$this->session->userdata ( 'test_id');
            }
        }

        $classname=$this->input->post('classname_selected');
        $subject=$this->input->post('subject_selected');

        $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
        $classname_unique=unique($classname_arr);
        $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
        $subject_unique=unique($subject_arr);
        if(empty($classname)){
            $classname=reset($classname_unique);
        }
        if(empty($subject)){
            $subject=reset($subject_unique);
        }

        $where="id=$id AND classname='$classname' AND subject='$subject' order by score desc";
        $data['list']=$this->test_list_model->get_column("student,score","fly_student_score",$where);
        $data['classname_selected']=$classname;
        $data['subject_selected']=$subject;
        $data['classname_unique']=$classname_unique;
        $data['subject_unique']=$subject_unique;
        $data['id']=$id;

        $this->load->view('admin/statistic_subject',$data);
    }

    public function statistic_class(){
        $id=$this->session->userdata ( 'test_id');
        if(empty($id)){
            $id=$this->input->post("id");
        }
        $classname=$this->input->post('classname_selected');
        //取出所有班级
        $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
        $classname_unique=unique($classname_arr);
        $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
        $subject_unique=unique($subject_arr);
        if(empty($classname)){
            $classname=reset($classname_unique);
        }
        if(empty($subject)){
            $subject=reset($subject_unique);
        }
        //从fly_score_rank表获取该班每个学生的班级排名
        $where_class_rank="id=$id and classname='$classname'";
        $class_rank=$this->test_list_model->get_column("student,total_score,class_rank,grade_rank","fly_score_rank",$where_class_rank);
        foreach($class_rank as $class_rank_key=>$class_rank_value){
            foreach($subject_unique as $subject_value){
                $where_score="id=$id AND classname='$classname' AND subject='$subject_value' AND student='$class_rank_value[student]'";
                $result=$this->test_list_model->get_column2("score","fly_student_score",$where_score);
                $class_rank[$class_rank_key]['score'][$subject_value]=$result['score'];
            }
        }

        $data['list']=$class_rank;
        $data['classname_selected']=$classname;
        $data['classname_unique']=$classname_unique;
        $data['subject_unique']=$subject_unique;

        $this->load->view('admin/statistic_class',$data);
    }

    public function statistic_grade(){
        $id=$this->session->userdata ( 'test_id');

        $classname=$this->input->post('classname_selected');
        //取出所有班级
        $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
        $classname_unique=unique($classname_arr);
        $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
        $subject_unique=unique($subject_arr);
        if(empty($classname)){
            $classname=reset($classname_unique);
        }
        if(empty($subject)){
            $subject=reset($subject_unique);
        }
        //从fly_score_rank表获取该班每个学生的班级\年级排名
        $where_grade_rank="id=$id order by grade_rank asc";
        $grade_rank=$this->test_list_model->get_column("classname,student,total_score,class_rank,grade_rank","fly_score_rank",$where_grade_rank);
        foreach($grade_rank as $grade_rank_key=>$grade_rank_value){
            foreach($subject_unique as $subject_value){
                $where_score="id=$id AND classname='$grade_rank_value[classname]' AND subject='$subject_value' AND student='$grade_rank_value[student]'";
                $result=$this->test_list_model->get_column2("score","fly_student_score",$where_score);
                $grade_rank[$grade_rank_key]['score'][$subject_value]=$result['score'];
            }
        }

        $data['list']=$grade_rank;
        $data['classname_selected']=$classname;
        $data['classname_unique']=$classname_unique;
        $data['subject_unique']=$subject_unique;

        $this->load->view('admin/statistic_grade',$data);

    }

    public function statistic_analysis(){
        $id=$this->session->userdata ( 'test_id');

        //通过id获取对应的年级
        $grade=$this->test_list_model->get_column2("grade","fly_test_list","id=$id");
        $subject=trim($this->input->post('subject_selected'));
        $check=$this->input->get("check");//是否要显示人数
        if($check=="true"||$check=="false"){
            $subject=trim($this->input->get("subject"));
        }
        //取出所有班级
        $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
        $classname_unique=unique($classname_arr);
        $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
        $subject_unique=unique($subject_arr);
        if(empty($subject)){
            $subject=reset($subject_unique);
        }

        //初三各个科目的优秀率(初一、初二的历史和政治满分各是100分，初三政史合起来满分100，其中历史40，政治60)
        $excellent_rate1_arr=array('语文'=>108,'数学'=>108,'英语'=>'108','物理'=>90,'化学 '=>90,'政治'=>54,'历史'=>36,'思想品德'=>90,'生物'=>90,'地理'=>90);
        $excellent_rate2_arr=array('语文'=>96,'数学'=>96,'英语'=>96,'物理'=>80,'化学 '=>80,'政治'=>48,'历史'=>32,'思想品德'=>80,'生物'=>80,'地理'=>80);
        $pass_arr=array('语文'=>72,'数学'=>72,'英语'=>72,'物理'=>60,'化学 '=>60,'政治'=>36,'历史'=>24,'思想品德'=>60,'生物'=>60,'地理'=>60);
        //以下是初一初二的
        $excellent_rate3_arr=array('语文'=>108,'数学'=>108,'英语'=>108,'物理'=>90,'化学 '=>90,'政治'=>90,'历史'=>90,'思想品德'=>90,'生物'=>90,'地理'=>90);
        $excellent_rate4_arr=array('语文'=>96,'数学'=>96,'英语'=>96,'物理'=>80,'化学 '=>80,'政治'=>80,'历史'=>80,'思想品德'=>80,'生物'=>80,'地理'=>80);
        $pass_arr2=array('语文'=>72,'数学'=>72,'英语'=>72,'物理'=>60,'化学 '=>60,'政治'=>60,'历史'=>60,'思想品德'=>60,'生物'=>60,'地理'=>60);

        if($grade['grade']=='初三'){
            foreach($excellent_rate1_arr as $excellent_rate1_key=>$excellent_rate1_value){
                if($excellent_rate1_key==$subject){
                    $excellent_score1=$excellent_rate1_value;
                }
            }
        }else{
            foreach($excellent_rate3_arr as $excellent_rate3_key=>$excellent_rate3_value){
                if($excellent_rate3_key==$subject){
                    $excellent_score1=$excellent_rate3_value;
                }
            }
        }
        if($grade['grade']=='初三'){
            foreach($excellent_rate2_arr as $excellent_rate2_key=>$excellent_rate2_value){
                if($excellent_rate2_key==$subject){
                    $excellent_score2=$excellent_rate2_value;
                }
            }
        }else{
            foreach($excellent_rate4_arr as $excellent_rate4_key=>$excellent_rate4_value){
                if($excellent_rate4_key==$subject){
                    $excellent_score2=$excellent_rate4_value;
                }
            }
        }
        if($grade['grade']=='初三'){
            foreach($pass_arr as $pass_arr_key=>$pass_arr_value){
                if($pass_arr_key==$subject){
                    $pass_score=$pass_arr_value;
                }
            }
        }else{
            foreach($pass_arr2 as $pass_arr2_key=>$pass_arr2_value){
                if($pass_arr2_key==$subject){
                    $pass_score=$pass_arr2_value;
                }
            }
        }
        $data=array();
        foreach($classname_unique as $classname_unique_key=>$classname_unique_value){
            $where_all="id=$id and classname='$classname_unique_value' and subject='$subject' and score!=0";
            $excellent_all=$this->test_list_model->db_counts('fly_student_score',$where_all);

            $where_excellent1="id=$id and classname='$classname_unique_value' and subject='$subject' and score>=$excellent_score1";
            $data[$classname_unique_key]['excellent_rate1_num']=$excellent_rate1_num=$this->test_list_model->db_counts('fly_student_score',$where_excellent1);
            $data[$classname_unique_key]['excellent_rate1']=round(($excellent_rate1_num/$excellent_all)*100,2);//0.9优秀率

            $where_excellent2="id=$id and classname='$classname_unique_value' and subject='$subject' and score>=$excellent_score2";
            $data[$classname_unique_key]['excellent_rate2_num']=$excellent_rate2_num=$this->test_list_model->db_counts('fly_student_score',$where_excellent2);
            $data[$classname_unique_key]['excellent_rate2']=round(($excellent_rate2_num/$excellent_all)*100,2);//0.8优秀率

            $where_pass="id=$id and classname='$classname_unique_value' and subject='$subject' and score>=$pass_score";
            $data[$classname_unique_key]['pass_num']=$pass_num=$this->test_list_model->db_counts('fly_student_score',$where_pass);
            $data[$classname_unique_key]['pass_rate']=round(($pass_num/$excellent_all)*100,2);//及格率

            $where_avg="id=$id and classname='$classname_unique_value' and subject='$subject'";
            $score_all=$this->test_list_model->db_sum("fly_student_score",'score',$where_avg);
            $data[$classname_unique_key]['avg_score']=round($score_all/$excellent_all,2);//平均分

            $data[$classname_unique_key]['classname']=$classname_unique_value;//班级名称
        }
        //计算年级优秀率，及格率，平均分等
        $where_all_grade="id=$id and subject='$subject' and score!=0";
        $excellent_all_grade=$this->test_list_model->db_counts('fly_student_score',$where_all_grade);

        $where_excellent1_grade="id=$id and subject='$subject' and score>=$excellent_score1";
        $data_grade['excellent_rate1_num_grade']=$excellent_rate1_num_grade=$this->test_list_model->db_counts('fly_student_score',$where_excellent1_grade);
        $data_grade['excellent_rate1_grade']=round(($excellent_rate1_num_grade/$excellent_all_grade)*100,2);//0.9优秀率

        $where_excellent2_grade="id=$id and subject='$subject' and score>=$excellent_score2";
        $data_grade['excellent_rate2_num_grade']=$excellent_rate2_num_grade=$this->test_list_model->db_counts('fly_student_score',$where_excellent2_grade);
        $data_grade['excellent_rate2_grade']=round(($excellent_rate2_num_grade/$excellent_all_grade)*100,2);//0.8优秀率

        $where_pass_grade="id=$id and subject='$subject' and score>=$pass_score";
        $data_grade['pass_num_grade']=$pass_num_grade=$this->test_list_model->db_counts('fly_student_score',$where_pass_grade);
        $data_grade['pass_rate_grade']=round(($pass_num_grade/$excellent_all_grade)*100,2);//及格率

        $where_avg_grade="id=$id and subject='$subject'";
        $score_all_grade=$this->test_list_model->db_sum("fly_student_score",'score',$where_avg_grade);
        $data_grade['avg_score_grade']=round($score_all_grade/$excellent_all_grade,2);//平均分

        $post_data['list']=$data;
        $post_data['grade']=$data_grade;
        $post_data['classname_unique']=$classname_unique;
        $post_data['subject_unique']=$subject_unique;
        $post_data['subject_selected']=$subject;
        if($check=="true"){
            $this->load->view('admin/statistic_analysis2',$post_data);
        }else{
            $this->load->view('admin/statistic_analysis',$post_data);
        }

    }

    public function statistic_multiple(){
        $id=$this->session->userdata ( 'test_id');
        $classname=$this->input->post('classname_selected');
        $student=$this->input->post('student_selected');
        $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
        $classname_unique=unique($classname_arr);
        if(empty($classname)){
            $classname=reset($classname_unique);
        }
        $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
        $subject_unique=unique($subject_arr);
        $student_arr=$this->test_list_model->get_column("student","fly_score_rank","id=$id and classname='$classname'");
        if(empty($student)){
            $stu=reset($student_arr);
            $student=$stu['student'];
        }

            $subject_multi='';
            $score='';
            $avg_score='';
            $data_grade='';
        foreach($subject_unique as $subject_value){
            $subject_multi.="'$subject_value'".',';
            $where_all="id=$id and classname='$classname' and subject='$subject_value'";
            $excellent_all=$this->test_list_model->db_counts('fly_student_score',$where_all);
            $where_score="id=$id AND classname='$classname' AND subject='$subject_value' AND student='$student'";
            $res_score=$this->test_list_model->get_column2("score","fly_student_score",$where_score);
            $score.=$res_score['score'].',';
            $where_avg="id=$id and classname='$classname' and subject='$subject_value'";
            $score_all=$this->test_list_model->db_sum("fly_student_score",'score',$where_avg);
            $avg_score.=round($score_all/$excellent_all,2).',';//班级平均分
            $where_all_grade="id=$id and subject='$subject_value'";
            $excellent_all_grade=$this->test_list_model->db_counts('fly_student_score',$where_all_grade);
            $where_avg_grade="id=$id and subject='$subject_value'";
            $score_all_grade=$this->test_list_model->db_sum("fly_student_score",'score',$where_avg_grade);
            $data_grade.=round($score_all_grade/$excellent_all_grade,2).',';//年级平均分
        }
        //根据学生和班级，获取该学生参加过的所有考试
        $test_arr=$this->test_list_model->get_column("id","fly_student_score","classname='$classname' and student='$student'");
        $test_unique=unique($test_arr);
        //按时间顺序对每次考试排好序
        foreach($test_unique as $key=>$vaule){
            $tt=$this->test_list_model->get_column2("date","fly_test_list","id=$vaule");
            $date[$key]=strtotime($tt['date']);
        }
        asort($date);
        foreach($date as $key=>$vaule){
            $temp_test[]=$test_unique[$key];
        }
        $test_unique='';
        $test_unique=$temp_test;

        $test_name='';
        foreach($test_unique as $test_unique_value){
            $res_test_name=$this->test_list_model->get_column2("test_name","fly_test_list","id=$test_unique_value");
            $test_name.="'$res_test_name[test_name]'".',';
        }
        foreach($subject_unique as $subject_unique_key=>$subject_value){
            $score_each_string='';
            $score_each[$subject_unique_key]['subject']=$subject_value;
            foreach($test_unique as $test_unique_key=>$test_unique_value){
                $where_score_each="id=$test_unique_value AND classname='$classname' AND subject='$subject_value' AND student='$student'";
                $res_score_each=$this->test_list_model->get_column2("score","fly_student_score",$where_score_each);
                $score_each_string.=$res_score_each['score'].',';
            }
            $score_each[$subject_unique_key]['score']=rtrim($score_each_string,',');
        }

        //获取历次考试总分排名、班级排名
        $rank_grade_str='';
        $rank_class_str='';
        foreach($test_unique as $test_unique_key=>$test_unique_value){
            $where_rank="id=$test_unique_value AND classname='$classname' AND student='$student'";
            $rank_temp=$this->test_list_model->get_column2("grade_rank,class_rank","fly_score_rank",$where_rank);
            $rank_grade_str.=$rank_temp['grade_rank'].',';
            $rank_class_str.=$rank_temp['class_rank'].',';
        }
        $rank_arr[0]['rank_type']="年级排名";
        $rank_arr[0]['rank']=rtrim($rank_grade_str,',');
        $rank_arr[1]['rank_type']="班级排名";
        $rank_arr[1]['rank']=rtrim($rank_class_str,',');

        $data['classname_unique']=$classname_unique;
        $data['student_arr']=$student_arr;
        $data['score']=rtrim($score,',');
        $data['avg_score']=rtrim($avg_score,',');
        $data['data_grade']=rtrim($data_grade,',');
        $data['subject']=rtrim($subject_multi,',');
        $data['classname_selected']=$classname;
        $data['student_selected']=$student;
        $data['test_name']=rtrim($test_name,',');
        $data['score_each']=$score_each;
        $data['flag']='personal';
        $data['rank_each']=$rank_arr;
        $data['rank_type']="'年级排名','班级排名'";

        $this->load->view('admin/statistic_multiple',$data);
    }

    public function statistic_multiple_get_class(){
        $id=$this->session->userdata ( 'test_id');
        $classname=$this->input->post('classname');
        $student_arr=$this->test_list_model->get_column("student","fly_score_rank","id=$id and classname='$classname'");
        echo json_encode($student_arr);
    }

    //科目图像统计
    public function statistic_multiple_sub(){
        $id=$this->session->userdata ( 'test_id');
        $grade=$this->test_list_model->get_column2("grade,test_name","fly_test_list","id=$id");
        //获取所有相同的年级的考试id
        $where_id_arr="grade='$grade[grade]' order by date asc";
        $id_arr=$this->test_list_model->get_column("id","fly_test_list",$where_id_arr);

        $subject=$this->input->post('subject_selected');
        $score_first=$this->input->post('score_first');
        if(empty($score_first)){
            $score_first=0;
        }
        $score_second=$this->input->post('score_second');
        if(empty($score_second)){
            $score_second=60;
        }

        //根据id，获取所有班级和所有科目
        $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
        $classname_unique=unique($classname_arr);
        $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
        $subject_unique=unique($subject_arr);
        //如果post接收到的科目是空，则给一个默认值
        if(empty($subject)){
            $subject=reset($subject_unique);
        }
        //根据班级、科目、分数段从fly_student_score获取该分数段内的学生人数，以及该班级总人数（分数不能为0）
        foreach($classname_unique as $classname_unique_key=>$classname_unique_value){
            $str='';
            $where_score_period="id=$id AND classname='$classname_unique_value' AND subject='$subject' AND score between $score_first and $score_second";
            $mess[$classname_unique_key]['num_period']=$this->test_list_model->db_counts("fly_student_score",$where_score_period);
            $where_total="id=$id AND classname='$classname_unique_value' AND subject='$subject' AND score!=0";
            $mess[$classname_unique_key]['num_total']=$this->test_list_model->db_counts("fly_student_score",$where_total);
            $mess[$classname_unique_key]['classname']=$classname_unique_value;
            foreach($id_arr as $id_arr_key=>$id_arr_value){
                $where="id=$id_arr_value[id] AND classname='$classname_unique_value' AND subject='$subject' AND score between $score_first and $score_second";
                $num=$this->test_list_model->db_counts("fly_student_score",$where);
                $str.=$num.',';
            }
            $mess[$classname_unique_key]['each_num']=rtrim($str,',');
        }
        //获取每次考试的名称
        $test_name_str='';
        foreach($id_arr as $id_arr_key=>$id_arr_value){
            $test_name=$this->test_list_model->get_column2("test_name","fly_test_list","id=$id_arr_value[id]");
            $test_name_str.="'$test_name[test_name]'".',';
        }
        $data['list']=$mess;
        $data['subject_selected']=$subject;
        $data['subject_unique']=$subject_unique;
        $data['flag']="subject";
        $data['score_first']=$score_first;
        $data['score_second']=$score_second;
        $data['test_name']=rtrim($test_name_str,',');
        $data['subhead']=$grade['test_name'];

        $this->load->view('admin/statistic_multiple_sub',$data);
    }

    public function statistic_multiple_total(){
        $id=$this->session->userdata ( 'test_id');
        $grade=$this->test_list_model->get_column2("grade,test_name","fly_test_list","id=$id");
        //获取所有相同的年级的考试id
        $where_id_arr="grade='$grade[grade]' order by date asc";
        $id_arr=$this->test_list_model->get_column("id","fly_test_list",$where_id_arr);

        $subject=$this->input->post('subject_selected');
        $score_first=$this->input->post('score_first');
        if(empty($score_first)){
            $score_first=0;
        }
        $score_second=$this->input->post('score_second');
        if(empty($score_second)){
            $score_second=60;
        }
        //根据id，获取所有班级和所有科目
        $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
        $classname_unique=unique($classname_arr);
        $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
        $subject_unique=unique($subject_arr);
        //如果post接收到的科目是空，则给一个默认值
        if(empty($subject)){
            $subject=reset($subject_unique);
        }
        $where_period="id=$id AND subject='$subject' AND score between $score_first and $score_second";
        $data['num_period']=$this->test_list_model->db_counts("fly_student_score",$where_period);
        $where_total="id=$id AND subject='$subject' AND score!=0";
        $data['num_total']=$this->test_list_model->db_counts("fly_student_score",$where_total);

        //根据班级、科目、分数段从fly_student_score获取该分数段内的学生人数
        $str='';
        foreach($classname_unique as $classname_unique_key=>$classname_unique_value){
            $where_score_period="id=$id AND classname='$classname_unique_value' AND subject='$subject' AND score between $score_first and $score_second";
            $mess[$classname_unique_key]['num_period']=$this->test_list_model->db_counts("fly_student_score",$where_score_period);
            $mess[$classname_unique_key]['classname']=$classname_unique_value;
            $str.="'$classname_unique_value'".',';
        }

        $test_name_str='';
        $num_period_each_str='';
        foreach($id_arr as $id_arr_key=>$id_arr_value){
            //获取每次考试全年级某个科目各分数段的人数
            $where_period_each="id=$id_arr_value[id] AND subject='$subject' AND score between $score_first and $score_second";
            $num_period_each=$this->test_list_model->db_counts("fly_student_score",$where_period_each);
            $num_period_each_str.="'$num_period_each'".',';
            //获取每次考试的名称
            $test_name=$this->test_list_model->get_column2("test_name","fly_test_list","id=$id_arr_value[id]");
            $test_name_str.="'$test_name[test_name]'".',';
        }

        $data['legend']=rtrim($str,',');
        $data['list']=$mess;
        $data['subject_selected']=$subject;
        $data['subject_unique']=$subject_unique;
        $data['flag']="total";
        $data['score_first']=$score_first;
        $data['score_second']=$score_second;
        $data['subhead']=$grade['test_name'];
        $data['test_name']=rtrim($test_name_str,',');
        $data['num_period_each']=rtrim($num_period_each_str,',');

        $this->load->view('admin/statistic_multiple_total',$data);
    }

    public function out_quality_analysis(){
        $id=$this->session->userdata ( 'test_id');
        $test_name=$this->test_list_model->get_column2("test_name,grade","fly_test_list","id=$id");
        //取出所有班级
        $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
        $classname_unique=unique($classname_arr);
        $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
        $subject_unique=unique($subject_arr);

        //各个科目的优秀率(初一、初二的历史和政治满分各是100分，初三政史合起来满分100，其中历史40，政治60)
        $excellent_rate1_arr=array('语文'=>108,'数学'=>108,'英语'=>'108','物理'=>90,'化学 '=>90,'政治'=>54,'历史'=>36,'思想品德'=>90,'生物'=>90,'地理'=>90);
        $excellent_rate2_arr=array('语文'=>96,'数学'=>96,'英语'=>96,'物理'=>80,'化学 '=>80,'政治'=>48,'历史'=>32,'思想品德'=>80,'生物'=>80,'地理'=>80);
        $pass_arr=array('语文'=>72,'数学'=>72,'英语'=>72,'物理'=>60,'化学 '=>60,'政治'=>36,'历史'=>24,'思想品德'=>60,'生物'=>60,'地理'=>60);
        //以下是初一初二的
        $excellent_rate3_arr=array('语文'=>108,'数学'=>108,'英语'=>108,'物理'=>90,'化学 '=>90,'政治'=>90,'历史'=>90,'思想品德'=>90,'生物'=>90,'地理'=>90);
        $excellent_rate4_arr=array('语文'=>96,'数学'=>96,'英语'=>96,'物理'=>80,'化学 '=>80,'政治'=>80,'历史'=>80,'思想品德'=>80,'生物'=>80,'地理'=>80);
        $pass_arr2=array('语文'=>72,'数学'=>72,'英语'=>72,'物理'=>60,'化学 '=>60,'政治'=>60,'历史'=>60,'思想品德'=>60,'生物'=>60,'地理'=>60);

        foreach($classname_unique as $value){
            $classname_all[]=$value;
        }
        foreach($subject_unique as $value){
            $subject_all[]=$value;
        }


        foreach($subject_all as $subject_unique_key=>$subject){
            if($test_name['grade']=='初三'){
                foreach($excellent_rate1_arr as $excellent_rate1_key=>$excellent_rate1_value){
                    if($excellent_rate1_key==$subject){
                        $excellent_score1=$excellent_rate1_value;
                    }
                }
            }else{
                foreach($excellent_rate3_arr as $excellent_rate3_key=>$excellent_rate3_value){
                    if($excellent_rate3_key==$subject){
                        $excellent_score1=$excellent_rate3_value;
                    }
                }
            }
            if($test_name['grade']=='初三'){
                foreach($excellent_rate2_arr as $excellent_rate2_key=>$excellent_rate2_value){
                    if($excellent_rate2_key==$subject){
                        $excellent_score2=$excellent_rate2_value;
                    }
                }
            }else{
                foreach($excellent_rate4_arr as $excellent_rate4_key=>$excellent_rate4_value){
                    if($excellent_rate4_key==$subject){
                        $excellent_score2=$excellent_rate4_value;
                    }
                }
            }
            if($test_name['grade']=='初三'){
                foreach($pass_arr as $pass_arr_key=>$pass_arr_value){
                    if($pass_arr_key==$subject){
                        $pass_score=$pass_arr_value;
                    }
                }
            }else{
                foreach($pass_arr2 as $pass_arr2_key=>$pass_arr2_value){
                    if($pass_arr2_key==$subject){
                        $pass_score=$pass_arr2_value;
                    }
                }
            }

            foreach($classname_all as $classname_unique_key=>$classname_unique_value){
                $where_all="id=$id and classname='$classname_unique_value' and subject='$subject' and score!=0";
                $excellent_all=$this->test_list_model->db_counts('fly_student_score',$where_all);

                $where_excellent1="id=$id and classname='$classname_unique_value' and subject='$subject' and score>=$excellent_score1";
                $excellent_rate1_num=$this->test_list_model->db_counts('fly_student_score',$where_excellent1);
                $data[$subject_unique_key][$classname_unique_key]['excellent_rate1']=round(($excellent_rate1_num/$excellent_all)*100,2);//0.9优秀率

                $where_excellent2="id=$id and classname='$classname_unique_value' and subject='$subject' and score>=$excellent_score2";
                $excellent_rate2_num=$this->test_list_model->db_counts('fly_student_score',$where_excellent2);
                $data[$subject_unique_key][$classname_unique_key]['excellent_rate2']=round(($excellent_rate2_num/$excellent_all)*100,2);//0.8优秀率

                $where_pass="id=$id and classname='$classname_unique_value' and subject='$subject' and score>=$pass_score";
                $pass_num=$this->test_list_model->db_counts('fly_student_score',$where_pass);
                $data[$subject_unique_key][$classname_unique_key]['pass_rate']=round(($pass_num/$excellent_all)*100,2);//及格率

                $where_avg="id=$id and classname='$classname_unique_value' and subject='$subject'";
                $score_all=$this->test_list_model->db_sum("fly_student_score",'score',$where_avg);
                $data[$subject_unique_key][$classname_unique_key]['avg_score']=round($score_all/$excellent_all,2);//平均分

                $data[$subject_unique_key][$classname_unique_key]['classname']=$classname_unique_value;//班级名称


            }
            //计算年级优秀率，及格率，平均分等
            $where_all_grade="id=$id and subject='$subject' and score!=0";
            $excellent_all_grade=$this->test_list_model->db_counts('fly_student_score',$where_all_grade);

            $where_excellent1_grade="id=$id and subject='$subject' and score>=$excellent_score1";
            $excellent_rate1_num_grade=$this->test_list_model->db_counts('fly_student_score',$where_excellent1_grade);
            $data_grade[$subject_unique_key]['excellent_rate1_grade']=round(($excellent_rate1_num_grade/$excellent_all_grade)*100,2);//0.9优秀率

            $where_excellent2_grade="id=$id and subject='$subject' and score>=$excellent_score2";
            $excellent_rate2_num_grade=$this->test_list_model->db_counts('fly_student_score',$where_excellent2_grade);
            $data_grade[$subject_unique_key]['excellent_rate2_grade']=round(($excellent_rate2_num_grade/$excellent_all_grade)*100,2);//0.8优秀率

            $where_pass_grade="id=$id and subject='$subject' and score>=$pass_score";
            $pass_num_grade=$this->test_list_model->db_counts('fly_student_score',$where_pass_grade);
            $data_grade[$subject_unique_key]['pass_rate_grade']=round(($pass_num_grade/$excellent_all_grade)*100,2);//及格率

            $where_avg_grade="id=$id and subject='$subject'";
            $score_all_grade=$this->test_list_model->db_sum("fly_student_score",'score',$where_avg_grade);
            $data_grade[$subject_unique_key]['avg_score_grade']=round($score_all_grade/$excellent_all_grade,2);//平均分

        }
        $post_data['each_class_excellent']=$data;
        $post_data['grade_excellent']=$data_grade;
        $post_data['classname_unique']=$classname_all;
        $post_data['subject_unique']=$subject_all;
        $post_data['test_name']=$test_name['test_name'];

        $this->load->view('admin/out_quality_analysis',$post_data);
    }

    public function out_quality_analysis2(){
        $id=$this->session->userdata ( 'test_id');
        $test_name=$this->test_list_model->get_column2("test_name,grade","fly_test_list","id=$id");
        //取出所有班级
        $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
        $classname_unique=unique($classname_arr);
        $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
        $subject_unique=unique($subject_arr);

        //各个科目的优秀率(初一、初二的历史和政治满分各是100分，初三政史合起来满分100，其中历史40，政治60)
        $excellent_rate1_arr=array('语文'=>108,'数学'=>108,'英语'=>'108','物理'=>90,'化学 '=>90,'政治'=>54,'历史'=>36,'思想品德'=>90,'生物'=>90,'地理'=>90);
        $excellent_rate2_arr=array('语文'=>96,'数学'=>96,'英语'=>96,'物理'=>80,'化学 '=>80,'政治'=>48,'历史'=>32,'思想品德'=>80,'生物'=>80,'地理'=>80);
        $pass_arr=array('语文'=>72,'数学'=>72,'英语'=>72,'物理'=>60,'化学 '=>60,'政治'=>36,'历史'=>24,'思想品德'=>60,'生物'=>60,'地理'=>60);
        //以下是初一初二的
        $excellent_rate3_arr=array('语文'=>108,'数学'=>108,'英语'=>108,'物理'=>90,'化学 '=>90,'政治'=>90,'历史'=>90,'思想品德'=>90,'生物'=>90,'地理'=>90);
        $excellent_rate4_arr=array('语文'=>96,'数学'=>96,'英语'=>96,'物理'=>80,'化学 '=>80,'政治'=>80,'历史'=>80,'思想品德'=>80,'生物'=>80,'地理'=>80);
        $pass_arr2=array('语文'=>72,'数学'=>72,'英语'=>72,'物理'=>60,'化学 '=>60,'政治'=>60,'历史'=>60,'思想品德'=>60,'生物'=>60,'地理'=>60);

        foreach($classname_unique as $value){
            $classname_all[]=$value;
        }
        foreach($subject_unique as $value){
            $subject_all[]=$value;
        }


        foreach($subject_all as $subject_unique_key=>$subject){
            if($test_name['grade']=='初三'){
                foreach($excellent_rate1_arr as $excellent_rate1_key=>$excellent_rate1_value){
                    if($excellent_rate1_key==$subject){
                        $excellent_score1=$excellent_rate1_value;
                    }
                }
            }else{
                foreach($excellent_rate3_arr as $excellent_rate3_key=>$excellent_rate3_value){
                    if($excellent_rate3_key==$subject){
                        $excellent_score1=$excellent_rate3_value;
                    }
                }
            }
            if($test_name['grade']=='初三'){
                foreach($excellent_rate2_arr as $excellent_rate2_key=>$excellent_rate2_value){
                    if($excellent_rate2_key==$subject){
                        $excellent_score2=$excellent_rate2_value;
                    }
                }
            }else{
                foreach($excellent_rate4_arr as $excellent_rate4_key=>$excellent_rate4_value){
                    if($excellent_rate4_key==$subject){
                        $excellent_score2=$excellent_rate4_value;
                    }
                }
            }
            if($test_name['grade']=='初三'){
                foreach($pass_arr as $pass_arr_key=>$pass_arr_value){
                    if($pass_arr_key==$subject){
                        $pass_score=$pass_arr_value;
                    }
                }
            }else{
                foreach($pass_arr2 as $pass_arr2_key=>$pass_arr2_value){
                    if($pass_arr2_key==$subject){
                        $pass_score=$pass_arr2_value;
                    }
                }
            }

            foreach($classname_all as $classname_unique_key=>$classname_unique_value){
                $where_all="id=$id and classname='$classname_unique_value' and subject='$subject' and score!=0";
                $excellent_all=$this->test_list_model->db_counts('fly_student_score',$where_all);

                $where_excellent1="id=$id and classname='$classname_unique_value' and subject='$subject' and score>=$excellent_score1";
                $data[$subject_unique_key][$classname_unique_key]['excellent_rate1_num']=$excellent_rate1_num=$this->test_list_model->db_counts('fly_student_score',$where_excellent1);
                $data[$subject_unique_key][$classname_unique_key]['excellent_rate1']=round(($excellent_rate1_num/$excellent_all)*100,2);//0.9优秀率

                $where_excellent2="id=$id and classname='$classname_unique_value' and subject='$subject' and score>=$excellent_score2";
                $data[$subject_unique_key][$classname_unique_key]['excellent_rate2_num']=$excellent_rate2_num=$this->test_list_model->db_counts('fly_student_score',$where_excellent2);
                $data[$subject_unique_key][$classname_unique_key]['excellent_rate2']=round(($excellent_rate2_num/$excellent_all)*100,2);//0.8优秀率

                $where_pass="id=$id and classname='$classname_unique_value' and subject='$subject' and score>=$pass_score";
                $data[$subject_unique_key][$classname_unique_key]['pass_num']=$pass_num=$this->test_list_model->db_counts('fly_student_score',$where_pass);
                $data[$subject_unique_key][$classname_unique_key]['pass_rate']=round(($pass_num/$excellent_all)*100,2);//及格率

                $where_avg="id=$id and classname='$classname_unique_value' and subject='$subject'";
                $score_all=$this->test_list_model->db_sum("fly_student_score",'score',$where_avg);
                $data[$subject_unique_key][$classname_unique_key]['avg_score']=round($score_all/$excellent_all,2);//平均分

                $data[$subject_unique_key][$classname_unique_key]['classname']=$classname_unique_value;//班级名称


            }
            //计算年级优秀率，及格率，平均分等
            $where_all_grade="id=$id and subject='$subject' and score!=0";
            $excellent_all_grade=$this->test_list_model->db_counts('fly_student_score',$where_all_grade);

            $where_excellent1_grade="id=$id and subject='$subject' and score>=$excellent_score1";
            $data_grade[$subject_unique_key]['excellent_rate1_num_grade']=$excellent_rate1_num_grade=$this->test_list_model->db_counts('fly_student_score',$where_excellent1_grade);
            $data_grade[$subject_unique_key]['excellent_rate1_grade']=round(($excellent_rate1_num_grade/$excellent_all_grade)*100,2);//0.9优秀率

            $where_excellent2_grade="id=$id and subject='$subject' and score>=$excellent_score2";
            $data_grade[$subject_unique_key]['excellent_rate2_num_grade']=$excellent_rate2_num_grade=$this->test_list_model->db_counts('fly_student_score',$where_excellent2_grade);
            $data_grade[$subject_unique_key]['excellent_rate2_grade']=round(($excellent_rate2_num_grade/$excellent_all_grade)*100,2);//0.8优秀率

            $where_pass_grade="id=$id and subject='$subject' and score>=$pass_score";
            $data_grade[$subject_unique_key]['pass_num_grade']=$pass_num_grade=$this->test_list_model->db_counts('fly_student_score',$where_pass_grade);
            $data_grade[$subject_unique_key]['pass_rate_grade']=round(($pass_num_grade/$excellent_all_grade)*100,2);//及格率

            $where_avg_grade="id=$id and subject='$subject'";
            $score_all_grade=$this->test_list_model->db_sum("fly_student_score",'score',$where_avg_grade);
            $data_grade[$subject_unique_key]['avg_score_grade']=round($score_all_grade/$excellent_all_grade,2);//平均分

        }
        $post_data['each_class_excellent']=$data;
        $post_data['grade_excellent']=$data_grade;
        $post_data['classname_unique']=$classname_all;
        $post_data['subject_unique']=$subject_all;
        $post_data['test_name']=$test_name['test_name'];

        $this->load->view('admin/out_quality_analysis2',$post_data);
    }


    public function out_statistic_grade(){
        $id=$this->session->userdata ( 'test_id');
        $test_name=$this->test_list_model->get_column2("test_name","fly_test_list","id=$id");
        //取出所有班级
        $classname_arr=$this->test_list_model->get_column("classname","fly_student_score","id=$id");
        $classname_unique=unique($classname_arr);
        $subject_arr=$this->test_list_model->get_column("subject","fly_student_score","id=$id");
        $subject_unique=unique($subject_arr);
        foreach($classname_unique as $value){
            $classname_all[]=$value;
        }
        foreach($subject_unique as $value){
            $subject_all[]=$value;
        }

        //从fly_score_rank表获取该班每个学生的班级、年级排名
        $where_grade_rank="id=$id order by grade_rank asc";
        $grade_rank=$this->test_list_model->get_column("classname,student,total_score,class_rank,grade_rank","fly_score_rank",$where_grade_rank);
        foreach($grade_rank as $grade_rank_key=>$grade_rank_value){
            foreach($subject_all as $subject_value){
                $where_score="id=$id AND classname='$grade_rank_value[classname]' AND subject='$subject_value' AND student='$grade_rank_value[student]'";
                $result=$this->test_list_model->get_column2("score","fly_student_score",$where_score);
                $grade_rank[$grade_rank_key]['score'][$subject_value]=$result['score'];
            }
        }

        $data['list']=$grade_rank;
        $data['classname_unique']=$classname_all;
        $data['subject_unique']=$subject_all;
        $data['test_name']=$test_name['test_name'].'年级排名表';

        $this->load->view('admin/out_statistic_grade',$data);
    }

    public function ceshi(){
        $this->load->view('admin/ceshi');
    }

    public function action_ceshi()
    {
        $insert_id = 1;
        $thumb = $this->input->post('thumb');
        if (1) {
            //插入
            //$insert_id = $this->test_list_model->db_insert_table("fly_test_list", $value);
            $PHPReader = new PHPExcel_Reader_Excel2007();
            //为了可以读取所有版本Excel文件
            if (!$PHPReader->canRead($thumb)) {
                $PHPReader = new PHPExcel_Reader_Excel5();
                if (!$PHPReader->canRead($thumb)) {
                    echo '未发现Excel文件！';
                    return;
                }
            }
            //读取Excel文件
            $PHPExcel = $PHPReader->load($thumb);
            //统计一个excel有多少个工作表
            $sheetCount = $PHPExcel->getSheetCount();
            //创建 Reader
            $excel = new Spreadsheet_Excel_Reader();
            //设置文本输出编码
            $excel->setOutputEncoding('utf-8');
            //读取Excel文件
            $excel->read($thumb);
            $i = 0;
            for ($i; $i < $sheetCount; $i++) {
                $data = $excel->sheets[$i]['cells'];
                foreach ($data as $key => $value) {
                    foreach($value as $k=>$val){
                        if ($key > 1) {
                            $insert_data['id'] = $insert_id;
                            $insert_data['classname'] = trim($value[1] . "班");
                            $insert_data['student'] = trim($value[2]);
                            $insert_data['subject'] = trim($data[1][3]);
                            $insert_data['score'] = $value[3];
                            //$this->test_list_model->db_insert_table("fly_student_score", $insert_data);
                        }
                    }

                }
            }

        }else {
            $this->test_list_model->db_update_table("fly_test_list", $value, $id);
            $delete_arr['id'] = $id;
            $this->test_list_model->db_delete2("fly_student_score", $delete_arr);
            $PHPReader = new PHPExcel_Reader_Excel2007();
            //为了可以读取所有版本Excel文件
            if (!$PHPReader->canRead($value['thumb'])) {
                $PHPReader = new PHPExcel_Reader_Excel5();
                if (!$PHPReader->canRead($value['thumb'])) {
                    echo '未发现Excel文件！';
                    return;
                }
            }
            //读取Excel文件
            $PHPExcel = $PHPReader->load($value['thumb']);
            //统计一个excel有多少个工作表
            $sheetCount = $PHPExcel->getSheetCount();
            //创建 Reader
            $excel = new Spreadsheet_Excel_Reader();
            //设置文本输出编码
            $excel->setOutputEncoding('utf-8');
            //读取Excel文件
            $excel->read($value['thumb']);
            $i = 0;
            for ($i; $i < $sheetCount; $i++) {
                $data = $excel->sheets[$i]['cells'];
                foreach ($data as $key => $value) {
                    if ($key > 1) {
                        $insert_data['id'] = $id;
                        $insert_data['classname'] = $value[1] . "班";
                        $insert_data['student'] = $value[2];
                        $insert_data['subject'] = $data[1][3];
                        $insert_data['score'] = $value[3];
                        $this->test_list_model->db_insert_table("fly_student_score", $insert_data);
                    }
                }
            }
        }


    }

    public function notice(){
        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $total_rows=$this->test_list_model->rows_query("fly_notice");
        $pagination['total_rows'] =$total_rows;
        $pagination['base_url'] = $this->baseurl."&m=notice";
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('pn') ? intval($this->input->get('pn')) : 0;
        $data['list'] = $this->test_list_model->get_list2('*',"",'fly_notice',$offset,10);

        $this->load->view('admin/notice_list',$data);
    }

    public function save_notice_list(){
        $notice_list_id=$this->input->get('id');
        $data=$this->input->post("value");
        $_SESSION ['url_forward']=$this->baseurl."&m=notice";
        if($notice_list_id){    //修改
            $this->test_list_model->db_update_table("fly_notice",$data,$notice_list_id);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        }else{
            $this->test_list_model->db_insert_table("fly_notice", $data);
            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }

    }









}
