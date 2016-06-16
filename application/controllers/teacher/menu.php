<?php

if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 食谱

include 'content.php';
class menu extends Content {

    function __construct() {
        $class_name = 'menu';
        $this->name = "食谱";
        $this->list_view = $class_name.'_list';
        $this->add_view = $class_name.'_add';
        $this->edit_view = $class_name.'_edit';
        $this->table = 'fly_'.$class_name;
        $this->baseurl = 'index.php?d=teacher&c=menu'; // 本控制器的前段URL
        parent::__construct ();

        $this->load->model ( 'menu_model' );
        $this->load->model ( 'classroom_model' );
    }

    public function index() {
        if( get_cookie ('classname')==null)
        {
            show_msg('没有找到你的班级 请先设置班级！', 'index.php?d=teacher&c=class_list&m=index');
        }
        else
        {
            $classname = get_cookie('classname');
            $class = $this->classroom_model->get_class_by_classname($classname);
            $classid=$class['id'];
        }
        //$week = config_item('week');
        $mealtime=config_item('mealtime');
        $pubdate=time();
        if ($this->input->post('pubdate')) {
            $pubdate = strtotime($this->input->post('pubdate'));
        }

        //$weeknum=date('w', $pubdate);//86400
        $data['date']=date('Y-m-d',$pubdate);

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
        // 构建一个空的菜谱
        $table = array();
        foreach($mealtime as $key=>$value)
        {
            $table[$key]['mealtime']=$value;
            foreach($weekdate as $k=>$v)
            {
                $table[$key][$k]=$this->menu_model->get_one_menu($classid,$key,$v);
            }

        }
        $data['weekdate'] = $weekdate;
        $data['table'] = $table;
        $data['classid']=$classid;
        $data['classname']=$class['nickname'];
        $this->load->view ( 'teacher/' . $this->list_view,$data );
    }

    // 添加
    public function add ()
    {
        $classid = $_GET['classid'];
        $data['value']['classid'] =$classid;

        $pubdate= $_GET['pubdate'];

        $data['value']['pubdate']=$pubdate;

        $meal= $_GET['meal'];
        $data['value']['meal']=$meal;
        $data['value']=$this->classroom_model->append_item($data['value']);
        $value=$this->menu_model->get_one_menu($classid,$meal,$pubdate);
        if(!empty($value)) {//编辑
            $data['id'] = $value['id'];
            $data['value']['thumb'] = explode(',', $value['thumb']);
            $data['value']['content'] = explode(',', $value['content']);
            $data['value']['addinfo'] = explode(',', $value['addinfo']);
            $this->load->view('teacher/' . $this->edit_view, $data);
        }
        else
        {
            $this->load->view('teacher/' . $this->add_view, $data);
        }

    }

    // 保存 添加和修改
    public function save() {
        $id = $this->input->post('id')?intval($this->input->post('id')):'';
        $value = $_POST['value'];
        $classid=$value['classid'];
        $pubdate=$value['pubdate'];
        $meal=$value['meal'];

        $contents = implode(',', array_filter($value['content']));
        $thumbs = implode(',', array_filter($value['thumb']));
        $addinfos = implode(',', array_filter($value['addinfo']));

        $schoolid = intval($this->schoolid);

        $data['schoolid'] = $schoolid;
        $data['classid'] = $classid;
        $data['pubdate'] = $pubdate;
        $data['meal'] = $meal;
        $data['thumb'] = $thumbs;
        $data['content'] = $contents;
        $data['addinfo'] = $addinfos;



        if($id) {
            foreach ($value['thumb'] as $item) {
                if($item) {
                    thumb ( $item, 100, 100 );
                }
            }
            $this->menu_model->update($id, $data);
            show_msg ( '更新成功！');
        }
        else {
            foreach ($value['thumb'] as $item) {
                if($item) {
                    thumb ( $item, 100, 100 );
                }
            }
            $this->menu_model->insert( $data);
            show_msg ( '添加成功！');
        }
    }
}
