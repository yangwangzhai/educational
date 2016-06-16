<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
// 教学测评

include 'content.php';
class Assessment extends Content {

    function __construct() {

        $class_name = 'assessment';
        $this->name = "教学测评";
        $this->list_view = $class_name.'_list';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=assessment'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('assessment_model');
}

    /**
     *主页面
     */
    function index()
    {
        $teacherid=$this->teacherid;
        $semester = $this->input->get('semester')?$this->input->get('semester'):'1';

        $data=$this->assessment_model->statistic_semester($teacherid,$semester);
        ksort($data);
        $xdata=array();
        $ydata=array();
        foreach($data as $k=>$val)
        {
            $xdata[$k]=$val['MONTH'];
            $ydata[$k]=$val['total'];
            $score=145;

            if(($score*0.95)<$val['total'])
            {
                $state[$k]='优秀';
            }
            if(($score*0.95)>$val['total'] && ($score*0.70)<$val['total'])
            {

                $state[$k]='良好';
            }
            elseif(($score*0.7)>$val['total'])
            {
                $state[$k]='不及格';
            }

        }
        $data['state']=$state;
        $data['semester']=$semester;
        $data['xdata']=$xdata;
        $data['ydata']=$ydata;
        $_SESSION ['url_forward'] = $this->baseurl . "&semester=$semester";
        $this->load->view('teacher/' . $this->list_view, $data);  /**/
    }



// 编辑
    public function details() {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->assessment_model->get_one($id);
        $data['morality']=@unserialize($value['morality']);

        $data['management']=@unserialize($value['management']);

        $data['teaching']=@unserialize($value['teaching']);

        $data['conservation']=@unserialize($value['conservation']);

        $data['research']=@unserialize($value['research']);

        $data['attendance']=@unserialize($value['attendance']);

        $data ['value'] = $value;
        $this->load->view ( 'teacher/assessment_details', $data );
    }


    // 编辑
    public function detail() {
        $teacherid = $this->teacherid;
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
        $data['title']=config_item('semester')[$semester].config_item('MONTH1')[$month].'月考核';
        $data['id']=$value['id'];
        $this->load->view ( 'teacher/assessment_detail', $data );
    }
}
