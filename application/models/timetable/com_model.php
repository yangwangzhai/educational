<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 通用模型
class com_model extends CI_Model
{
    function __construct ()
    {
        parent::__construct();
    }

    
    // 获取班级  后台缓存的 返回数组
    function get_class($schoolid)
    {
    	$class_arr = array();
    	if(empty($schoolid)) {
    		return $class_arr;
    	}
    	
    	$query = $this->db->query ( "select classes from fly_school where id='$schoolid' limit 1" );
    	$value = $query->row_array();

    	// 年级班级
		//$class_arr = str_replace("\r","", $value['classes']);
    	$class_arr = explode("\r\n", $value['classes']);    //以换行符作为分割符，把分割的每个单元放到数组中

        //以 "," 作为分割符，把分割的每个单元放到数组中
    	foreach ($class_arr as &$value){
    		$value = explode("，", $value);
    	}

    	return $class_arr;
    }

	// 获取班级  后台缓存的 返回数组
	function get_class_list($schoolid)
	{
		$class_arr = $this->get_class($schoolid);
		$list = array();
		foreach($class_arr as $value){
			foreach($value as $classname) {
				$list[] = array(
					'classid'=>getNumber($classname),
					'classname'=>$classname);
			}
		}

		return $list;
	}

	// 获取班级  后台缓存的 返回数组
	function get_class_select($schoolid)
	{
		$class_arr = $this->get_class($schoolid);
		$list = array();
		foreach($class_arr as $value){
			foreach($value as $classname) {
				$list[getNumber($classname)] = $classname;
			}
		}

		return $list;
	}




    
    // 获取班级  后台缓存的 返回数组
    function get_class11111111()
    {
    	$class_arr = array();    	
    	 
    	// 年级班级
    	$website = $this->cache->get('classes');
    	$class_str = $website['classes'];
    	$class_arr = explode("\n", $class_str);
    	foreach ($class_arr as &$value){
    		$value = explode("，", $value);
    	}
    
    	return $class_arr;
    }
    
    
    
    
}
