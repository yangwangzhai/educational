<?php

include 'content.php';

/**
 * 考勤控制器
 * @author qcl 2016/01/08
 *
 */
class Attendance extends Content
{
    /**
     * 构造器
     */
    function __construct()
    {
        $class_name = 'attendance';
        $this->name = "考勤";
        $this->list_view = $class_name . '_list';
        $this->table = 'fly_' . $class_name;
        $this->baseurl = 'index.php?d=admin&c=attendance'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('attendance_analysis_model');
        $this->load->model('attendance_record_model');
        $this->load->model('attendance_set_model');
        $this->load->model('teacher_base_model');
    }

    // 首页
    public function index()
    {
        $searchsql = "1 AND schoolid=$this->schoolid";
        $keywords = $this->input->post('keywords') ? trim($this->input->post('keywords')) : '';
        $pubdate = date('Y-m', strtotime('-1 month', time()));
        if ($this->input->post('pubdate') || $this->input->get('pubdate')) {
            $pubdate = $this->input->post('pubdate')?$this->input->post('pubdate'):$this->input->get('pubdate');
        }
        $record = $this->attendance_record_model->get_record_by_date($pubdate,$searchsql);
        if($record)
        {
            $analysis=$this->attendance_analysis_model->get_analysis_by_date($pubdate,$searchsql);
            if(empty($analysis))
            {
                $this->analysis($pubdate);
            }
        }
        $reset = 1;
        if ($this->input->post('submit')) {
            if (!$this->input->post('reset')) {
                $reset = 0;
            }
        }
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND truename like '%{$keywords}%' ";
        }

