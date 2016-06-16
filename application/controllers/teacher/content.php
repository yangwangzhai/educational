<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 父类 控制器 by tangjian $_SESSION['url_forward'] 上页的URL,用来 修改和 删除后做跳转的
include 'base.php';
class Content extends base
{
	public $name = '内容'; // 控制器中文名称
    public $control = 'content'; // 控制器名称
    public $baseurl = 'index.php?d=manager&c=content'; // 本控制器的前段URL
    public $table = 'fly_content'; // 数据库表名称
    public $list_view = 'content_list'; // 列表页
    public $add_view = 'content_add'; // 添加页  
    public $per_page = 20; // 每页显示20条    
    public  $status = array(); // 状态
    
    function __construct ()
    {
        parent::__construct();       
       
        if (empty($this->teacherid)) {
            show_msg('请先登录', 'index.php?d=admin&c=common&m=login');
        }
        
        $this->status = $this->config->item('status');
    }
    
    // 首页
    public function index ()
    {        
    	
        $searchsql = '1';
       
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
        
        if ($catid) {
            $this->baseurl .= "&catid=$catid";
            $searchsql .= " AND catid='$catid' ";
        }
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND title like '%{$keywords}%' ";
        }
         
        $data['list'] = array();
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM $this->table WHERE $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        
  
                
        $this->config->load('pagination', TRUE);       
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count['num'];        
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

     
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;       
        $sql = "SELECT * FROM $this->table WHERE $searchsql ORDER BY id DESC limit $offset,$this->per_page";
       	
		$query = $this->db->query($sql);
//    		$schoo_list = $this->school_model->lists();
//    		print_r($schoo_list);
   		
   		$list = $query->result_array();
// 		foreach($list as &$value) {
// 			$value['schoolname'] = $schoo_list[$value['schoolid']];	
// 		}
        $data['list'] = $list;        
//         $data['catid'] = $catid;
        
        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('manager/' . $this->list_view, $data);   /**/
    }
    
    // 添加
    public function add ()
    {
        $value['catid'] = intval($_REQUEST['catid']);
        $category = get_cache('category');
        $value['catname'] = $category[$value['catid']]['name'];
        $data['value'] = $value;
        
        $this->load->view('manager/' . $this->add_view, $data);
    }
    
    // 编辑
    public function edit ()
    {
        $id = intval($_GET['id']);
        
        // 这条信息
        $query = $this->db->get_where($this->table, 'id = ' . $id, 1);
        $value = $query->row_array();
        $category = get_cache('category');
        $value['catname'] = $category[$value['catid']]['name'];
        $data['value'] = $value;
        
        $data['id'] = $id;
        
        $this->load->view('manager/' . $this->add_view, $data);
    }
    
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        
        if ($data['title'] == "") {
            show_msg('标题不能为空');
        }
        
        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update($this->table, $data);
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['addtime'] = time();
            $query = $this->db->insert($this->table, $data);
            show_msg('添加成功！', $_SESSION['url_forward']);
        }
    }
    
    // 删除
    public function delete ()
    {
        $id = $this->input->get('id')?$this->input->get('id'):'';
        if ($id) {
            $this->db->query("delete from $this->table where id=$id");
        } else {
            $ids = implode(",", $_POST['delete']);
            $this->db->query("delete from $this->table where id in ($ids)");
        }
        show_msg('删除成功！', $_SESSION['url_forward']);
    }
    
    // 审核
    public function updatestatus()
    {
        $id = intval($_GET['id']);
        $status = intval($_GET['status']);
    	
        if ($id && strlen($status)) {
            $this->db->query("update $this->table set status='$status' where id='$id' limit 1");
            echo $id;
            exit;
        }
        echo -1;
    }
    
    
    // 导出Excel
    public function excelOut ()
    {
        $query = $this->db->query(
                "select id,title,addtime from $this->table where catid='$_GET[catid]'");
        $list = $query->result_array();
        $table_data = '<table border="1"><tr>
      			<th colspan="3">标题在这里哦</th>
    			</tr>';
        
        header('Content-Type: text/xls');
        header("Content-type:application/vnd.ms-excel;charset=utf-8");
        // $str = mb_convert_encoding($file_name, 'gbk', 'utf-8');
        header('Content-Disposition: attachment;filename="范德萨发的说法.xls"');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        
        foreach ($list as $line) {
            $table_data .= '<tr>';
            
            foreach ($line as $key => &$item) {
                // $item = mb_convert_encoding($item, 'gbk', 'utf-8');
                $table_data .= '<td>' . $item . '</td>';
            }
            $table_data .= '</tr>';
        }
        $table_data .= '</table>';
        echo $table_data;
    }
    
    // 导入Excel
    public function excelIn ()
    {
        require_once APPPATH . 'libraries/Spreadsheet_Excel_Reader.php';
        // require_once 'Excel/reader.php'; //加载所需类
        $data = new Spreadsheet_Excel_Reader(); // 实例化
        $data->setOutputEncoding('utf-8'); // 设置编码
        $data->read('test.xls'); // read函数读取所需EXCEL表，支持中文
        print_r($data->sheets[0]['cells']);
        exit();
    }
}
