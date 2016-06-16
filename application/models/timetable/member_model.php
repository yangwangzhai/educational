<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

// 会员模型
include_once 'content_model.php';
class member_model extends content_model {	
	
	function __construct() {
		parent::__construct ();
		
		$this->table = 'fly_member';
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
	 * 根据班级名称，获取班主任id 多个
	 *
	 * @param $classname string
	 * @return int
	 */
	function get_manage_id_arr($choolid, $classname) {
		$return = array();
		$query = $this->db->query ( "select m.id from $this->table m,fly_teacher t where m.id=t.id and m.schoolid='$choolid' and t.manage_class like '%{$classname}%' limit 100" );
		foreach($query->result_array() as $value){
			$return[] = $value['id'];
		}

		return $return;
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
	 * 为一组信息 加上会员的姓名
	 *
	 * @param $ids array
	 * @return array
	 */
	function append_list_relation($list) {
		if (isset ( $list [0] ['uid'] )) {
			$ids = array ();
			foreach ( $list as $r ) {
				$ids [] = $r ['uid'];
			}

			$ids = implode ( ',', $ids );
			$query = $this->db->query ( "select m.id,m.catid,m.truename,m.tel,m.thumb,m.classname,m.relation,s.name from $this->table m left JOIN fly_student s ON m.studentid=s.id where m.id in({$ids}) order by m.id desc limit 200" );
			$result = $query->result_array ();
			$data = array ();
			foreach ( $result as $value ) {
				$data [$value ['id']]['catid'] = $value ['catid'];
				$data [$value ['id']]['studentname'] = $value ['name']?$value ['name']:'';
				$data [$value ['id']]['truename'] = $value ['truename'];
				$data [$value ['id']]['relation'] = $value ['relation'];
				$data [$value ['id']]['tel'] = $value ['tel'];
				$data [$value ['id']]['classname'] = setClassname($value ['classname']);
				$data [$value ['id']]['thumb'] = '';
				if($value ['thumb']) {
					$data [$value ['id']]['thumb'] = base_url(). new_thumbname($value ['thumb']);
				}
			}

			foreach ( $list as $key=>&$r ) {
				$r ['catid'] = $data[$r['uid']] ['catid'];
				$r ['studentname'] = $data[$r['uid']] ['studentname'];
				$r ['truename'] = $data[$r['uid']] ['truename'];
				$r ['relation'] = $data[$r['uid']] ['relation'];
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
	
	/**
	 * 检测手机号码是否存在,存在返回真
	 *
	 * @param string tel
	 * @param int $uid
	 * @return bool
	 */
	public function is_tel_exist($tel, $uid=0) {
		if($uid) {
			$count  = $this->counts("tel='$tel' AND id!=$uid");
		} else {
			$count  = $this->counts("tel='$tel'");
		}
		
		return boolval ($count);		
	}

	/**
	 * 获取唯一手机号码
	 * 根据传进来的电话号码，检查是否已经存在，后面加#123456
	 * 如果手机为空则用用户名+#代替
	 *
	 * @param string tel
	 * @return string
	 */
	public function get_new_tel($tel='', $username='') {
		$tel = substr(getNumber($tel),0,11);
		if(empty($tel)) {
			$tel = $username . '#';
			return $tel;
		}
		if(strlen($tel)<11){
			$tel = '0771'.$tel;
		}
		$exist = $this->is_tel_exist($tel);
		if($exist == false) {
			return $tel;
		}

		$new_tel = $tel.'#';
		$exist = $this->is_tel_exist($new_tel);
		if($exist == false) {
			return $new_tel;
		}

		// 循环 查看手机是否存在
		for($i=1; $i<=100000; $i++) {
			$new_tel = $tel.'#'.$i;
			$exist = $this->is_tel_exist($new_tel);
			if($exist == false) {
				return $new_tel;
			}
		}
	}


	/**
	 * 获取老师列表，本校，本班
	 *
	 * @param int $schoolid
	 * @param int $classname
	 * @return array
	 */
	public function teacher_list_select($schoolid, $classname=0) {
		$classname = getNumber($classname);
		if(empty($classname)) {
			$query = $this->db->query(
				"select id,truename from $this->table where schoolid='$schoolid' and catid=2 limit 1000");
		} else {
			$query = $this->db->query(
				"select m.id,truename from fly_member m,fly_teacher t where m.id=t.id and
schoolid='$schoolid' and catid=2 and (manage_class like '%$classname%' or teach_class like '%$classname%') limit 1000");
		}

		$result = array();
		foreach($query->result_array() as $value){
			$result[$value['id']] = $value['truename'];
		}

		return $result;
	}

	/**
	 * 根据老师的任教科目，返回uid
	 *
	 * @param int
	 * @return int
	 */
	function get_uid_by_course($schoolid, $classname, $course) {
		$uid = 0;
		$classname = getNumber($classname);
		if( empty($schoolid) || empty($classname) || empty($course) ) {
			return $uid;
		}
		//echo "select m.id from fly_member m,fly_teacher t where m.id=t.id AND m.schoolid='{$schoolid}' AND t.teach_class like '%{$classname}%' AND t.course like '%{$course}%' limit 1";
		$query = $this->db->query ( "select m.id from fly_member m,fly_teacher t where m.id=t.id AND m.schoolid='{$schoolid}' AND t.teach_class like '%{$classname}%' AND t.course like '%{$course}%' limit 1" );
		$value = $query->row_array();
		if($value) {
			$uid = $value['id'];
		}
		return $uid;
	}

	/**
	 * 修改会员信息
	 *
	 * @param int $id
	 * @return array 二维数组
	 */
	function update($data, $uid) {
		if (empty($data) || empty ( $uid )){
			return 0;
		}

		$data['edit_time'] = time();
		if(isset($data['password'])) { // 修改密码后，app需重新登录
			$data['password'] = get_password ( $data ['password'] );
			$data['status2'] = 2;
		}

		$this->db->where ( 'id', $uid );
		$this->db->update ( $this->table, $data );
		return $this->db->affected_rows ();
	}

	/**
	 * 修改会员信息
	 *
	 * @param int $id
	 * @return array 二维数组
	 */
	function update_edit_time_studentid($studentid) {
		if (empty ( $studentid )){
			return 0;
		}

		$data['edit_time'] = time();

		$this->db->where ( 'studentid', $studentid );
		$this->db->update ( $this->table, $data );
		return $this->db->affected_rows ();
	}

	/**
	 * 根据手机号码注册 教师账号
	 *
	 * @param int $id
	 * @return array 二维数组
	 */
	function regist_teacher($data, $schoolid=3, $classid=20125)
	{
		$data['catid'] = 2;
		$data['schoolid'] = $schoolid;
		$data['password'] = get_password('123456');
		$data ['addtime'] = time ();
		$data ['status'] = 1;
		$data ['lastlogintime'] = time ();
		if(empty($data['truename'])) {
			$data['truename'] = '张老师';
		}

		$data['tel'] = $this->get_new_tel($data['tel']);

		$this->db->insert ( $this->table, $data );
		$insert_id = $this->db->insert_id();

		// 插入附表
		$teacher['id'] = $insert_id;
		$teacher['manage_class'] = $classid;
		$teacher['teach_class'] = $classid;
		$this->db->insert('fly_teacher', $teacher);

		//  生成登录名
		$username = make_username($insert_id);
		$this->db->query("update $this->table set username='$username' where id=$insert_id limit 1");

		return $insert_id;
	}

	/**
	 * 获取一组信息，用于找回密码界面用的
	 *
	 * @param int 电话
	 * @return array
	 */
	function getListByTel($tel) {
		$query = $this->db->query ( "select id,truename,tel from $this->table where tel like '{$tel}%' limit 10" );
		$list = $query->result_array();

		return $list;
	}

    function get_truename($id)
    {
        $sql="select truename from $this->table WHERE id=$id";

        $query=$this->db->query($sql);
        return $query->row_array();

    }

	
}
