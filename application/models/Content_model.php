<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 * 模型 基类，其他模型需要先继承本类
 */
class Content_model extends CI_Model {
	public $table = ''; // 数据库表名称
	public $limit = 20;
	
	function __construct() {
		parent::__construct ();
	}

    function db_sum($table,$column,$where){
        if($where) {
            $where = "where $where";
        }
        $query = $this->db->query ( "select sum($column) as num from $table  $where" );
        $value=$query->row_array();
        return $value['num'];
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

    function get_column3($column,$table,$where='')
    {
        $query = $this->db->query ( "select $column from $table  $where" );
        return $value = $query->result_array();
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

    function get_one_db($table,$id) {
        $this->db->where ( 'id', $id );
        $query = $this->db->get ($table, 1 );
        return $query->row_array ();
    }
	/**
	 * 根据条件，获取记录条数
	 *
	 * @param string $where        	
	 * @return array 二维数组
	 */
	function get_count($where = '') {
		$query = $this->db->query ( "SELECT COUNT(*) AS num FROM $this->table WHERE 1 $where" );
		$value = $query->row_array ();
		return $value ['num'];
	}
	
	/**
	 *  查询记录条数
	 *
	 * @param string $where
	 * @return array 二维数组
	 */
	function counts($where='') {
		if($where) {
			$where = "where $where";
		}
	
		$sql = "SELECT COUNT(*) AS num FROM $this->table $where";
		$query = $this->db->query ( $sql );		
		$value = $query->row_array ();
		return $value ['num'];
	}
    function db_counts($table,$where='') {
        if($where) {
            $where = "where $where";
        }

        $sql = "SELECT COUNT(*) AS num FROM $table $where";
        $query = $this->db->query ( $sql );
        $value = $query->row_array ();
        return $value ['num'];
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
    function db_delete2($table,$where=array())
    {
        return $this->db->delete($table,$where);
    }

    /**
     * 根据ID编辑一组信息
     *
     * @param int $id
     * @return boolean 二维数组
     */
    function update($id,$data) {
        if (empty($id))
            return false;

        $this->db->where ('id',$id);
        $this->db->update ( $this->table, $data);
        if($this->db->affected_rows ()>=1)
        {
            return true;
            exit;
        }
        return false;
    }

    function update2($id,$table,$data) {
        if (empty($id))
            return false;

        $this->db->where ('id',$id);
        $this->db->update ( $table, $data);
        if($this->db->affected_rows ()>=1)
        {
            return true;
            exit;
        }
        return false;
    }

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
	
}
