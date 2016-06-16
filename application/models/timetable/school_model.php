<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

// 学校
include_once 'content_model.php';
class school_model extends content_model {	
	
	
	function __construct() {
		parent::__construct ();
		
		$this->table = 'fly_school';
	}

	/**
	 * 获取一组信息
	 *
	 * @param
	 *        	多个参数
	 * @return array 二维数组
	 */
	function get_list($field = '*', $where = '', $offset = 0, $limit = 100) {
		if($where) $where = "WHERE $where";
		$sql = "SELECT $field FROM $this->table $where ORDER BY id DESC limit $offset,$limit";
		$query = $this->db->query ( $sql );
		return $query->result_array ();
	}


	/**
	 * 获取一组信息,整理后，可通过id 获取 学校名称
	 *
	 * @param
	 *        	多个参数
	 * @return array 二维数组
	 */
	function lists() {
		$list = $this->get_list('id,title');
		$result = array();
		foreach($list as $value) {
			$result[$value['id']] = $value['title'];
		}
		
		return $result;
	}


	/**
	 * 获取一组信息,整理后，可通过id 获取 学校名称
	 *
	 * @param
	 *        	多个参数
	 * @return array 二维数组
	 */
	function lists_normal() {
		return $this->get_list('id,title');
	}


	/**
	 * 获取一组信息,整理后，可通过id 获取 学校名称
	 *
	 * @param
	 *        	多个参数
	 * @return array 二维数组
	 */
	function list2() {
		$list = $this->get_list('rfid_client,title');
		$result = array();
		foreach($list as $value) {
			$result[$value['rfid_client']] = $value['title'];
		}
	
		return $result;
	}

	/**
	 * 获取一组信息,整理后，可通过id 获取 学校名称
	 *
	 * @param
	 *        	多个参数
	 * @return array 二维数组
	 */
	function list4select() {
		$list = $this->get_list('id,title');
		$result = array();
		$result[0] = '全部学校';
		foreach($list as $value) {
			$result[$value['id']] = $value['title'];
		}

		return $result;
	}
	
}
