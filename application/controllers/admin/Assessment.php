<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
/*
 * 教师测评控制器
 * @ author qcl 2016-01-05
 */

include 'content.php';
class Assessment extends Content {

    function __construct() {
        $class_name = 'assessment';
        $this->name = "教学测评";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';//添加列
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=admin&c=assessment'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('assessment_model');
        $this->load->model('teacher_base_model');
    }

    /**
     *主页面
     */
    function index()
    {
        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $total_rows=$this->assessment_model->rows_query();
        $pagination['total_rows'] =$total_rows;
        $pagination['base_url'] = $this->baseurl;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('pn') ? intval($this->input->get('pn')) : 0;
        $data['list'] = $this->assessment_model->get_list2('*',"",'fly_assessment_list',$offset,10);

        $this->load->view('admin/' . $this->list_view,$data);
    }

    public function save_assessment_list(){
        $assessment_id=$this->input->get('id');
        $data['grade']=$this->input->post('grade');
        $data['classname']=$this->input->post('classname');
        $data['term']=$this->input->post('term');
        $_SESSION ['url_forward']=$this->baseurl;
        if($assessment_id){//修改
            $this->assessment_model->db_update_table("fly_assessment_list",$data,$assessment_id);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        }else{
            $this->assessment_model->db_insert_table("fly_assessment_list",$data);
            show_msg ( '保存成功！', $_SESSION ['url_forward'] );
        }

    }

    public function assessment_home_page(){
        $id=$this->input->get('id');
        $this->session->set_userdata ('assessment_id', $id);
        $data['grade']=$grade=$this->input->get('grade');
        $data['classname']=$classname=$this->input->get('classname');

        //根据年级、班级获取该年级该班级所有科目以及对应的老师
        $schoolid=1;
        $school_type=1;
        $term=3;
        $where="schoolid=$schoolid AND school_type=$school_type AND term=$term AND grade='$grade' AND classname='$classname' AND teacher IS NOT NULL";
        $result=$this->assessment_model->get_column("course,teacher","fly_course_plan",$where);
        foreach($result as $key=>$value){
            $where_teacherid="schoolid=$schoolid AND school_type=$school_type AND term=$term AND teacher='$value[teacher]'";
            $res=$this->assessment_model->get_column2("id","fly_teacher",$where_teacherid);
            $result[$key]['id']=$res['id'];
        }
        $data['list']=$result;

        $this->load->view('admin/assessment_home_page',$data);
    }

    public function save_assessment(){
        $assessment_id=$this->session->userdata('assessment_id');
        $data=$this->input->post('value');

        $insert['assessment_id']=$assessment_id;
        foreach($data as $data_key=>$data_value){
            $insert['teacher_id']=$data_key;
            foreach($data_value as $project_key=>$project_value){
                $insert['assessment_project']=$project_key;
                foreach($project_value as $score_key=>$score_value){
                    if($score_value){
                        $insert['score']=$score_key;
                        $this->assessment_model->db_insert_table("fly_assessment_content",$insert);
                    }
                }
            }
        }
        $_SESSION ['url_forward']=$this->baseurl;
        show_msg ( '保存成功！', $_SESSION ['url_forward'] );
    }

    public function assessment_analysis(){
        $assessment_id=$this->input->get('id');
        $grade=$this->input->get('grade');
        $classname=$this->input->get('classname');
        //根据年级、班级获取该年级该班级所有科目以及对应的老师
        $schoolid=1;
        $school_type=1;
        $term=3;
        $where="schoolid=$schoolid AND school_type=$school_type AND term=$term AND grade='$grade' AND classname='$classname' AND teacher IS NOT NULL";
        $result=$this->assessment_model->get_column("course,teacher","fly_course_plan",$where);
        //获取各个老师的id
        foreach($result as $key=>$value){
            $where_teacherid="schoolid=$schoolid AND school_type=$school_type AND term=$term AND teacher='$value[teacher]'";
            $res=$this->assessment_model->get_column2("id","fly_teacher",$where_teacherid);
            $result[$key]['id']=$res['id'];
        }
        $data['teacher']=$result;
        $project=array('love_student','work_attidute','teach_ability','teach_way','teach_condition','homework_correct','general_evaluation');
        $score=array('best','well','bad');
        foreach($project as $project_key=>$project_value){
            foreach($result as $result_key=>$result_value){
                foreach($score as $score_value){
                    $where_analysis="assessment_id=$assessment_id AND teacher_id=$result_value[id] AND assessment_project='$project_value' AND score='$score_value'";
                    $result[$result_key][$score_value]=$this->assessment_model->db_counts("fly_assessment_content",$where_analysis);
                    $list[$project_value]=$result;
                }
            }
        }
        $data['list']=$list;
        $data['grade']=$grade;
        $data['classname']=$classname;
        $this->load->view('admin/assessment_analysis',$data);
    }

