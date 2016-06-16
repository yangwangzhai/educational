<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type: text/html; charset=utf-8"); 
error_reporting(E_ALL ^ E_NOTICE);
class Index extends CI_Controller {

	public $table;
	public function __construct()
	{
		parent::__construct();
		/* $this->load->helper('url');
		$this->load->helper('common'); */
		//if(empty($_SESSION['admin']))
		//{
		//	header("Location:".base_url()."index.php?d=admin&c=admin&m=index");
		//	}
// 		$this->load->library('UploadFile');
// 		$this->load->model('forehead');
// 		$this->load->model('info');		
		
	}
	
	public function index() {
		echo mother;
	}
	
	public function show()
	{
		echo "我是主页！";
		
//  		$data = array();
// 		$pics = $this->db->query("select id,name,src from information where category_id='17' and src!='' and src!='0' order by id desc limit 5")->result_array();
// 		foreach($pics as $k=>$row){
			
// 			if(!empty($row['src'])){
// 				$data['pics'][$k]['id']=$row['id'];
// 				$data['pics'][$k]['name']=$row['name'];
// 				//$test = pathinfo($row['src']);
// 				//print_r($test['filename']."_100_100.".$test['extension']);exit;
// 				$src = getImagePath($row['src'],'min');
// 				$data['pics'][$k]['src']=$src;
// 			}
// 		}
// 		//显示管理员回复内容
// 		$arr=array('user_id'=>$_SESSION['user']['id'],'role'=>1);
// 		$list=$this->forehead->educount('message',$arr);
// 		$data['list']=$list;
// 		//首页红岭社区资讯部分第一条
// 		$first=$this->forehead->select('information');
		
// 		foreach($first as $k=>$row){
// 			if($row['role']==1)
// 			{
// 			$data['first']['id']=$row['id'];
// 			$data['first']['name']=$row['name'];
// 			$data['first']['addtime']=date('Y-m-d',$row['addtime']);
// 			}
// 		}//print_r($data['first']);exit;*/
		
// 		//首页红岭社区资讯部分
// 		$inform=$this->forehead->select_inform('information',6,17);
		
// 		foreach($inform as $k=>$row){
// 			$data['inform'][$k]['id']=$row['id'];
// 			$data['inform'][$k]['name']=$row['name'];
// 			$data['inform'][$k]['addtime']=date('Y-m-d',$row['addtime']);
// 		}
		
// 		//首页红岭社区公告部分
// 		$notice=$this->forehead->select_notice('information',8,17);
// 		foreach($notice as $k=>$row){
// 			$data['notice'][$k]['id']=$row['id'];
// 			$data['notice'][$k]['name']=$row['name'];
// 			$data['notice'][$k]['addtime']=date('Y-m-d',$row['addtime']);
// 		}
		 
		
// 		//首页社会责任展示部分
// 		$duty=$this->forehead->select_table('show_s',8);
// 		foreach($duty as $k=>$row){
// 			$data['duty'][$k]['id']=$row['id'];
// 			$data['duty'][$k]['show']=$row['show'];
// 			$data['duty'][$k]['text']=$row['text'];
			
// 			$info = pathinfo($row['src']);
// 			$pics = $info['dirname']."/".$info[filename]."_150_150.".$info['extension'];
// 			$data['duty'][$k]['src']=$pics;
// 		}
		
// 		//首页的服务菜单
// 		$service=$this->forehead->select_service('service',4);
// 		foreach($service as $k=>$row){
// 			$data['service'][$k]['id']=$row['id'];
// 			$data['service'][$k]['service'] =$row['service'];
// 			$data['service'][$k]['develop'] = sgmdate($row['develop']);
// 			$data['service'][$k]['title']   = strlen($row['service'])>43?utf_substr($row['service'],43)."...":utf_substr($row['service'],43);
// 		}
		
// 		//首页的服务认领
// 		$claim = $this->forehead->select_claim('service',4);
// 		foreach($claim as $k=>$row){
// 			$data['claim'][$k]['id']      = $row['id'];
// 			$data['claim'][$k]['name']    = $row['name'];
// 			$data['claim'][$k]['service'] = $row['service'];
// 			$data['claim'][$k]['addtime'] = sgmdate($row['addtime']);
// 			$data['claim'][$k]['title']   = strlen($row['service'])>43?utf_substr($row['service'],43)."...":utf_substr($row['service'],43);
// 		}
		
// 		//首页的服务评价
// 		$juge = $this->db->query("select c.*,m.name,s.service,s.ismenu from service_comments c 
// 			left join partymember m on c.user_id=m.id 
// 			left join service s on c.service_id=s.id 
// 			order by c.addtime desc limit 4")->result_array();
// 		foreach($juge as $k=>$row){
// 			$data['juge'][$k]['id']      = $row['service_id'];
// 			$data['juge'][$k]['name']    = $row['name'];
// 			$data['juge'][$k]['service'] = $row['service'];
// 			$data['juge'][$k]['times']   = sgmdate($row['addtime']);
// 			$data['juge'][$k]['level']   = $row['level'];
// 			$data['juge'][$k]['ismenu']  = $row['ismenu'];
// 			$data['juge'][$k]['title']   = strlen($row['service'])>12?utf_substr($row['service'],12)."...":utf_substr($row['service'],12);
// 		}
		
// 		//首页的办事指南
// 		$compass=$this->forehead->select_table('guide',8);
// 		foreach($compass as $k=>$row){
// 			$data['compass'][$k]['id']=$row['id'];
// 			$data['compass'][$k]['name']=$row['name'];
// 			//$data['list'][$k]['endtime']=date('Y-m-d',$row['endtime']);
// 		}
		
// 		//首页图片资讯
// 		$picinform=$this->forehead->select_table('picture',8);
	
// 		foreach($picinform as $k=>$row){
// 			$data['picinform'][$k]['id']=$row['id'];
// 			$data['picinform'][$k]['conten']=$row['conten'];
			
// 			$info = pathinfo($row['src']);
// 			$pics = $info['dirname']."/"."s_".$info[filename].".".$info['extension'];
// 			$data['picinform'][$k]['src']=$pics;
// 			//$data['list'][$k]['endtime']=date('Y-m-d',$row['endtime']);
// 		}
		
// 		//首页便民热线
// 		$hotline=$this->forehead->select_table('hotline',10);
// 		foreach($hotline as $k=>$row){
// 			$data['hotline'][$k]['id']=$row['id'];
// 			$data['hotline'][$k]['name']=$row['name'];
// 			$data['hotline'][$k]['tell']=$row['tell'];
// 			//$data['list'][$k]['endtime']=date('Y-m-d',$row['endtime']);
// 		}
// 		//首页友情链接
// 		$url=$this->forehead->select_table_order('urls',10);
// 		foreach($url as $k=>$row){
// 			$data['url'][$k]['id']=$row['id'];
// 			$data['url'][$k]['url']=$row['url'];
// 			$data['url'][$k]['src']=$row['src'];
// 			//$data['list'][$k]['endtime']=date('Y-m-d',$row['endtime']);
// 		}

		$this->load->view('index',$data); 
	}	
	
	//下载手机客户端
	public function mobiledown() {
		include('android/apkconfig.php');
		$data['config'] = $configArr;
		$this->load->view('mobiledown',$data);
	}

}