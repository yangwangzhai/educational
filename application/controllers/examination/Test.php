<?php

include APPPATH.'controllers/admin/Content.php';

/**
 * 试题库控制器
 * @author qcl 2016/01/06
 *
 */
class Test extends Content
{
    /**
     * 构造器
     */
    function __construct()
    {
        $class_name = 'question';
        $this->name = "试题库";
        $this->list_view = $class_name . '_list';
        $this->add_view = $class_name . '_add';
        $this->edit_view = $class_name . '_edit';
        $this->table = 'fly_' . $class_name;
        $this->baseurl = 'index.php?d=examination&c=Test'; // 本控制器的前段URL
        parent::__construct();

        $this->load->model('examination/Question_model');
    }

    function index()
    {
        //获取所有科目
        $query=$this->db->get("fly_subject");
        $data['subject'] = $query->result_array();
        $data['subject_select']=$this->input->get("subjectid");
        if(empty($data['subject_select'])){
            $data['subject_select']=$this->input->post("subjectid")?$this->input->post("subjectid"):1;
        }
        //取出当前选中的科目
        $res=$this->Question_model->get_column2("subject","fly_subject","id=$data[subject_select]");
        $data['subject_name']=$res['subject'];
        //根据科目获取对应的知识点
        $one=$this->Question_model->get_column("*","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=0");
        foreach($one as $key=>$value){
            $kk=$value['id'];
            $two[$kk]=$this->Question_model->get_column("*","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=$value[id]");
        }
        foreach($two as $key=>$value){
            foreach($value as $k=>$v){
                $kk=$v['id'];
                $three[$kk]=$this->Question_model->get_column("*","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=$v[id]");
            }
        }
        foreach($three as $key=>$value){
            foreach($value as $k=>$v){
                $kk=$v['id'];
                $four[$kk]=$this->Question_model->get_column("*","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=$v[id]");
            }
        }
        foreach($four as $key=>$value){
            foreach($value as $k=>$v){
                $kk=$v['id'];
                $five[$kk]=$this->Question_model->get_column("*","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=$v[id]");
            }
        }
        $data['one']=$one;
        $data['two']=$two;
        $data['three']=$three;
        $data['four']=$four;
        $data['five']=$five;
        //根据科目获取对应的题型
        $data['question_type']=$this->Question_model->get_column("*","fly_question_type","subjectid=$data[subject_select]");
        //获取难度系数
        $query=$this->db->get("fly_difficulty_degree");
        $data['difficulty_degree'] = $query->result_array();

        //接收 筛选的知识点id
        $data['knowledge_point_id']=$knowledge_pointid=$this->input->get("knowledge_point_id")?$this->input->get("knowledge_point_id"):'';
        $knowledge_pointid_str=$knowledge_pointid.",";
        if(!empty($knowledge_pointid)){
            $select_one=$this->Question_model->get_column("id","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=$knowledge_pointid");
        }
        if(!empty($select_one)){
            foreach($select_one as $select_one_key=>$select_one_value){
                $knowledge_pointid_str.=$select_one_value['id'].",";
                $select_two[$select_one_value['id']]=$this->Question_model->get_column("id","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=$select_one_value[id]");
            }
        }
        if(!empty($select_two)){
            foreach($select_two as $select_two_value){
                foreach($select_two_value as $vv){
                    $knowledge_pointid_str.=$vv['id'].",";
                    $select_three[$vv['id']]=$this->Question_model->get_column("id","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=$vv[id]");
                }
            }
        }
        if(!empty($select_three)){
            foreach($select_three as $select_three_value){
                foreach($select_three_value as $vv){
                    $knowledge_pointid_str.=$vv['id'].",";
                    $select_four[$vv['id']]=$this->Question_model->get_column("id","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=$vv[id]");
                }
            }
        }
        if(!empty($select_four)){
            foreach($select_four as $select_four_value){
                foreach($select_four_value as $vv){
                    $knowledge_pointid_str.=$vv['id'].",";
                    $select_five[$vv['id']]=$this->Question_model->get_column("id","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=$vv[id]");
                }
            }
        }
        if(!empty($select_five)){
            foreach($select_five as $select_five_value){
                foreach($select_five_value as $vv){
                    $knowledge_pointid_str.=$vv['id'].",";
                    $select_six[$vv['id']]=$this->Question_model->get_column("id","fly_knowledge_point","subjectid=$data[subject_select] AND p_id=$vv[id]");
                }
            }
        }
        $knowledge_pointid_str = substr($knowledge_pointid_str,0,strlen($knowledge_pointid_str)-1);
        //接收 筛选的题型id
        $data['question_typeid']=$question_typeid=$this->input->get("question_typeid");

        //接收 筛选的难度系数id
        $data['difficultyDegreeid']=$difficultyDegreeid=$this->input->get("difficultyDegreeid");

        //根据科目获取对应的试题
        $where="subjectid=$data[subject_select]";
        if(!empty($question_typeid)){
            $where .=" AND question_typeid=$question_typeid";
        }
        if(!empty($difficultyDegreeid)){
            $where .=" AND difficulty_degreeid=$difficultyDegreeid";
        }
        if(!empty($knowledge_pointid_str)){
            $where .=" AND knowledge_pointid IN ($knowledge_pointid_str)";
        }

        $data['question']=$this->Question_model->get_column("*","fly_question",$where);
        //根据子节点获取所有父节点
        if(!empty($knowledge_pointid)){
            $p_id=$this->Question_model->get_column2("p_id","fly_knowledge_point","id=$knowledge_pointid");
            $parent_node_arr = $this->Question_model->list_cate2($data['subject_select'],$p_id['p_id']);
            $num=count($parent_node_arr)-1;
            for($num;$num>=0;$num--){
                $parent_node[]=$parent_node_arr[$num]['id'];
            }
        }
        $data['parent_node']=$parent_node;

        $this->load->view("examination/".$this->list_view,$data);
    }