    public function delete_assessment(){
        $assessment_id=$this->input->get('id');
        $delete_assessment_list['id']=$assessment_id;
        $this->assessment_model->db_delete2("fly_assessment_list",$delete_assessment_list);
        $delete_assessment_content['assessment_id']=$assessment_id;
        $this->assessment_model->db_delete2("fly_assessment_content",$delete_assessment_content);
        $_SESSION ['url_forward']=$this->baseurl;
        show_msg ( '删除成功！', $_SESSION ['url_forward'] );
    }

    // 编辑
    public function add() {
        $month=date('m',strtotime('-1 month', time()));
        $data['month']=$month;
        $this->load->view ( 'admin/' . $this->add_view, $data );
    }

    // 编辑
    public function edit() {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->assessment_model->get_one($id);
        $value = $this->teacher_base_model->append_item( $value );
        $data['morality']=@unserialize($value['morality']);

        $data['management']=@unserialize($value['management']);

        $data['teaching']=@unserialize($value['teaching']);

        $data['conservation']=@unserialize($value['conservation']);

        $data['research']=@unserialize($value['research']);

        $data['attendance']=@unserialize($value['attendance']);

        $data ['id'] = $id;
        $data ['value'] = $value;
        $this->load->view ( 'admin/' . $this->edit_view, $data );
    }
// 编辑
    public function details() {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->assessment_model->get_one($id);
        $value = $this->teacher_base_model->append_item( $value );
        $data['morality']=@unserialize($value['morality']);

        $data['management']=@unserialize($value['management']);

        $data['teaching']=@unserialize($value['teaching']);

        $data['conservation']=@unserialize($value['conservation']);

        $data['research']=@unserialize($value['research']);

        $data['attendance']=@unserialize($value['attendance']);

        $data ['value'] = $value;
        $this->load->view ( 'admin/assessment_details', $data );
    }
    public function check_data()
    {
        $teacherid = $this->input->post('teacherid');
        $MONTH=$this->input->post('MONTH');
        $semester=$this->input->post('semester');
        $value = $this->assessment_model->get_assessment_by_teacherid($teacherid,$MONTH,$semester);
        if(!empty($value))
        {
            echo 1;exit;
        }
    }
    // 保存 添加和修改都是在这里
    public function save() {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $data = trims ( $_POST ['value'] );
        $data['total']=0;
        $morality=trims ( $_POST ['morality'] );
        foreach($morality as $v)
        {
            $data['total']+=$v;
        }
        $management=trims ( $_POST ['management'] );
        foreach($management as $v)
        {
            $data['total']+=$v;
        }
        $teaching=trims ( $_POST ['teaching'] );
        foreach($teaching as $v)
        {
            $data['total']+=$v;
        }
        $conservation=trims ( $_POST ['conservation'] );
        foreach($conservation as $v)
        {
            $data['total']+=$v;
        }
        $research=trims ( $_POST ['research'] );
        foreach($research as $v)
        {
            $data['total']+=$v;
        }
        $attendance=trims ( $_POST ['attendance'] );
        foreach($attendance as $v)
        {
            $data['total']+=$v;
        }

        $data['morality']=serialize($morality);
        $data['management']=serialize($management);
        $data['teaching']=serialize($teaching);
        $data['conservation']=serialize($conservation);
        $data['research']=serialize($research);
        $data['attendance']=serialize($attendance);
        $data['schoolid'] = $this->schoolid;
        if ($data ['teacherid'] == "") {
            show_msg ( '教师不能为空' );
        }
        if ($id) { // 修改 ===========
            $this->assessment_model->update($id,$data);
            show_msg ( '修改成功！', $_SESSION ['url_forward'] );
        } else { // ===========添加 ===========
            $data ['addtime'] = time ();
            $this->assessment_model->insert($data);

            show_msg ( '添加成功！', $_SESSION ['url_forward'] );
        }
    }
    // 编辑
    public function detail() {
        $teacherid = $this->input->get('teacherid')?$this->input->get('teacherid'):'1';
        $semester = $this->input->get('semester')?$this->input->get('semester'):'1';
        $month = $this->input->get('month')?$this->input->get('month'):'1';
        $arr=$this->assessment_model->statistic_semester($teacherid,$semester);
        $value = $this->assessment_model->get_assessment_by_teacherid($teacherid,$month,$semester);
        if(empty($value))
        {
            show_msg('没有数据');
        }
        $rel=array();
        foreach($arr as $v){
            $rel[]=$v['MONTH'];
        }
        if($month==end($rel))
        {
            $next_month=0;
            $pre_month=0;
            if(count($rel)>1)
            {
                $pre_month=$rel[count($rel)-2];
            }

        }
        elseif($rel[0]==$month)
        {
            $pre_month=0;
            $next_month=$rel[1];
        }
        else
        {
            foreach($rel as $key=>$val)
            {
                if($val==$month)
                {
                    $next_month=$rel[$key+1];
                    $pre_month=$rel[$key-1];
                }
            }
        }
        $data['next_month']=$next_month;
        $data['pre_month']=$pre_month;
        // 这条信息

        $teacher= $this->teacher_base_model->get_one( $teacherid );
        $morality=@unserialize($value['morality']);
        $data['morality']=0;
        if(is_array($morality))
        {
            foreach($morality as $v)
            {
                $data['morality']+=$v;
            }
        }
        $management=@unserialize($value['management']);
        $data['management']=0;
        if(is_array($management))
        {
            foreach($management as $v)
            {
                $data['management']+=$v;
            }
        }
        $teaching=@unserialize($value['teaching']);
        $data['teaching']=0;
        if(is_array($teaching)) {
            foreach($teaching as $v)
            {
                $data['teaching']+=$v;
            }
        }
        $conservation=@unserialize($value['conservation']);
        $data['conservation']=0;
        if(is_array($conservation)) {
            foreach($conservation as $v)
            {
                $data['conservation']+=$v;
            }
        }
        $research=@unserialize($value['research']);
        $data['research']=0;
        if(is_array($research)) {
            foreach($research as $v)
            {
                $data['research']+=$v;
            }
        }
        $attendance=@unserialize($value['attendance']);
        $data['attendance']=0;
        if(is_array($attendance)) {
            foreach($attendance as $v)
            {
                $data['attendance']+=$v;
            }
        }
        $data['teacherid']=$teacherid;
        $data['semester']=$semester;
        $data['month']=$month;
        $data['total']=$value['total'];
        $data['title']=$teacher['truename'].config_item('semester')[$semester].config_item('MONTH1')[$month].'月考核';
        $data['id']=$value['id'];
        $this->load->view ( 'admin/assessment_detail', $data );
    }
    public function statistic()
    {
        $semester = $this->input->get('semester')?$this->input->get('semester'):'1';
        $month = $this->input->get('month')?$this->input->get('month'):'1';
        $list=$this->assessment_model->statistic($semester);
        ksort($list);
        $rel=array();
        foreach($list as $k=>$v){
            $rel[]=$k;
        }
        if($month==end($rel))
        {
            $next_month=0;
            $pre_month=$rel[count($rel)-2];
        }
        elseif($rel[0]==$month)
        {
            $pre_month=0;
            $next_month=$rel[1];
        }
        else
        {
            foreach($rel as $key=>$value)
            {
                if($value==$month)
                {
                    $next_month=$rel[$key+1];
                    $pre_month=$rel[$key-1];
                }
            }
        }
        $data['next_month']=$next_month;
        $data['pre_month']=$pre_month;
        $arr=$this->assessment_model->get_assessment_by_month($month,$semester);

        $num=count($arr);
        $data['num']=$num;
        $excellent=0;
        $good=0;
        foreach($arr as $val)
        {
            if($val['total']>=112)
            {
                $excellent+=1;
            }
            if($val['total']>=84 AND $val['total']<112)
            {
                $good+=1;
            }
        }
        $count=$this->teacher_base_model->counts("schoolid=$this->schoolid");
        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = "index.php?d=admin&c=assessment&m=statistic&semester=$semester&month=$month";
        $pagination['total_rows'] = $count;
        $pagination['per_page'] = 60;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;
        $teacher=$this->teacher_base_model->get_list('id,truename',"schoolid=$this->schoolid",$offset,60);
        foreach($teacher as &$item)
        {
            $item['total']=$this->assessment_model->get_assessment_by_teacherid($item['id'],$month,$semester)['total'];
        }
        $data['teacher']=$teacher;
        $poor=$num-$excellent-$good;
        $data['excellent']=$excellent;
        $data['good']=$good;
        $data['poor']=$poor;

        $data['month']=$month;
        $data['semester']=$semester;
        $this->load->view ( 'admin/assessment_statistic', $data );
    }
    public function teacher_dialog()
    {
        $MONTH=$this->input->get('MONTH');
        $semester=$this->input->get('semester');
        $where="schoolid=$this->schoolid";

        $list = $this->teacher_base_model->get_list('id,truename',$where,0,50);
        foreach($list as &$item)
        {
            $item['mark']=0;
            $row = $this->assessment_model->get_assessment_by_teacherid($item['id'],$MONTH,$semester);
            if($row)
            {
                $item['mark']=1;
            }
        }
        $data['list']=$list;
        $this->load->view('admin/assessment_dialog', $data);
    }
}
