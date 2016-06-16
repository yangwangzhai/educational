<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 * 模型 基类，其他模型需要先继承本类
 */
class Content_model extends CI_Model {
	public $table = 'fly_timetable'; // 数据库表名称
	public $limit = 20;
	
	function __construct() {
		parent::__construct ();
	}

    /**
     * 获取表的全部信息
     *
     *@return array 二维数组
     */
    function get_all($table)
    {
        $query = $this->db->get($table);
        return $query->result_array();
    }

    /**
     * 获取表的某列的信息
     *
     *@return array 二维数组
     */
    function get_column($column,$table,$where='')
    {
        if($where) {
            $where = "where $where";
        }
        $query = $this->db->query ( "select $column from $table  $where" );
        return $value = $query->result_array();
    }

    /**
     * 获取表的某列的信息
     *
     *@return array 一条记录，一维维数组
     */
    function get_column2($column,$table,$where='')
    {
        if($where) {
            $where = "where $where";
        }
        $query = $this->db->query ( "select $column from $table  $where" );
        return $value = $query->row_array();
    }



	/**
	 * 获取一条信息
	 *
	 * @param int $id
	 * @return array 一维数组
	 */
	function get_one($id) {
		$this->db->where ( 'id', $id );
		$query = $this->db->get ( $this->table, 1 );
		return $query->row_array ();
	}

	/**
	 * 根据条件，获取记录条数
	 *
	 * @param string $where
	 * @return array 二维数组
	 */
	function get_count($where = '') {
		$query = $this->db->query ( "SELECT COUNT(*) AS num FROM $this->table WHERE  $where" );
		$value = $query->row_array ();
		return $value ['num'];
	}

	/**
	 *  查询记录条数
	 *
	 * @param string $where
	 * @return array 二维数组
	 */
	function counts($table,$where='') {
		if($where) {
			$where = "where $where";
		}

		$sql = "SELECT COUNT(*) AS num FROM $table $where";
		$query = $this->db->query ( $sql );
		$value = $query->row_array ();
		return $value ['num'];  //返回的是整数
	}

	/**
	 * 获取一组信息
	 *
	 * @param
	 *        	多个参数
	 * @return array 二维数组
	 */
	function get_list($field = '*', $where = '', $offset = 0, $limit = 20) {
		if($where) $where = "WHERE $where";
		$sql = "SELECT $field FROM $this->table $where ORDER BY id DESC limit $offset,$limit";
		$query = $this->db->query ( $sql );
		return $query->result_array ();
	}

    function get_list2($field = '*', $where = '',$table,$offset = 0, $limit = 20) {
        if($where) $where = "WHERE $where";
        $sql = "SELECT $field FROM $table $where ORDER BY id DESC limit $offset,$limit";
        $query = $this->db->query ( $sql );
        return $query->result_array ();
    }

	/**
	 * 获取一组信息
	 *
	 * @param array $data
	 * @return array 二维数组
	 */
	function insert($data) {
		$query = $this->db->insert ( $this->table, $data );
		return $this->db->insert_id ();
	}

	/**
	 * 删除一条或多条信息
	 *
	 * @param mix $ids
	 *        	整数或者数组
	 * @return array 二维数组
	 */
	function delete($ids) {
		if (is_numeric ( $ids )) {
			$this->db->query ( "delete from $this->table where id=$ids" );
		} else {
			$ids = implode ( ",", $ids );
			$this->db->query ( "delete from $this->table where id in ($ids)" );
		}
		return $this->db->affected_rows ();
	}

	/**
	 * 获取一组信息
	 *
	 * @param int $id
	 * @return array 二维数组
	 */
	function update($data, $id) {
		if (empty ( $id ))
			return 0;

		$this->db->where ( 'id', $id );
		$query = $this->db->update ( $this->table, $data );
		return $this->db->affected_rows ();
	}

	/**
	 * 更新 访问量
	 *
	 * @param int $id
	 * @return array 二维数组
	 */
	function update_visits($id) {
		if ($id == 0)
			return false;
		$query = $this->db->query ( "update $this->table set visits=visits+1 where id='$id' limit 1" );
	}

	/**
	 * 更新 访问量
	 *
	 * @param int $id
	 * @param int $status
	 * @return array 二维数组
	 */
	function update_status($id, $status) {
		if ($id == 0)
			return false;
		$query = $this->db->query ( "update $this->table set status='$status' where id='$id' limit 1" );
	}

