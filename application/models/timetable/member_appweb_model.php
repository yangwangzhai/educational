<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

// 会员模型
include_once 'content_model.php';
class member_appweb_model extends content_model {	
	
	function __construct() {
		parent::__construct ();
		
		$this->table = 'fly_member';
	}
	
	/**
	 *模型测试方法
	 *
	 * @param int 会员id
	 * @return array
	 */
	function test() {
		return "这是模型的测试方法222";
	}
	
	/**
	 * 用户校验方法
	 *
	 * @param int 会员id
	 * @return boolean
	 */
	function check_user($username, $password) {
		$query = $this->db->get_where ( 'fly_member', array (
		'username' => $username,
		'password' =>  $password ));
		return $query;
	}
	
	/**
	 * 获取一条信息
	 *
	 * @param int 会员id
	 * @return array
	 */
	function get_one($uid) {
		$query = $this->db->query ( "select * from $this->table where id='$uid' limit 1" );
		$value = $query->row_array();
		$value['classid'] = $value['classname'];
		$value['schoolname'] = get_schoolname($value['schoolid']);
		
		if($value['catid']==2) { // 教师表
			$query = $this->db->query ( "select manage_class,teach_class from fly_teacher where id='$uid' limit 1" );
			$teacher = $query->row_array();
			if(!empty($teacher)) $value = array_merge($value,$teacher);						
		}
		
		return $value;
	}
	
	/**
	 * 根据班级名称，获取班主任id
	 *
	 * @param $classname string
	 * @return int
	 */
	function get_manage_id($choolid,$classname) {
		$query = $this->db->query ( "select m.id from $this->table m,fly_teacher t where m.id=t.id and m.schoolid='$choolid' and t.manage_class like '%{$classname}%' limit 1" );
		$value = $query->row_array();
		
		return $value['id'];
	}
	
	/**
	 * 根据id 获取教师的全部信息 
	 *
	 * @param $id int
	 * @return array
	 */
	function detail_teacher($id) {
		$query = $this->db->query ( "select m.*,t.manage_class,t.teach_class from $this->table m,fly_teacher t where m.id=t.id and m.id='$id' limit 1" );
		$value = $query->row_array();
		if($value ['thumb']) {
			$value ['thumb'] = base_url(). new_thumbname($value ['thumb'],100,100);
		}
		return $value;
	}
	

	/**
	 * 为一组信息 加上会员的姓名
	 *
	 * @param $ids array
	 * @return array
	 */
	function append_list($list) {
		if (isset ( $list [0] ['uid'] )) {
			$ids = array ();
			foreach ( $list as $r ) {
				$ids [] = $r ['uid'];
			}
			
			$ids = implode ( ',', $ids );
			$query = $this->db->query ( "select id,truename,tel,thumb from $this->table where id in({$ids}) order by id desc limit 200" );
			$result = $query->result_array ();
			$data = array ();
			foreach ( $result as $value ) {
				$data [$value ['id']]['truename'] = $value ['truename'];
				$data [$value ['id']]['tel'] = $value ['tel'];
				$data [$value ['id']]['thumb'] = '';
				if($value ['thumb']) {
					$data [$value ['id']]['thumb'] = base_url(). new_thumbname($value ['thumb']);
				}
			}
			
			foreach ( $list as $key=>&$r ) {
				$r ['truename'] = $data[$r['uid']] ['truename'];
				$r ['tel'] = $data[$r['uid']] ['tel'];
				$r ['member_thumb'] = $data[$r['uid']] ['thumb'];
			}
		}
		
		return $list;
	}
	