    public function question_add(){
        //获取所有科目
        $query=$this->db->get("fly_subject");
        $data['subject'] = $query->result_array();
        //获取难度系数
        $query=$this->db->get("fly_difficulty_degree");
        $data['difficulty_degree'] = $query->result_array();

        $this->load->view("examination/".$this->add_view,$data);
    }

    //异步获取知识点分类信息、题型
    public function get_knowledge_catogery_questionType(){
        $subjectid=$this->input->post('subjectid');
        //知识点
        $data['catogery']=$this->Question_model->list_cate($subjectid);
        //题型
        $data['question_type']=$this->Question_model->get_column("*","fly_question_type","subjectid=$subjectid");
        echo json_encode($data);
    }

    public function knowledge(){
        //获取所有科目
        $query=$this->db->get("fly_subject");
        $data['subject'] = $query->result_array();
        $data['subject_select']=$this->input->post("subjectid")?$this->input->post("subjectid"):1;
        //取出当前选中的科目
        $res=$this->Question_model->get_column2("subject","fly_subject","id=$data[subject_select]");
        $data['subject_name']=$res['subject'];
        $list=$temp=$this->Question_model->list_cate($data['subject_select']);
        foreach($list as &$l){
            $child=$l['id'].',';
            foreach($temp as $t){
                if($l['id']==$t['p_id']){
                    $child .=$t['id'].',';
                }
            }
            $l['child_node']=$child;
        }
        $data['list']=$list;

        $this->load->view("examination/knowledge_list",$data);
    }

    public function knowledge_add(){
        //获取所有科目
        $query=$this->db->get("fly_subject");
        $data['subject'] =$result= $query->result_array();
        $data['cates']=$this->Question_model->list_cate($result[0]['id']);
        $this->load->view("examination/knowledge_add",$data);
    }

    public function knowledge_edit(){
        $data['id']=$this->input->get("id");
        $data['p_id']=$this->input->get("p_id");
        $data['knowledge_point']=$this->input->get("knowledge_point");
        $data['subject_select']=$this->input->get("subject_select");
        //获取所有科目
        $query=$this->db->get("fly_subject");
        $data['subject'] =$result= $query->result_array();
        $data['cates']=$this->Question_model->list_cate($data['subject_select']);

        $this->load->view("examination/knowledge_edit",$data);
    }

    //异步获取知识点分类信息
    public function get_knowledge_catogery(){
        $subjectid=$this->input->post('subjectid');
        $catogery=$this->Question_model->list_cate($subjectid);
        echo json_encode($catogery);
    }

    public function knowledge_save(){
        $value=$this->input->post("value");
        $this->Question_model->db_insert_table("fly_knowledge_point",$value);
        $_SESSION ['url_forward']=$this->baseurl."&m=knowledge";
        show_msg ( '添加成功！', $_SESSION ['url_forward'] );
    }

    public function knowledge_edit_save(){
        $id=$this->input->post("id");
        $value=$this->input->post("value");
        $this->Question_model->update2($id,"fly_knowledge_point",$value);
        $_SESSION ['url_forward']=$this->baseurl."&m=knowledge";
        show_msg ( '更新成功！', $_SESSION ['url_forward'] );
    }

    public function knowledge_delete(){
        $delete['id']=$this->input->get("id");
        $this->Question_model->db_delete2("fly_knowledge_point",$delete);
        $_SESSION ['url_forward']=$this->baseurl."&m=knowledge";
        show_msg ( '删除成功！', $_SESSION ['url_forward'] );
    }

    public function question_save(){
        $data=$this->input->post("value");
        $this->Question_model->db_insert_table("fly_question",$data);
        $_SESSION ['url_forward']=$this->baseurl."&m=knowledge";
        show_msg ( '添加成功！', $_SESSION ['url_forward'] );
    }



















}