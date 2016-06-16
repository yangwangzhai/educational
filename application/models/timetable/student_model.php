<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
	// 学生模型
include_once 'content_model.php';
class student_model extends content_model {	

	function __construct() {
		parent::__construct ();
		
		$this->table = 'fly_student';
	}

	/**
	 * 获取一条信息
	 *
	 * @param $classid int        	
	 * @return array
	 */
	function get_one($id) {
		$query = $this->db->query ( "select * from $this->table where id='$id' limit 1" );
		$data = $query->row_array ();
		if ($data ['thumb']) {
			$data ['thumb'] = base_url () . $data ['thumb'];
		}
		$data ['age'] = getAge ( $data ['birthday'] );
		$data ['gender'] == 1 ? '男' : '女';
		
		return $data;
	}

	/**
	 * 获取一条姓名
	 *
	 * @param $classid int        	
	 * @return array
	 */
	function get_name($id) {
		$query = $this->db->query ( "select name from $this->table where id='$id' limit 1" );
		$data = $query->row_array ();
		return $data ['name'];
	}

	/**
	 * 通过班级id 获取学生列表
	 *
	 * @param $classid int        	
	 * @return array
	 */
	function selectList($classid) {
		$query = $this->db->query ( "select id,name from $this->table where classid='$classid' order by id desc limit 200" );
		$list = $query->result_array ();
		$return = array ();
		foreach ( $list as $value ) {
			$return [$value ['id']] = $value ['name'];
		}
		
		return $return;
	}

	/**
	 * 为一组信息 加上学生的姓名 和 班级
	 *
	 * @param $ids array        	
	 * @return array
	 */
	function append_list($list) {
		if (isset ( $list [0] ['studentid'] )) {
			$ids = array ();
			foreach ( $list as $r ) {
				$ids [] = $r ['studentid'];
			}
			
			// 学生信息
			$ids = implode ( ',', $ids );
			$query = $this->db->query ( "select id,name,classname from $this->table where id in({$ids}) order by id desc limit 200" );
			$result = $query->result_array ();
			$data = array ();
			foreach ( $result as $value ) {
				$data [$value ['id']] ['classname'] = $value ['classname'];
				$data [$value ['id']] ['name'] = $value ['name'];
			}
			
			// 加上姓名 和 班级
			foreach ( $list as $key => &$r ) {
				$r ['classname'] = setClassname($data [$r ['studentid']] ['classname']);
				$r ['studentname'] = $data [$r ['studentid']] ['name'];
			}
		}
		
		return $list;
	}

	/**
	 * 为一组信息 加上学生的姓名
	 *
	 * @param $ids array        	
	 * @return array
	 */
	function append_list2($list) {
		if (isset ( $list [0] ['studentid'] )) {
			$ids = array ();
			foreach ( $list as $r ) {
				$ids [] = $r ['studentid'];
			}
			
			// 学生信息
			$ids = implode ( ',', $ids );
			$query = $this->db->query ( "select id,name,gender from $this->table where id in({$ids}) order by id desc limit 200" );
			$result = $query->result_array ();
			$data = array ();
			foreach ( $result as $value ) {
				$data [$value ['id']] ['name'] = $value ['name'];
			}
			
			// 加上姓名 和 班级
			foreach ( $list as $key => &$r ) {
				$r ['studentname'] = $data [$r ['studentid']] ['name'];
			}
		}
		
		return $list;
	}

	/**
	 * 通过rfid 为一组信息 加上学生的姓名 和班级 学校
	 *
	 * @param $ids array        	
	 * @return array
	 */
	function append_list3($list) {
		if (! isset ( $list [0] ['rfid'] )) {
			return $list;
		}
		$ids = array ();
		foreach ( $list as $r ) {
			$ids [] = $r ['rfid'];
		}
		
		// 学生信息
		$ids = implode ( ',', $ids );
		$query = $this->db->query ( "select rfid,classname,name,schoolid from $this->table where rfid in({$ids}) limit 100" );
		$result = $query->result_array ();
		$data = array ();
		foreach ( $result as $value ) {
			$data [$value ['rfid']] ['name'] = $value ['name'];
			$data [$value ['rfid']] ['classname'] = $value ['classname'];
			$data [$value ['rfid']] ['schoolid'] = $value ['schoolid'];
		}
		
		// 加上姓名 和 班级
		foreach ( $list as $key => &$r ) {
			$r ['schoolname'] = get_schoolname($data [$r ['rfid']] ['schoolid']);
			$r ['classname'] = setClassname($data [$r ['rfid']] ['classname']);
			$r ['studentname'] = $data [$r ['rfid']] ['name'];
		}
		
		return $list;
	}

	/**
	 * 根据RFID 卡号 为一组信息 加上学生的姓名
	 *
	 * @param $ids array        	
	 * @return array
	 */
	function append_rfid($list) {
		if (isset ( $list [0] ['RE_RFID_ID'] )) {
			$ids = array ();
			foreach ( $list as $r ) {
				$ids [] = $r ['RE_RFID_ID'];
			}
			
			// 学生信息
			$ids = "'" . implode ( "','", $ids ) . "'";
			$query = $this->db->query ( "select rfid,name,classname from $this->table where rfid in({$ids}) order by id desc limit 200" );
			$result = $query->result_array ();
			$data = array ();
			foreach ( $result as $value ) {
				$data [$value ['rfid']] ['classname'] = $value ['classname'];
				$data [$value ['rfid']] ['name'] = $value ['name'];
			}
			
			// 加上姓名 和 班级
			foreach ( $list as $key => &$r ) {
				$r ['classname'] = $data [$r ['RE_RFID_ID']] ['classname'];
				$r ['studentname'] = $data [$r ['RE_RFID_ID']] ['name'];
			}
		}
		
		return $list;
	}

	/**
	 * 为一条信息附加上学生 姓名 班级 等
	 *
	 * @param $data array        	
	 * @return array
	 */
	function append_one($data) {
		if (isset ( $data ['studentid'] )) {
			$student = $this->get_one ( $data ['studentid'] );
			
			$data ['classname'] = setClassname($student ['classname']);
			$data ['studentname'] = $student ['name'];
			$data ['studentthumb'] = $student ['thumb'];
			$data ['studentgender'] = $student ['gender'] == 1 ? '男' : '女';
		}
		
		return $data;
	}
	
	/**
	 * 为一条信息附加上学生 姓名 班级 等
	 *
	 * @param $data array
	 * @return array
	 */
	function append_one2($data) {
		if (isset ( $data ['studentid'] )) {
			$student = $this->get_one ( $data ['studentid'] );				
			
			$data ['studentname'] = $student ['name'];
			$data ['studentthumb'] = $student ['thumb'];
			$data ['studentgender'] = $student ['gender'] == 1 ? '男' : '女';
		}
		
		return $data;
	}

	/**
	 * 所有学生总数
	 *
	 * @param $data array
	 * @return array
	 */
	function counts_all() {
		return 5100;
	}
	
	
	
}