	/**
	 * 为一组信息 加上会员的姓名
	 *
	 * @param $ids array
	 * @return array
	 */
	function append_list2($list) {
		if (isset ( $list [0] ['uid'] )) {
			$ids = array ();
			foreach ( $list as $r ) {
				$ids [] = $r ['uid'];
			}
				
			$ids = implode ( ',', $ids );
			$query = $this->db->query ( "select id,truename,tel,thumb,classname from $this->table where id in({$ids}) order by id desc limit 200" );
			$result = $query->result_array ();
			$data = array ();
			foreach ( $result as $value ) {
				$data [$value ['id']]['truename'] = $value ['truename'];
				$data [$value ['id']]['tel'] = $value ['tel'];
				$data [$value ['id']]['classname'] = setClassname($value ['classname']);
				$data [$value ['id']]['thumb'] = '';
				if($value ['thumb']) {
					$data [$value ['id']]['thumb'] = base_url(). new_thumbname($value ['thumb']);
				}
			}
				
			foreach ( $list as $key=>&$r ) {
				$r ['truename'] = $data[$r['uid']] ['truename'];
				$r ['classname'] = $data[$r['uid']] ['classname'];
				$r ['tel'] = $data[$r['uid']] ['tel'];
				$r ['member_thumb'] = $data[$r['uid']] ['thumb'];
			}
		}
	
		return $list;
	}
	
	
	/**
	 * 为一条信息附加上 姓名 头像 班级
	 *
	 * @param $data array
	 * @return array
	 */
	function append_one($data) {	
		if ( !empty($data['uid']) ) {
			
			$member = $this->get_one($data['uid']);
			$data['member_thumb'] = '';
			$data['truename'] = $member['truename'];
			if(intval($data['classname'])!=0) $data['classname'] = setClassname($data['classname']);		
			if($member['thumb']) $data['member_thumb'] = base_url().$member['thumb'];
		}
		
		return $data;
	}
	
	/**
	 * 为一条信息附加上 姓名 头像 班级
	 *
	 * @param $data array
	 * @return array
	 */
	function append_one2($data) {
		if ( !empty($data['uid']) ) {				
			$member = $this->get_one($data['uid']);		
			$data['truename'] = $member['truename'];			
		}
	
		return $data;
	}
	
	/**
	 * 获取会员列表
	 *
	 * @param $classid int
	 * @return array
	 */
	function list_search($keywords, $schoolid=0) {
		$keywords = mysql_real_escape_string($keywords);
		$sql = "schoolid='$schoolid' and truename LIKE '%$keywords%' OR username LIKE '%$keywords%'";
		$list = parent::get_list('id,truename,thumb', $sql,0,50);
		foreach ($list as &$value) {
			if($value ['thumb']) $value ['thumb'] = base_url(). new_thumbname($value ['thumb'],100,100);
		}
		return $list;
	}
	
	
	/**
	 * 获取某人的全部会员列表
	 *
	 * @param  int $uid
	 * @return array
	 */
	function friend_list($uid) {
		$list = array();
		if(empty($uid)) return $list;		
		$query = $this->db->query ( "select fid from fly_friends where uid='$uid' limit 500" );
		$fid_arr = $query->result_array();
		if(empty($fid_arr)) {
			return $list;
		}
		foreach ($fid_arr as $value) {
			$list[] = $value['fid'];
		}
		
		$fid_str = join(',', $list);
		$sql = "select id,truename,thumb from $this->table where id in($fid_str) limit 500";		
		$query = $this->db->query ( $sql );
		$list = $query->result_array();
		foreach ($list as &$value) {
			if($value ['thumb']) $value ['thumb'] = base_url(). new_thumbname($value ['thumb'],100,100);
		}
		
		return $list;
	}
	
	/**
	 * 获取会员列表
	 *
	 * @param int $uid,$fid
	 * @return array
	 */
	function friend_add($uid,$fid) {
		if(empty($uid) || empty($fid)) return false;
		
		$data = array('uid'=>$uid, 'fid'=>$fid);
		$this->db->insert ( 'fly_friends', $data );
		
		// 会员人数加1
		$this->db->query("update $this->table set friendcount=friendcount+1 where id='$uid' limit 1");
		return $uid;
	}
	
	/**
	 * 删除好友
	 *
	 * @param int $id
	 * @return mix
	 */
	function friend_delete($uid,$fid) {
		if(empty($uid) || empty($fid)) return false;		
		$query = $this->db->query ( "delete from fly_friends where uid='$uid' and fid='$fid' limit 1" );
		// 会员人数减1		
		$this->db->query("update $this->table set friendcount=friendcount-1 where id='$uid' limit 1");
		return $uid;
	}
	
	/**
	 * 检测会员 是否可用，是否更新资料了，0 没有更新，1 更新无需重新登录  2 需要重新登录；
	 *
	 * @param int $uid
	 * @return int
	 */
	public function check_status($uid) {
		$status = 0;
		$value = $this->get_one($uid);		
		if(empty($value) || $value['status']==0 ) {  // 账号删除或者锁定
			$status = 2;
		} else {
			$status = $value['status2'];
		}
		
		return $status;
	}
	
	/**
	 * 把状态码 设为0
	 *
	 * @param int $uid
	 * @return int
	 */
	public function set_status2_ok($uid) {
		$data['status2'] = 0;
		$this->db->where ( 'id', $uid );
		$query = $this->db->update ( 'fly_member', $data );		
	}
	
}