	/**
	 * 获取信息列表
	 *
	 * @param $filed 可以是一条查询语句  或者多个参数
	 *
	 * @return array 二维数组
	 */
	function lists($filed = '*', $where = '',  $offset = 0, $limit = 20,$order = 'id DESC') {
		$pos = stripos($filed, 'select');
		if($pos !== FALSE) {  // 执行sql
			$query = $this->db->query ( $filed );
		} else{

			$sql = "SELECT $filed FROM $this->table WHERE $where ORDER BY $order limit $offset,$limit";
			$query = $this->db->query ( $sql );
		}

		return $query->result_array ();
	}

	// ====================数据库操作函数封装================
	/**
	 * 获取一条记录
	 *
	 * @param mixed $where
	 * @return array 一维数组
	 */
	function db_row($where=array())
	{
		return $this->db_row_table($this->table, $where);
	}

	/**
	 * 获取一条记录，通过表名
	 *
	 * @param string $table
	 * @param mixed $where
	 * @return array 一维数组
	 */
	function db_row_table($table, $where=array())
	{
		if (is_numeric($where)) {
			$this->db->where('id', $where);
		} else {
			$this->db->where($where);
		}
		$query = $this->db->get($table, 1);
		return $query->row_array();
	}

	/**
	 * 获取一条记录
	 *
	 * @param string sql
	 * @return array 一维数组
	 */
	function db_row_sql($sql)
	{
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	/**
	 * 获取多条记录
	 *
	 * @return array 二维数组
	 */
	function db_list($field = '*', $where = array(), $order = 'id DESC',$limit = 20,$offset = 0)
	{
		return $this->db_list_table($this->table, $field, $where, $order ,$limit ,$offset);
	}

	/**
	 * 获取多条记录，通过表名
	 *
	 * @return array 二维数组
	 */
	function db_list_table($table, $field = '*', $where = array(), $order = 'id DESC',$limit = 20,$offset = 0)
	{
		$this->db->select($field)->from($table)->where($where)->order_by($order)->limit($limit,$offset);
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * 获取多条记录
	 *
	 * @param string $sql
	 * @return array 二维数组
	 */
	function db_list_sql($sql)
	{
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/**
	 *  查询记录总数
	 *
	 * @param mixed $where
	 * @return int
	 */
	function db_count($where=array())
	{
		return $this->db_count_table($this->table, $where);
	}
	/**
	 *  查询记录总数, 指定表名
	 *
	 * @param string $table
	 * @param mix $where
	 * @return int
	 */
	function db_count_table($table,$where=array())
	{
		$this->db->where($where);
		$this->db->from($table);
		return $this->db->count_all_results();
	}

	/**
	 * 插入一条记录
	 *
	 * @param array $data
	 * @return int
	 */
	function db_insert( $data )
	{
		return $this->db_insert_table($this->table, $data);
	}

	/**
	 * 插入一条记录，指定表名
	 *
	 * @param string $table
	 * @param array $data
	 * @return int
	 */
	function db_insert_table($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	/**
	 * 更新一条记录
	 *
	 * @param array $data
	 * @param mixed $where
	 * @return int
	 */
	function db_update( $data, $where=array())
	{
		return $this->db_update_table($this->table, $data, $where);
	}

	/**
	 * 更新一条记录，指定表名
	 *
	 * @param string $table
	 * @param array $data
	 * @param mixed $where
	 * @return int
	 */
	function db_update_table($table, $data, $where=array())
	{
		if (is_numeric($where)) {
			$this->db->where('id', $where);
		} else{
			$this->db->where($where);
		}
		$this->db->update($table, $data);
		return $this->db->affected_rows();
	}

	/**
	 * 删除一条或多条记录
	 *
	 * @param mix $where 整数或者数组 3,array(3,4,5), array('catid'=>1)
	 * @return int
	 */
	function db_delete($where=array())
	{
		return $this->db_delete_table($this->table, $where);
	}

    function db_delete2($table,$where=array())
    {
        return $this->db->delete($table,$where);
    }

	/**
	 * 删除一条或多条记录
	 *
	 * @param string $table
	 * @param mix $where 整数或者数组 3,array(3,4,5), array('catid'=>1)
	 * @return int
	 */
	function db_delete_table($table, $where=array())
	{
		if (is_array($where)) {
			if (isset($where[0])) { // 根据id删除多条
				$id_str = implode(",", $where);
				$this->db->query("delete from {$table} where id in ($id_str)");
			} else { // 根据条件删除多条
				$this->db->where($where);
				$this->db->delete($table);
			}
		} else  { // 根据id删除单条
			$this->db->where('id', $where);
			$this->db->delete($table);
		}
		return $this->db->affected_rows();
	}
// =============================================
}
