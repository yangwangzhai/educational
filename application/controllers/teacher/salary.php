<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

// 薪酬信息

include 'content.php';

class Salary extends Content
{

    function __construct ()
    {
        $class_name = 'salary';
        $this->name = '薪酬信息';
        $this->list_view = $class_name.'_list';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=salary'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('salary_model');
    }

    // 首页
    public function index() {
        $teacherid=$this->teacherid;
        $searchsql = "1 AND teacherid=$teacherid";

        $year=date('Y',time());
        if ($this->input->get('year')) {
            $year = $this->input->get('year');
        }
        $month=date('m',time());
        if ( $this->input->get('month')) {
            $month = $this->input->get('month');
        }
        $this->baseurl .= "&month=" . rawurlencode ( $year)."&month=" . rawurlencode ( $month);
        $searchsql .= " AND YEAR='$year' AND MONTH='$month' ";

        $data ['list'] = array ();
        $count = $this->salary_model->counts($searchsql);
        $data['count'] = $count;

        $this->config->load ( 'pagination', TRUE );
        $pagination = $this->config->item ( 'pagination' );
        $pagination ['base_url'] = $this->baseurl;
        $pagination ['total_rows'] = $count;
        $this->load->library ( 'pagination' );
        $this->pagination->initialize ( $pagination );
        $data ['pages'] = $this->pagination->create_links ();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;

        $list = $this->salary_model->get_list('*',$searchsql,$offset,20);



        $data['year']=$year;
        $data['month']=$month;
        $data['list']=$list;

        $_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view ( 'teacher/' . $this->list_view, $data );
    }




    function export()
    {
        $data['year']=date('Y',time());
        $data['month']=date('m',time());
        $this->load->view('teacher/salary_export',$data);
    }
    function export_save()
    {
        $teacherid=$this->teacherid;
        $searchsql = "1 AND teacherid=$teacherid";
        $data=trims($this->input->post('value'));
        $year=$data['year'];
        $month=$data['month'];
        if($year=='')
        {
            show_msg('年份不能为空！');
        }
        if($month=='')
        {
            show_msg('月份不能为空！');
        }
        $searchsql .= " AND YEAR='$year' AND MONTH='$month' ";
        $data['list'] = $this->salary_model->get_list('*',$searchsql,0,1);
        $this->load->view('teacher/salary_export_detail',$data);
    }
    /**
     * 编辑
     */
    public function chart ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        // 这条信息
        $value = $this->salary_model->get_one($id);
        $data ['value'] = $value;
        $data['id'] = $id;
        $this->load->view('teacher/salary_chart', $data);
    }
}
