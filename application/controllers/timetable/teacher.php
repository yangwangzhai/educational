<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// 老师信息
include 'member.php';
//调用Reader
require_once 'Spreadsheet_Excel_Reader.php';
class teacher extends member {
	
	public $class_list = array();  // 班级

	function __construct() {
		$this->name = '教师';
		$this->control = 'teacher';
		$this->baseurl = 'index.php?d=admin&c=teacher';
		$this->table = 'fly_member';
		$this->list_view = 'teacher_list'; // 列表页
		$this->add_view = 'teacher_add'; // 添加页
		parent::__construct ();
    }
	
	// 首页
	public function index() {
        $term=$this->session->userdata('term');
        $school_type=$this->session->userdata('school_type');
        $searchsql = "schoolid='$this->schoolid' AND m.term=$term AND m.school_type=$school_type";

		$data ['list'] = array ();
		$query = $this->db->query ( "SELECT COUNT(*) AS num FROM $this->table m WHERE $searchsql" );
		$count = $query->row_array ();
		$data ['count'] = $count ['num'];
		
		$this->config->load ( 'pagination', TRUE );
		$pagination = $this->config->item ( 'pagination' );
		$pagination ['base_url'] = $this->baseurl."&m=index&term=$term";
		$pagination ['total_rows'] = $count ['num'];
		$this->load->library ( 'pagination' );
		$this->pagination->initialize ( $pagination );
		$data ['pages'] = $this->pagination->create_links ();
		
		$offset = $_GET ['per_page'] ? intval ( $_GET ['per_page'] ) : 0;
		$sql = "SELECT m.*,t.manage_class,t.teach_class,t.course,t.teacher_num FROM $this->table m left join fly_teacher t on m.id=t.id WHERE m.$searchsql ORDER BY m.id DESC limit $offset,$this->per_page";

		$query = $this->db->query ( $sql );
		$list = $query->result_array ();
		
		$data ['list'] = $list;

		$_SESSION ['url_forward'] = $this->baseurl . "&per_page=$offset";
		$this->load->view( 'admin/' . $this->list_view, $data );
	}
	
	// 添加
	public function add() {
        // 根据session中的schoolid，接收到的‘学期’ 从fly_class表获取每个年级的所有班级
        $term=$this->session->userdata('term');
        $school_type=$this->session->userdata('school_type');
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type";
        $column="classes";
        $table="fly_class";
        $class_arr = $this->class_model->get_column($column,$table,$where);

        foreach ($class_arr as $row){
            foreach ($row as $key=>$value){
                $data['list'][] = explode(",",setClassname($value)) ;
            }
        }
		$teach_class = array();
		$manage_class = array();
		$data['value']['birthday'] = '1970-01-01';
        $data['teach_class']=$teach_class;
        $data['manage_class']=$manage_class;

		$this->load->view ( 'admin/' . $this->add_view, $data );
	}
	
	// 编辑
	public function edit() {
        // 根据session中的schoolid，接收到的‘学期’ 从fly_class表获取每个年级的所有班级
        $term=$this->session->userdata('term');
        $school_type=$this->session->userdata('school_type');
        $where="schoolid=$this->schoolid AND term=$term AND school_type=$school_type";
        $column="classes";
        $table="fly_class";
        $class_arr = $this->class_model->get_column($column,$table,$where);

        foreach ($class_arr as $row){
            foreach ($row as $key=>$value){
                $data['list'][] = explode(",",setClassname($value)) ;
            }
        }
		$id = intval ( $_GET ['id'] );
		// 这条信息
		$query = $this->db->get_where ( $this->table, 'id = ' . $id, 1 );
		$value = $query->row_array ();
		
		$query = $this->db->get_where('fly_teacher', 'id = ' . $id, 1);
		$teacher = $query->row_array();

        $teach_class='';
        $manage_class='';
		$manage_class = explode('，', setClassname($teacher['manage_class']));
        $teach_class = explode('，', setClassname($teacher['teach_class']));
        $manage_class=explode(",",$manage_class[0]);
        $teach_class=explode(",",$teach_class[0]);

		$data ['id'] = $id;	
		$data['value'] = $value;
		$data['teacher'] = $teacher;
		$data['manage_class'] = $manage_class;
		$data['teach_class'] = $teach_class;

        $this->load->view ( 'admin/' . $this->add_view, $data );
	}
	