        $data ['list'] = array();
        $count = $this->teacher_base_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data ['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('per_page') ? intval($this->input->get('per_page')) : 0;

        $list = $this->teacher_base_model->get_list('id,dept,truename', $searchsql, $offset, 20);
        $where = '';
        if ($reset == 1) {
            $where = ' iswork=1';
        }
        $dept = $this->config->item('dept');
        foreach ($list as &$item) {
            $item['zhengch'] = 0;
            $item['chidao'] = 0;
            $item['zaotui'] = 0;
            $item['weidaka'] = 0;
            $analy = $this->attendance_analysis_model->get_attendance_analysis($item['id'], $pubdate, $where);
            foreach ($analy as $val) {

                if ($val['state'] == 1) {
                    $item['zhengch'] = $val['num'];
                } elseif ($val['state'] == 2) {
                    $item['chidao'] = $val['num'];
                } elseif ($val['state'] == 3) {
                    $item['zaotui'] = $val['num'];
                } else {
                    $item['weidaka'] = $val['num'];
                }
            }
            $item['dept'] = $dept[$item['dept']];
        }

        $data['list'] = $list;
        $data['pubdate'] = $pubdate;
        $data['reset'] = $reset;
        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
    function main()
    {
        $pubdate=date('Y-m',time());
        if ($this->input->post('pubdate') || $this->input->get('pubdate')) {
            $pubdate = $this->input->post('pubdate')?$this->input->post('pubdate'):$this->input->get('pubdate');
        }
        $month_arr=get_lately_month($pubdate,8);
        sort($month_arr);
        $dept=$this->config->item('dept');

        foreach($dept as $k=>$v)
        {
            $list[$k]['zhengch'] = 0;
            $list[$k]['chidao'] = 0;
            $list[$k]['zaotui'] = 0;
            $list[$k]['weidaka'] = 0;
            $teacher=$this->teacher_base_model->get_list('id',"schoolid=$this->schoolid AND dept=$k",0,100);
            if($teacher)
            {
                foreach($teacher as $item)
                {
                    $analy=$this->attendance_analysis_model->get_attendance_analysis($item['id'],$pubdate,' iswork=1');
                    foreach ($analy as $val) {

                        if ($val['state'] == 1) {
                            $list[$k]['zhengch'] += $val['num'];
                        } elseif ($val['state'] == 2) {
                            $list[$k]['chidao'] += $val['num'];
                        } elseif ($val['state'] == 3) {
                            $list[$k]['zaotui'] += $val['num'];
                        } else {
                            $list[$k]['weidaka']+= $val['num'];
                        }
                    }

                }
                //最近几个月缺勤情况
                foreach($month_arr as $key=>$m)
                {
                    $m_list[$k][$key]['weidaka']=0;
                    foreach($teacher as $item)
                    {
                        $m_analy=$this->attendance_analysis_model->get_attendance_analysis($item['id'],$m,' iswork=1');
                        foreach ($m_analy as $val) {
                            if ($val['state'] == 4) {
                                $m_list[$k][$key]['weidaka']+= $val['num'];
                            }
                        }
                    }
                }
            }
        }
        foreach ($month_arr as $item) {
            $month_ar[]=config_item('MONTH')[date('m',strtotime($item))];
        }
        $data['month_ar']=$month_ar;/**/
        $data['m_list']=$m_list;
        $data['list']=$list;
        $data['pubdate']=$pubdate;
        $data['month']=config_item('MONTH')[date('m',strtotime($pubdate))];
        $this->load->view('admin/attendance_main',$data);
    }
    public function refresh()
    {
        $date=$this->input->get('date');
        $searchsql = "1 AND schoolid=$this->schoolid";
        $record = $this->attendance_record_model->get_record_by_date($date,$searchsql);
        if($record)
        {
            $analysis=$this->attendance_analysis_model->get_analysis_by_date($date,$searchsql);
            if($analysis)
            {
                $result =$this->attendance_analysis_model->delete_analysis_by_date($date,$searchsql);
               if($result>=1)
               {
                    $this->analysis($date);
                   /*show_msg('分析成功',$_SESSION ['url_forward']);*/
               }

            }
        }
        show_msg('分析成功',$_SESSION ['url_forward']);
    }
    // 打卡记录首页
    public function record()
    {

        $searchsql = "1 AND schoolid=$this->schoolid";
        $this->baseurl .= '&m=record';
        $keywords = $this->input->post('keywords') ? trim($this->input->post('keywords')) : '';
        if ($this->input->post('begintime') || $this->input->get('begintime')) {
            $begintime = $this->input->post('begintime') ? $this->input->post('begintime') : $this->input->get('begintime');
            $this->baseurl .= "&begintime=" . rawurlencode($begintime);
            $searchsql .= " AND checktime>='$begintime 00:00:00'";
        }
        if ($this->input->post('endtime') || $this->input->get('endtime')) {
            $endtime = $this->input->post('endtime') ? $this->input->post('endtime') : $this->input->get('endtime');
            $this->baseurl .= "&endtime=" . rawurlencode($endtime);
            $searchsql .= " AND checktime<='$endtime 00:00:00'";
        }

        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND name like '%{$keywords}%' ";
        }

        $data ['list'] = array();
        $count = $this->attendance_record_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data ['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('per_page') ? intval($this->input->get('per_page')) : 0;

        $list = $this->attendance_record_model->get_list('*', $searchsql, $offset, 20);
        $weekarry = array('日', '一', '二', '三', '四', '五', '六');
        foreach ($list as &$item) {
            $item['week'] = $weekarry[date('w', strtotime($item['checktime']))];
        }

        $data['list'] = $this->teacher_base_model->append_list1($list);;

        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/attendance_record', $data);
    }
    public function detail()
    {
        $id = $this->input->get('id')?$this->input->get('id'):$this->input->post('id');
        $data['teacher']=$this->teacher_base_model->get_one($id);
        $pubdate='';
        if ($this->input->post('pubdate') || $this->input->get('pubdate')) {
            $pubdate = $this->input->post('pubdate')?$this->input->post('pubdate'):$this->input->get('pubdate');
        }
        $year = date('Y',strtotime($pubdate));
        $month = date('m',strtotime($pubdate));
        $am_attendance=array();
        $pm_attendance=array();
        //取得天数
        $num_days = date("t",mktime(0,0,0,$month,1,$year));

        //取得第一天是星期几
        $first_day = date("N",mktime(0,0,0,$month,1,$year));
        for ($i = 1; $i <= $num_days; $i++) {  //循环日期
            $j=$i;

            if (strlen($j) === 1)
            {
                $j = '0'.$j;
            }
            $dodate = $pubdate . '-' . $j;   //获取日期
            //上午
            $am=$this->attendance_analysis_model->get_one_analysis($id,1,$dodate);
            if(empty($am))
            {
                $am[0]=array(
                    'iswork' =>1,
                    'state'=>4
                );
                $am[1]=array(
                    'iswork' =>1,
                    'state'=>4
                );
            }
            if($am[0]['iswork']==0)
            {
                $am_attendance[$i]='<font color="green">休</font>';
            }
            else
            {
                switch($am[0]['state'])
                {
                    case 1:
                        switch($am[1]['state'])
                        {
                            case 1:
                                $am_attendance[$i]='(<font color="green">正常</font>)'.$am[0]['optdt'].'--'.'(<font color="green">正常</font>)'.$am[1]['optdt'];
                                break;
                            case 3:
                                $am_attendance[$i]='(<font color="green">正常</font>)'.$am[0]['optdt'].'--'.'(早退)'.$am[1]['optdt'];
                                break;
                            case 4:
                                $am_attendance[$i]='(<font color="green">正常</font>)'.$am[0]['optdt'].'--<font color="red">未打卡</font>';
                                break;
                        };
                        break;
                    case 2:
                        switch($am[1]['state'])
                        {
                            case 1:
                                $am_attendance[$i]='(迟到)'.$am[0]['optdt'].'--'.'(<font color="green">正常</font>)'.$am[1]['optdt'];
                                break;
                            case 3:
                                $am_attendance[$i]='(迟到)'.$am[0]['optdt'].'--'.'(早退)'.$am[1]['optdt'];
                                break;
                            case 4:
                                $am_attendance[$i]='(迟到)'.$am[0]['optdt'].'--<font color="red">未打卡</font>';
                                break;
                        };
                        break;
                    case 4:
                        switch($am[1]['state'])
                        {
                            case 1:
                                $am_attendance[$i]='<font color="red">未打卡</font>--(<font color="green">正常</font>)'.$am[1]['optdt'];
                                break;
                            case 3:
                                $am_attendance[$i]='<font color="red">未打卡</font>--(早退)'.$am[1]['optdt'];
                                break;
                            case 4:
                                $am_attendance[$i]='<font color="red">未打卡</font>';
                                break;
                        };
                        break;
                }
            }
            //下午
            $pm=$this->attendance_analysis_model->get_one_analysis($id,2,$dodate);
            if(empty($pm))
            {
                $pm[0]=array(
                    'iswork' =>1,
                    'state'=>4
                );
                $pm[1]=array(
                    'iswork' =>1,
                    'state'=>4
                );
            }
            if($pm[0]['iswork']==0)
            {
                $pm_attendance[$i]='<font color="green">休</font>';
            }
            else
            {
                switch($pm[0]['state'])
                {
                    case 1:
                        switch($pm[1]['state'])
                        {
                            case 1:
                                $pm_attendance[$i]='(<font color="green">正常</font>)'.$pm[0]['optdt'].'--'.'(<font color="green">正常</font>)'.$pm[1]['optdt'];
                                break;
                            case 3:
                                $pm_attendance[$i]='(<font color="green">正常</font>)'.$pm[0]['optdt'].'--'.'(早退)'.$pm[1]['optdt'];
                                break;
                            case 4:
                                $pm_attendance[$i]='(<font color="green">正常</font>)'.$pm[0]['optdt'].'--<font color="red">未打卡</font>';
                                break;
                        };
                        break;
                    case 2:
                        switch($pm[1]['state'])
                        {
                            case 1:
                                $pm_attendance[$i]='(迟到)'.$pm[0]['optdt'].'--'.'(<font color="green">正常</font>)'.$pm[1]['optdt'];
                                break;
                            case 3:
                                $pm_attendance[$i]='(迟到)'.$pm[0]['optdt'].'--'.'(早退)'.$pm[1]['optdt'];
                                break;
                            case 4:
                                $pm_attendance[$i]='(迟到)'.$pm[0]['optdt'].'--<font color="red">未打卡</font>';
                                break;
                        };
                        break;
                    case 4:
                        switch($pm[1]['state'])
                        {
                            case 1:
                                $pm_attendance[$i]='<font color="red">未打卡</font>--(<font color="green">正常</font>)'.$pm[1]['optdt'];
                                break;
                            case 3:
                                $pm_attendance[$i]='<font color="red">未打卡</font>--(早退)'.$pm[1]['optdt'];
                                break;
                            case 4:
                                $pm_attendance[$i]='<font color="red">未打卡</font>';
                                break;
                        };
                        break;
                }
            }
        }
        $previous_month = date('Y-m', strtotime('-1 month', strtotime($pubdate)));
        $pnext_month = date('Y-m', strtotime('+1 month', strtotime($pubdate)));
        $data['previous_url']="index.php?d=admin&c=attendance&m=detail&id=$id&pubdate=$previous_month";
        $data['next_url']="index.php?d=admin&c=attendance&m=detail&id=$id&pubdate=$pnext_month";
        $data['pubdate']=$pubdate;
        $data['year']=$year;
        $data['month']=$month;
        $data['num_days']=$num_days;
        $data['first_day']=$first_day;
        $data['am_attendance']=$am_attendance;
        $data['pm_attendance']=$pm_attendance;
        $this->load->view('admin/attendance_detail',$data);
    }
    public function chart()
    {
        $id = $this->input->get('id')?$this->input->get('id'):$this->input->post('id');
        $data['teacher']=$this->teacher_base_model->get_one($id);
        $pubdate='';
        if ($this->input->post('pubdate') || $this->input->get('pubdate')) {
            $pubdate = $this->input->post('pubdate')?$this->input->post('pubdate'):$this->input->get('pubdate');
        }
        $where = ' iswork=1';
        $arr=$this->attendance_analysis_model->get_attendance_analysis($id,$pubdate,$where);
        if(empty($arr))
        {
            $num_days = date('t', strtotime($pubdate));// 31
            $arr[0]=array(
                'state'=>4,
                'num'=>$num_days*4,
                'uid'=>$id
            );
        }
        for($i=0;$i<4;$i++)
        {
            if(empty($arr[$i]))
            {
                $arr[$i]=array(
                    'state'=>$i,
                    'num'=>0,
                    'uid'=>$id
                    );
            }
        }
        $data['arr']=$arr;
        $data['pubdate']=$pubdate;
        $this->load->view('admin/attendance_chart', $data);

    }
    public function set()
    {
        $set_title=config_item('set_title');
        $pubdate=time();
        if ($this->input->post('dodate') || $this->input->get('dodate')) {
            $pubdate=$this->input->post('dodate')?$this->input->post('dodate'):$this->input->get('dodate');
            $pubdate = strtotime($pubdate);
        }
        $dodate=date('Y-m-d',$pubdate);
        $teacherid = 1;
        if ($this->input->post('uid') || $this->input->get('uid')) {
            $teacherid=$this->input->post('uid')?$this->input->post('uid'):$this->input->get('uid');
        }
        $truename = $this->teacher_base_model->get_one($teacherid)['truename'];//名字

        //$weeknum=date('w', $pubdate);//86400
        $data['date']=date('Y-m-d',$pubdate);
        //date('Y-m-d' , strtotime('Sun' , $pubdate));
        $sundaydate=date('Y-m-d' , strtotime('Sun' , $pubdate));

        $weekdate=array(
            1=>date("Y-m-d",strtotime("-6 day",strtotime($sundaydate))),
            2=>date("Y-m-d",strtotime("-5 day",strtotime($sundaydate))),
            3=>date("Y-m-d",strtotime("-4 day",strtotime($sundaydate))),
            4=>date("Y-m-d",strtotime("-3 day",strtotime($sundaydate))),
            5=>date("Y-m-d",strtotime("-2 day",strtotime($sundaydate))),
            6=>date("Y-m-d",strtotime("-1 day",strtotime($sundaydate))),
            7=>$sundaydate
        );
        // 构建一个空的table
        $table = array();
        foreach($set_title as $key=>$value)
        {
            $table[$key]['set_title']=$value;
            foreach($weekdate as $k=>$v)
            {
                //$table[$key]['weekmenu'][$sundaydate+$k]=$this->attendance_set_model->get_one_set($uid,$key,$sundaydate+$k);
                $table[$key][$k]=$this->attendance_set_model->get_one_set($teacherid,$key,$v);
            }

        }
        $data['weekdate'] = $weekdate;
        $data['table'] = $table;
        $data['teacherid']=$teacherid;
        $data['truename']=$truename;
        $_SESSION ['url_forward'] = $this->baseurl . "&m=set&dodate=$dodate&uid=$teacherid";
        $this->load->view ( 'admin/attendance_set',$data );
    }
    public function set_month()
    {
        $pubdate=date('Y-m',time());
        if ($this->input->post('pubdate') || $this->input->get('pubdate')) {
            $pubdate = $this->input->post('pubdate')?$this->input->post('pubdate'):$this->input->get('pubdate');
        }
        $teacherid = 1;
        if ($this->input->post('uid') || $this->input->get('uid')) {
            $teacherid=$this->input->post('uid')?$this->input->post('teacherid'):$this->input->get('teacherid');
        }
        $truename = $this->teacher_base_model->get_one($teacherid)['truename'];//名字
        $year = date('Y',strtotime($pubdate));
        $month = date('m',strtotime($pubdate));

        //取得天数
        $num_days = date("t",mktime(0,0,0,$month,1,$year));
        $list=array();
        //取得第一天是星期几
        $first_day = date("N",mktime(0,0,0,$month,1,$year));
        for ($i = 1; $i <= $num_days; $i++) {  //循环日期
            $j = $i;

            if (strlen($j) === 1) {
                $j = '0' . $j;
            }
            $dodate = $pubdate . '-' . $j;   //获取日期
            //上午

            $list[$i]= $this->attendance_set_model->get_set_by_teacherid($teacherid,$dodate);
        }

        $previous_month = date('Y-m', strtotime('-1 month', strtotime($pubdate)));
        $pnext_month = date('Y-m', strtotime('+1 month', strtotime($pubdate)));
        $data['previous_url']="index.php?d=admin&c=attendance&m=set_month&uid=$teacherid&pubdate=$previous_month";
        $data['next_url']="index.php?d=admin&c=attendance&m=set_month&uid=$teacherid&pubdate=$pnext_month";
        $data['pubdate']=$pubdate;
        $data['uid']=$teacherid;
        $data['truename']=$truename;
        $data['year']=$year;
        $data['month']=$month;
        $data['num_days']=$num_days;
        $data['first_day']=$first_day;
        $data['list']=$list;
        $_SESSION ['url_forward'] = $this->baseurl . "&m=set_month&pubdate=$pubdate&uid=$teacherid";
        $this->load->view ( 'admin/attendance_set_month',$data );
    }
    // 添加
    public function set_add ()
    {
        $teacherid = $_GET['teacherid'];
        $data['value']['teacherid'] =$teacherid;

        $dodate= $_GET['dodate'];

        $data['value']['dodate']=$dodate;

        $set_title= $_GET['set_title'];
        $data['value']['set_title']=$set_title;
        $data['value']=$this->teacher_base_model->append_item($data['value']);
        $result=$this->attendance_set_model->get_one_set($teacherid,$set_title,$dodate);
        if(!empty($result)) {//编辑
            $result['truename']=$data['value']['truename'];
           $d['value']=$result;
            $this->load->view('admin/attendance_set_edit', $d);
        }
        else
        {
            $data['begintime']='08:00';
            $data['endtime']='12:00';
            if($set_title==2)
            {
                $data['begintime']='14:00';
                $data['endtime']='17:30';
            }
            $this->load->view('admin/attendance_set_add', $data);
        }

    }
    public function set_dialog ()
    {
        $set_title=config_item('set_title');
        $teacherid = $_GET['teacherid'];
        $data['value']['teacherid'] =$teacherid;

        $date= $_GET['date'];

        $data['value']['date']=$date;
        foreach($set_title as $k=>$v)
        {
            $re=$this->attendance_set_model->get_one_set($teacherid,$k,$date);
            switch($k)
            {
                case 1:
                    if(empty($re))
                    {
                        $list[$k]['begintime']='08:00';
                        $list[$k]['endtime']='12:00';
                        $list[$k]['iswork']='1';
                    }
                    else
                    {
                        $list[$k]=$re;
                    }
                break;
                case 2:
                    if(empty($re))
                    {
                        $list[$k]['begintime']='14:00';
                        $list[$k]['endtime']='17:30';
                        $list[$k]['iswork']='1';
                    }
                    else
                    {
                        $list[$k]=$re;
                    }
                    break;
            }
            $list[$k]['set_title']=$v;
        }
        $data['list']=$list;
        $this->load->view('admin/attendance_set_month_add', $data);
    }
    // 保存 添加和修改
    public function set_save() {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $value = $_POST['value'];

        $schoolid = intval($this->schoolid);

        $value['schoolid'] = $schoolid;
        $arr=$this->attendance_analysis_model->get_one_analysis($value['uid'],$value['set_title'],$value['dodate']);

        if(isset($value['iswork']))//休息
        {
            $value['iswork']=0;
            if($arr)
            {
                foreach($arr as $val) {
                    $data = array(
                        'state' => 4,
                        'iswork' => 0,
                    );
                    $this->attendance_analysis_model->update($val['id'],$data);
                }
            }
        }
        else
        {
            $value['iswork']=1;
            if($arr)
            {
                //上班
                $begintime = $value['begintime'];
                $atime = date('H:i', strtotime("-1 hour", strtotime($begintime)));
                $btime = date('H:i', strtotime("+30 minute", strtotime($begintime)));
                $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                $record = $this->attendance_record_model->get_one_record($value['uid'], $value['dodate'], $where);
                if ($record) {
                    $etime = date('H:i', strtotime("+0 minute", strtotime($begintime)));
                    $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$etime'";
                    $record_data = $this->attendance_record_model->get_one_record($value['uid'], $value['dodate'],$where);
                    if ($record_data) {//正常
                        $data  = array(
                            'state' => 1,
                            'iswork' => 1
                        );
                        $this->attendance_analysis_model->update($arr[0]['id'],$data);
                    } else {
                        //迟到
                        $data  = array(
                            'state' => 2,
                            'iswork' => 1,
                        );
                        $this->attendance_analysis_model->update($arr[0]['id'],$data);
                    }
                } else {   //未打卡
                    $data  = array(
                        'state' => 4,
                        'optdt' => '00:00:00',
                        'iswork' => 1
                    );
                    $this->attendance_analysis_model->update($arr[0]['id'],$data);
                }
                //下班
                $endtime = $value['endtime'];
                $atime = date('H:i', strtotime("-30 minute", strtotime($endtime)));
                $btime = date('H:i', strtotime("+1 hour", strtotime($endtime)));
                $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                $record = $this->attendance_record_model->get_one_record($value['uid'], $value['dodate'], $where);
                if ($record) {
                    $stime = date('H:i', strtotime("+0 minute", strtotime($endtime)));
                    $where = " date_format(checktime , '%H:%i' ) between '$stime' AND '$btime'";
                    $record_data = $this->attendance_record_model->get_one_record($value['uid'], $value['dodate'],$where);
                    if ($record_data) {//正常
                        $data  = array(
                            'state' => 1,
                            'iswork' => 1
                        );
                        $this->attendance_analysis_model->update($arr[1]['id'],$data);
                    } else {
                        //迟到
                        $data  = array(
                            'state' => 3,
                            'iswork' => 1
                        );
                        $this->attendance_analysis_model->update($arr[1]['id'],$data);
                    }
                } else {   //未打卡
                    $data  = array(
                        'state' => 4,
                        'optdt' => '00:00:00',
                        'iswork' => 1
                    );
                    $this->attendance_analysis_model->update($arr[1]['id'],$data);
                }
            }
        }
        if($id) {
            $this->attendance_set_model->update($id,$value);
            show_msg ( '更新成功！',$_SESSION ['url_forward']);
        }
        else {
            $this->attendance_set_model->insert( $value);
            show_msg ( '添加成功！',$_SESSION ['url_forward']);
        }
    }
    public function set_month_save() {
        $teacherid = $this->input->post('teacherid');
        $date = $this->input->post('date');

        $schoolid = intval($this->schoolid);

        $set_title=config_item('set_title');
        foreach($set_title as $k=>$v)
        {
            $arr=$this->attendance_analysis_model->get_one_analysis($teacherid,$k,$date);
            $value = $_POST["value$k"];

            if($value['iswork']=='true')//休息
            {
                $iswork=0;
                if($arr)
                {
                    foreach($arr as $val) {
                        $data = array(
                            'status_name' => $v,
                            'pubdate' => $date,
                            'state' => 4,
                            'iswork' => 0,
                            'set_title' => $k
                        );
                        $this->attendance_analysis_model->update($val['id'],$data);
                    }
                }
            }
            else
            {
                $iswork=1;
                if($arr)
                {
                    switch ($k) {
                            case 1:   //上午上班
                                $begintime = $value['begintime'];
                                $atime = date('H:i', strtotime("-1 hour", strtotime($begintime)));
                                $btime = date('H:i', strtotime("+30 minute", strtotime($begintime)));
                                $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                $record = $this->attendance_record_model->get_one_record($teacherid, $date, $where);
                                if ($record) {
                                    $etime = date('H:i', strtotime("+0 minute", strtotime($begintime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$etime'";
                                    $record_data = $this->attendance_record_model->get_one_record($teacherid, $date, $where);
                                    if ($record_data) {//正常
                                        $data  = array(
                                            'uid' => $teacherid,
                                            'schoolid' => $schoolid,
                                            'status_name' => $v,
                                            'pubdate' => $date,
                                            'state' => 1,
                                            'optdt' => $record_data['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->update($arr[0]['id'],$data);
                                    } else {
                                        //迟到
                                        $data  = array(
                                            'uid' => $teacherid,
                                            'schoolid' => $schoolid,
                                            'status_name' => $v,
                                            'pubdate' => $date,
                                            'state' => 2,
                                            'optdt' => $record['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->update($arr[0]['id'],$data);
                                    }
                                } else {   //未打卡
                                    $data  = array(
                                        'uid' => $teacherid,
                                        'schoolid' => $schoolid,
                                        'status_name' => $v,
                                        'pubdate' => $date,
                                        'state' => 4,
                                        'optdt' => '00:00:00',
                                        'iswork' => 1,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->update($arr[0]['id'],$data);
                                }
                                //上午下班
                                $endtime = $value['endtime'];
                                $atime = date('H:i', strtotime("-30 minute", strtotime($endtime)));
                                $btime = date('H:i', strtotime("+1 hour", strtotime($endtime)));
                                $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                $record = $this->attendance_record_model->get_one_record($teacherid, $date, $where);
                                if ($record) {
                                    $stime = date('H:i', strtotime("+0 minute", strtotime($endtime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$stime' AND '$btime'";
                                    $record_data = $this->attendance_record_model->get_one_record($teacherid, $date, $where);
                                    if ($record_data) {//正常
                                        $data  = array(
                                            'uid' => $teacherid,
                                            'schoolid' => $schoolid,
                                            'status_name' => $v,
                                            'pubdate' => $date,
                                            'state' => 1,
                                            'optdt' => $record_data['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->update($arr[1]['id'],$data);
                                    } else {
                                        //迟到
                                        $data  = array(
                                            'uid' => $teacherid,
                                            'schoolid' => $schoolid,
                                            'status_name' => $v,
                                            'pubdate' => $date,
                                            'state' => 3,
                                            'optdt' => $record['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->update($arr[1]['id'],$data);
                                    }
                                } else {   //未打卡
                                    $data  = array(
                                        'uid' => $teacherid,
                                        'schoolid' => $schoolid,
                                        'status_name' => $v,
                                        'pubdate' => $date,
                                        'state' => 4,
                                        'optdt' => '00:00:00',
                                        'iswork' => 1,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->update($arr[1]['id'],$data);
                                }
                                break;
                            case 2://下午上班
                                $begintime = $value['begintime'];
                                $atime = date('H:i', strtotime("-1 hour", strtotime($begintime)));
                                $btime = date('H:i', strtotime("+30 minute", strtotime($begintime)));
                                $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                $record = $this->attendance_record_model->get_one_record($teacherid, $date, $where);
                                if ($record) {
                                    $etime = date('H:i', strtotime("+0 minute", strtotime($begintime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$etime'";
                                    $record_data = $this->attendance_record_model->get_one_record($teacherid, $date, $where);
                                    if ($record_data) {//正常
                                        $data  = array(
                                            'uid' => $teacherid,
                                            'schoolid' => $schoolid,
                                            'status_name' => $v,
                                            'pubdate' => $date,
                                            'state' => 1,
                                            'optdt' => $record_data['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->update($arr[0]['id'],$data);
                                    } else {
                                        //迟到
                                        $data  = array(
                                            'uid' =>$teacherid,
                                            'schoolid' => $schoolid,
                                            'status_name' => $v,
                                            'pubdate' => $date,
                                            'state' => 2,
                                            'optdt' => $record['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->update($arr[0]['id'],$data);
                                    }
                                } else {   //未打卡
                                    $data  = array(
                                        'uid' => $teacherid,
                                        'schoolid' => $schoolid,
                                        'status_name' => $v,
                                        'pubdate' => $date,
                                        'state' => 4,
                                        'optdt' => '00:00:00',
                                        'iswork' => 1,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->update($arr[0]['id'],$data);
                                }
                                //下午下班
                                $endtime = $value['endtime'];
                                $atime = date('H:i', strtotime("-30 minute", strtotime($endtime)));
                                $btime = date('H:i', strtotime("+1 hour", strtotime($endtime)));
                                $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                $record = $this->attendance_record_model->get_one_record($teacherid, $date, $where);
                                if ($record) {
                                    $stime = date('H:i', strtotime("+0 minute", strtotime($endtime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$stime' AND '$btime'";
                                    $record_data = $this->attendance_record_model->get_one_record($teacherid, $date, $where);
                                    if ($record_data) {//正常
                                        $data  = array(
                                            'uid' => $teacherid,
                                            'schoolid' => $schoolid,
                                            'status_name' => $v,
                                            'pubdate' => $date,
                                            'state' => 1,
                                            'optdt' => $record_data['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->update($arr[1]['id'],$data);
                                    } else {
                                        //早退
                                        $data  = array(
                                            'uid' => $teacherid,
                                            'schoolid' => $schoolid,
                                            'status_name' => $v,
                                            'pubdate' => $date,
                                            'state' => 3,
                                            'optdt' => $record['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->update($arr[1]['id'],$data);
                                    }
                                } else {   //未打卡
                                    $data  = array(
                                        'uid' => $teacherid,
                                        'schoolid' => $schoolid,
                                        'status_name' => $v,
                                        'pubdate' => $date,
                                        'state' => 4,
                                        'optdt' => '00:00:00',
                                        'iswork' => 1,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->update($arr[1]['id'],$data);
                                }
                                break;
                        }
                }
            }
            $re=$this->attendance_set_model->get_one_set($teacherid,$k,$date);
            $data=array(
                'uid'=>$teacherid,
                'schoolid'=>$schoolid,
                'addtime'=>time(),
                'set_title'=>$k,
                'begintime'=>$value['begintime'],
                'endtime'=>$value['endtime'],
                'dodate'=>$date,
                'iswork'=>$iswork
            );
            if($re)
            {
                $this->attendance_set_model->update($re['id'],$data);
            }
            else
            {
                $this->attendance_set_model->insert($data);
            }
        }
        echo 1;exit;
    }
    public function import()
    {
        $this->load->view ( 'admin/attendance_import');
    }
    /**
     *导入考勤
     */
    public function excelIn()
    {
        if($this->input->post('filename'))
        {
            $filename=$this->input->post('filename');
            require_once APPPATH . 'libraries/Spreadsheet_Excel_Reader.php'; // 加载类
            $data = new Spreadsheet_Excel_Reader (); // 实例化
            $data->setOutputEncoding('utf-8'); // 设置编码

            // 读取电子表格

            foreach($filename as $itemFile) {
                $data->read($itemFile); // read函数读取所需EXCEL表，支持中文
                $record = array();
                $schoolid = $this->schoolid;
                foreach ($data->sheets [0] ['cells'] as $key => $row) {
                    if (in_array($key, array(1, 2, 3))) continue; // 第一行是 标题 不用导入
                    $record ['uid'] = $row [3];
                    $record ['schoolid'] = $schoolid;
                    $record ['name'] = $row [4];
                    $n = intval(($row [7] - 25569) * 3600 * 24); //转换成1970年以来的秒数
                    $t = gmdate('Y-m-d H:i:s', $n);//格式化时间
                    $record ['checktime'] = $t;
                    $record ['type'] = 1;
                    $this->attendance_record_model->insert($record);
                }
            }
            echo 1;exit;
        }
    }
    // 首页
    public function analysis($cur_date)
    {
        $schoolid = $this->schoolid;
        $teacher = $this->teacher_base_model->get_list('*', "schoolid=$this->schoolid");
        $set_title = $this->config->item('set_title');
        //$attendance_type=$this->config->item('attendance_type');
        //$cur_date=date('Y-m',time());
        //$cur_date = '2015-07';
        //$num = cal_days_in_month(CAL_GREGORIAN, 8, 2015); // 31
        $num = date('t', strtotime($cur_date));// 31
        for ($i = 1; $i <= $num; $i++) {  //循环日期
            $dodate = $cur_date . '-' . $i;   //获取日期
            foreach ($teacher as $item) {   //循环教师
                foreach ($set_title as $k => $title) {
                    $set = $this->attendance_set_model->get_one_set($item['id'], $k, $dodate);
                    if ($set) {
                        if ($set['iswork'] == 0) {
                            //休息日
                            switch($k)
                            {
                                case 1:
                                    $data  = array(
                                        'uid' => $item['id'],
                                        'schoolid' => $schoolid,
                                        'status_name' => $title,
                                        'pubdate' => $dodate,
                                        'state' => 4,
                                        'optdt' => '08:00:00',
                                        'iswork' => 0,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->insert($data);
                                    $data  = array(
                                        'uid' => $item['id'],
                                        'schoolid' => $schoolid,
                                        'status_name' => $title,
                                        'pubdate' => $dodate,
                                        'state' => 4,
                                        'optdt' => '12:00:00',
                                        'iswork' => 0,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->insert($data);
                                    break;
                                case 2:
                                    $data  = array(
                                        'uid' => $item['id'],
                                        'schoolid' => $schoolid,
                                        'status_name' => $title,
                                        'pubdate' => $dodate,
                                        'state' => 4,
                                        'optdt' => '14:00:00',
                                        'iswork' => 0,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->insert($data);
                                    $data  = array(
                                        'uid' => $item['id'],
                                        'schoolid' => $schoolid,
                                        'status_name' => $title,
                                        'pubdate' => $dodate,
                                        'state' => 4,
                                        'optdt' => '18:00:00',
                                        'iswork' => 0,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->insert($data);
                                    break;
                            }

                        } else {
                            switch ($k) {
                                case 1:
                                    $begintime = $set['begintime'];
                                    $atime = date('H:i', strtotime("-1 hour", strtotime($begintime)));
                                    $btime = date('H:i', strtotime("+30 minute", strtotime($begintime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                    $record = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                    if ($record) {
                                        $etime = date('H:i', strtotime("+0 minute", strtotime($begintime)));
                                        $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$etime'";
                                        $record_data = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                        if ($record_data) {//正常
                                            $data  = array(
                                                'uid' => $item['id'],
                                                'schoolid' => $schoolid,
                                                'status_name' => $title,
                                                'pubdate' => $dodate,
                                                'state' => 1,
                                                'optdt' => $record_data['checktime'],
                                                'iswork' => 1,
                                                'set_title'=>$k
                                            );
                                            $this->attendance_analysis_model->insert($data);
                                        } else {
                                            //迟到
                                            $data  = array(
                                                'uid' => $item['id'],
                                                'schoolid' => $schoolid,
                                                'status_name' => $title,
                                                'pubdate' => $dodate,
                                                'state' => 2,
                                                'optdt' => $record['checktime'],
                                                'iswork' => 1,
                                                'set_title'=>$k
                                            );
                                            $this->attendance_analysis_model->insert($data);
                                        }
                                    } else {   //未打卡
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 4,
                                            'optdt' => '00:00:00',
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    }
                                    //上午下班
                                    $endtime = $set['endtime'];
                                    $atime = date('H:i', strtotime("-30 minute", strtotime($endtime)));
                                    $btime = date('H:i', strtotime("+1 hour", strtotime($endtime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                    $record = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                    if ($record) {
                                        $stime = date('H:i', strtotime("+0 minute", strtotime($endtime)));
                                        $where = " date_format(checktime , '%H:%i' ) between '$stime' AND '$btime'";
                                        $record_data = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                        if ($record_data) {//正常
                                            $data  = array(
                                                'uid' => $item['id'],
                                                'schoolid' => $schoolid,
                                                'status_name' => $title,
                                                'pubdate' => $dodate,
                                                'state' => 1,
                                                'optdt' => $record_data['checktime'],
                                                'iswork' => 1,
                                                'set_title'=>$k
                                            );
                                            $this->attendance_analysis_model->insert($data);
                                        } else {
                                            //迟到
                                            $data  = array(
                                                'uid' => $item['id'],
                                                'schoolid' => $schoolid,
                                                'status_name' => $title,
                                                'pubdate' => $dodate,
                                                'state' => 3,
                                                'optdt' => $record['checktime'],
                                                'iswork' => 1,
                                                'set_title'=>$k
                                            );
                                            $this->attendance_analysis_model->insert($data);
                                        }
                                    } else {   //未打卡
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 4,
                                            'optdt' => '00:00:00',
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    }
                                    break;
                                case 2://下午上班
                                    $begintime = $set['begintime'];
                                    $atime = date('H:i', strtotime("-1 hour", strtotime($begintime)));
                                    $btime = date('H:i', strtotime("+30 minute", strtotime($begintime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                    $record = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                    if ($record) {
                                        $etime = date('H:i', strtotime("+0 minute", strtotime($begintime)));
                                        $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$etime'";
                                        $record_data = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                        if ($record_data) {//正常
                                            $data  = array(
                                                'uid' => $item['id'],
                                                'schoolid' => $schoolid,
                                                'status_name' => $title,
                                                'pubdate' => $dodate,
                                                'state' => 1,
                                                'optdt' => $record_data['checktime'],
                                                'iswork' => 1,
                                                'set_title'=>$k
                                            );
                                            $this->attendance_analysis_model->insert($data);
                                        } else {
                                            //早退
                                            $data  = array(
                                                'uid' => $item['id'],
                                                'schoolid' => $schoolid,
                                                'status_name' => $title,
                                                'pubdate' => $dodate,
                                                'state' => 2,
                                                'optdt' => $record['checktime'],
                                                'iswork' => 1,
                                                'set_title'=>$k
                                            );
                                            $this->attendance_analysis_model->insert($data);
                                        }
                                    } else {   //未打卡
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 4,
                                            'optdt' => '00:00:00',
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    }
                                    //下午下班
                                    $endtime = $set['endtime'];
                                    $atime = date('H:i', strtotime("-30 minute", strtotime($endtime)));
                                    $btime = date('H:i', strtotime("+1 hour", strtotime($endtime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                    $record = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                    if ($record) {
                                        $stime = date('H:i', strtotime("+0 minute", strtotime($endtime)));
                                        $where = " date_format(checktime , '%H:%i' ) between '$stime' AND '$btime'";
                                        $record_data = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                        if ($record_data) {//正常
                                            $data  = array(
                                                'uid' => $item['id'],
                                                'schoolid' => $schoolid,
                                                'status_name' => $title,
                                                'pubdate' => $dodate,
                                                'state' => 1,
                                                'optdt' => $record_data['checktime'],
                                                'iswork' => 1,
                                                'set_title'=>$k
                                            );
                                            $this->attendance_analysis_model->insert($data);
                                        } else {
                                            //早退
                                            $data  = array(
                                                'uid' => $item['id'],
                                                'schoolid' => $schoolid,
                                                'status_name' => $title,
                                                'pubdate' => $dodate,
                                                'state' => 3,
                                                'optdt' => $record['checktime'],
                                                'iswork' => 1,
                                                'set_title'=>$k
                                            );
                                            $this->attendance_analysis_model->insert($data);
                                        }
                                    } else {   //未打卡
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 4,
                                            'optdt' => '00:00:00',
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    }
                                    break;
                            }
                        }
                    } else {
                        switch ($k) {
                            case 1:   //上午上班
                                $begintime = '08:00';
                                $atime = date('H:i', strtotime("-1 hour", strtotime($begintime)));
                                $btime = date('H:i', strtotime("+30 minute", strtotime($begintime)));
                                $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                $record = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                if ($record) {
                                    $etime = date('H:i', strtotime("+0 minute", strtotime($begintime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$etime'";
                                    $record_data = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                    if ($record_data) {//正常
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 1,
                                            'optdt' => $record_data['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    } else {
                                        //迟到
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 2,
                                            'optdt' => $record['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    }
                                } else {   //未打卡
                                    $data  = array(
                                        'uid' => $item['id'],
                                        'schoolid' => $schoolid,
                                        'status_name' => $title,
                                        'pubdate' => $dodate,
                                        'state' => 4,
                                        'optdt' => '00:00:00',
                                        'iswork' => 1,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->insert($data);
                                }
                                //上午下班
                                $endtime = '12:00';
                                $atime = date('H:i', strtotime("-30 minute", strtotime($endtime)));
                                $btime = date('H:i', strtotime("+1 hour", strtotime($endtime)));
                                $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                $record = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                if ($record) {
                                    $stime = date('H:i', strtotime("+0 minute", strtotime($endtime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$stime' AND '$btime'";
                                    $record_data = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                    if ($record_data) {//正常
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 1,
                                            'optdt' => $record_data['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    } else {
                                        //迟到
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 3,
                                            'optdt' => $record['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    }
                                } else {   //未打卡
                                    $data  = array(
                                        'uid' => $item['id'],
                                        'schoolid' => $schoolid,
                                        'status_name' => $title,
                                        'pubdate' => $dodate,
                                        'state' => 4,
                                        'optdt' => '00:00:00',
                                        'iswork' => 1,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->insert($data);
                                }
                                break;
                            case 2://下午上班
                                $begintime = '14:00';
                                $atime = date('H:i', strtotime("-1 hour", strtotime($begintime)));
                                $btime = date('H:i', strtotime("+30 minute", strtotime($begintime)));
                                $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                $record = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                if ($record) {
                                    $etime = date('H:i', strtotime("+0 minute", strtotime($begintime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$etime'";
                                    $record_data = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                    if ($record_data) {//正常
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 1,
                                            'optdt' => $record_data['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    } else {
                                        //早退
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 2,
                                            'optdt' => $record['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    }
                                } else {   //未打卡
                                    $data  = array(
                                        'uid' => $item['id'],
                                        'schoolid' => $schoolid,
                                        'status_name' => $title,
                                        'pubdate' => $dodate,
                                        'state' => 4,
                                        'optdt' => '00:00:00',
                                        'iswork' => 1,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->insert($data);
                                }
                                //下午下班
                                $endtime = '18:00';
                                $atime = date('H:i', strtotime("-30 minute", strtotime($endtime)));
                                $btime = date('H:i', strtotime("+1 hour", strtotime($endtime)));
                                $where = " date_format(checktime , '%H:%i' ) between '$atime' AND '$btime'";
                                $record = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                if ($record) {
                                    $stime = date('H:i', strtotime("+0 minute", strtotime($endtime)));
                                    $where = " date_format(checktime , '%H:%i' ) between '$stime' AND '$btime'";
                                    $record_data = $this->attendance_record_model->get_one_record($item['id'], $dodate, $where);
                                    if ($record_data) {//正常
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 1,
                                            'optdt' => $record_data['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    } else {
                                        //早退
                                        $data  = array(
                                            'uid' => $item['id'],
                                            'schoolid' => $schoolid,
                                            'status_name' => $title,
                                            'pubdate' => $dodate,
                                            'state' => 3,
                                            'optdt' => $record['checktime'],
                                            'iswork' => 1,
                                            'set_title'=>$k
                                        );
                                        $this->attendance_analysis_model->insert($data);
                                    }
                                } else {   //未打卡
                                    $data  = array(
                                        'uid' => $item['id'],
                                        'schoolid' => $schoolid,
                                        'status_name' => $title,
                                        'pubdate' => $dodate,
                                        'state' => 4,
                                        'optdt' => '00:00:00',
                                        'iswork' => 1,
                                        'set_title'=>$k
                                    );
                                    $this->attendance_analysis_model->insert($data);
                                }
                                break;
                        }
                    }
                }
            }
        }
    }
}