	// 保存 添加和修改都是在这里
	public function save() {
		$id = intval ( $_POST ['id'] );
		$data = trims ( $_POST ['value'] );
        $data['schoolid'] = $this->schoolid;
        $data['term']=$this->session->userdata('term');
		$data['school_type']=$this->session->userdata('school_type');

		// 附表
		$teacher = $_POST ['teacher'];
        $teacher['schoolid'] = $this->schoolid;
        $teacher['term']=$this->session->userdata('term');
        $teacher['school_type']=$this->session->userdata('school_type');
		$teacher['teach_class'] = $teacher['manage_class'] = '';
        //中文逗号转换为英文逗号
        $teacher['course']=str_replace("，",",",$teacher['course']);

		$manage = $_POST ['manage'];
		if(!empty($manage)) $teacher['manage_class'] = join(',', getNumber($manage));
		$class = $_POST ['class'];
		if(!empty($class)) $teacher['teach_class'] = join(',', getNumber($class));

		if ($id) { // 修改 ===========
			$this->db->where ( 'id', $id );
			$query = $this->db->update ( $this->table, $data );
			$this->db->where ( 'id', $id );
			$query = $this->db->update ( 'fly_teacher', $teacher);

            $term=$this->session->userdata('term');
			show_msg ( '修改成功！', $this->baseurl."&m=index&term=$term" );
			
		} else { // ===========添加 ===========
			$query = $this->db->insert ( $this->table, $data );
			$insert_id = $this->db->insert_id();

			// 插入附表
			$teacher['id'] =$insert_id;
			$this->db->insert('fly_teacher', $teacher);

			$term=$this->session->userdata('term');
			show_msg ( '添加成功！', $this->baseurl."&m=index&term=$term" );
		}
	}

	// 删除
	public function delete ()
	{
        $term=$this->session->userdata('term');
		$id = $_GET['id'];
	
		if ($id) {
			$this->db->query("delete from $this->table where id=$id");
			$this->db->query("delete from fly_teacher where id=$id");
		} else {
			$ids = implode(",", $_POST['delete']);
			$this->db->query("delete from $this->table where id in ($ids)");
			$this->db->query("delete from fly_teacher where id in ($ids)");
		}
		show_msg('删除成功！', $this->baseurl."&m=index&term=$term");
	}
	
	// 导出Excel
	public function excelOut ()
	{
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->session->userdata('school_type');
		$data['list']=$this->teacher_model->get_all_message($schoolid,$term,$school_type);

        $this->load->view('admin/out_teacher_message', $data);
    }

    public function excel_import_list()
    {
        $this->load->view('admin/excel_import_list');
    }

    public function excel_import_save()
    {
        $schoolid=$this->schoolid;
        $term=$this->session->userdata('term');
        $school_type=$this->session->userdata('school_type');
        $thumb=$this->input->post('thumb');
        //创建 Reader
        $data = new Spreadsheet_Excel_Reader();
        //设置文本输出编码
        $data->setOutputEncoding('utf-8');
        //读取Excel文件
        $data->read($thumb);
        $data=$data->sheets [0] ['cells'];
        $title=$data[2];

        $replace=array(    1=>'truename',
                            2=> 'course',
                            3=>'teacher_num',
                            4=>'manage_class',
                            5=>'teach_class',
                            );
        foreach($title as $key=>$value){
            $title[$key]=$replace[$key];
        }

        foreach ($data as $key => $row){
            foreach($row as $k=>$col){
                if($key>2){
                    if($title[$k]=='truename'){
                        $member[$key][$title[$k]]=$col;
                        $member[$key]['schoolid'] =$schoolid;
                        $member[$key]['term'] =$term;
                        $member[$key]['school_type'] =$school_type;
                    }else{
                        $teacher[$key][$title[$k]]=$col;
                        $teacher[$key]['schoolid'] =$schoolid;
                        $teacher[$key]['term'] =$term;
                        $teacher[$key]['school_type'] =$school_type;
                    }
                }
            }
        }

        //先插入 fly_member表
        $insert_id=$this->teacher_model->excel_import_member($member);
        //插入 fly_teacher表
        foreach($teacher as $key=>$value){
            $teacher[$key]['id']=$insert_id[$key]['id'];
        }
        $this->teacher_model->excel_import_teacher($teacher);

        show_msg ( '添加成功！', $this->baseurl."&m=index&term=$term" );
        
    }










}


