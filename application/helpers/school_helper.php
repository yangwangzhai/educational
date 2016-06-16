<?php
/**
 * 本项目用的函数，或包含CI用的 函数
 * by tangjian 
 */


/**
 * @desc  角色权限 管理
 * @param     number
 * @return    string
 */
function role($title) {
	return;
	if (empty ( $title )){
		return '';
	}
	$CI =& get_instance();
	$groupid = $CI->session->userdata('catid');	
	
	$list[1] = array(); // 超级管理员
	$list[2] = array('news/status','nav/system'); // 普通管理员

	if ( in_array ( $title ,  $list[$groupid] )) {
		return 'style="display:none;"';
	}
}


/**
 * @desc 为班级ID 加上中文 2012级1班
 * @param     number
 * @return    string
 */
function setClassname($number) {
	if(strlen($number)<4) {
		return $number; 
	}	
	$result = '';	
	// 多个班级名称 20121,20131
	$pos  =  strpos ( $number ,  ',' );
	if($pos !== false) {
		$array = explode(',', $number);
		foreach ($array as &$value) {
			$value = setClassname($value);
		}
		return join($array,',');
	}
	$array = str_split ( $number,  4 );
	$result = join('级', $array).'班';
	return $result;
}

/**
 * @desc 根据会员表主键，自动生成用户名: uid + 二位随机数字 + 8
 * @param     number
 * @return    string
 */
function make_username($uid) {
	$ci = &get_instance();
	$ci->load->helper('string');
	$username = $uid.random_string('nozero', 2).'8';	
	return $username;
}


/**
 * @desc 获取学校中文名称
 * @param     number
 * @return    string
 */
function get_schoolname($schoolid) {
	$ci = &get_instance();
	$query = $ci->db->query ( "select title from fly_school where id='$schoolid' limit 1" );
	$value = $query->row_array();	
	return $value['title'];
}

/**
 * @desc 为班级加入汉字， 小小1班
 * @param     number
 * @return    string
 */
function setNames($arr) {
	
	$temp = explode(',', $arr);	
	$foo = array();

	foreach ($temp as $item) {
		$item = trim($item);
		$foo[] = setName($item);
	}
	return $foo;
}

/**
 * @desc 数字数组加汉字
 * @param     number
 * @return    string
 */
function setArrNames($arr) {

	foreach ($arr as $item) {
		$item = trim($item);
		$foo[] = setName($item);
	}
	return $foo;
}

/**
 * @desc 数字，数字  转   小X班，大X班
 * @param     number
 * @return    string
 */
function setNamesInSplit($arr) {

	$temp = explode(',', $arr);
	$foo = array();

	foreach ($temp as $item) {
		$item = trim($item);
		$foo[] = setName($item);
	}
	return implode('，', $foo);
}

/**
 * @desc 为班级加入汉字， 20141 变为 小小1班
 * @param     number
 * @return    string
 */
function setName($number) {
	$year = substr($number, 0, 4);
	$classNo = substr($number,4, 1);
	if($year) {
		$num = intval(date('Y')) - intval($year);
		switch ($num) {
			case 0:
				$num = '小小';
				break;
			case 1:
				$num = '小';
				break;
			case 2:
				$num = '中';
				break;
			case 3:
				$num = '大';
				break;
			case 4:
				$num = '学前';
		}
		$num .= $classNo.'班';
		return $num;
	}
	return null;
}

/**
 * @desc 为班级加入汉字，数组形式
 * @param     string
 * @return    string
 */
function setSomeNames($str) {
	$arr = explode(',', $str);
	$result = array();
	foreach ($arr as $value => $item) {
		$result[] = setName($item);
	}
	return implode(',', $result);
}

/**
 * @desc 将班级号转成班级类别,如 20141转成1
 * @param     int
 * @return    int
 */
function setClassType($classname) {
	$year = substr($classname, 0, 4);
	$classNo = substr($classname,4, 1);
	$num = intval(date('Y')) - intval($year);
	return $num;
}

/**
 * @desc 将班级类别转成班级文字类别,如 小班  转成 1
 * @param     string
 * @return    int
 */
function setClassNumType($classNameType) {
	switch ($classNameType) {
		case '小小班':
			$num = 0;
			break;
		case '小班':
			$num = 1;
			break;
		case '中班':
			$num = 2;
			break;
		case '大班':
			$num = 3;
			break;
		case '学前班':
			$num = 4;
	}

	return $num;
}

/**
 * @desc 将班级文字类别转成班级类别,如 1转成 小班
 * @param     int
 * @return    string
 */
function setType2Class($classNameType) {
	switch (intval($classNameType)) {
		case 0:
			$num = '小小班';
			break;
		case 1:
			$num = '小班';
			break;
		case 2:
			$num = '中班';
			break;
		case 3:
			$num = '大班';
			break;
		case 4:
			$num = '学前班';
	}

	return $num;
}

/**
 * @desc 将班级数组转成数字数组，如{'大1班','中2班'}转成{41,32}
 * @param     array
 * @return    array
 */
function getNames($arr) {
	$foo = array();
	foreach ($arr as $item) {
		$foo[] = getName($item);
	}
	return $foo;
} 

/**
 * @desc 将小1班转成 20141
 * @param string $str
 * @return integer $classname
 */
function getName($str) {
	$classname = "";
	$year = date('Y');
	if(strstr($str,"小小")) {
		$classname .= $year;
		$classname .= getNumber($str);
	}
	else if(strstr($str,"小")) {
		$classname .= $year - 1;
		$classname .= getNumber($str);
	}
	else if(strstr($str,"中")) {
		$classname .= $year - 2;
		$classname .= getNumber($str);
	}
	else if(strstr($str,"大")) {
		$classname .= $year - 3;
		$classname .= getNumber($str);
	}
	else if(strstr($str,"学前")) {
		$classname .= $year - 4;
		$classname .= getNumber($str);
	}
	return intval($classname);
}


/**
 * 过滤数组
 *
 * @desc将待过滤字符串中的空值去掉
 * @param  $delimiter  char 分割字符
 * @param  $str  string    待分割字符串
 * @return    string		返回
 */
function arrayFilter($delimiter, $string) {
	$foo = explode($delimiter, $string);
	foreach ($foo as $value=>$item) {
		if(trim($item) == '') {
			unset($foo[$value]);
		}
	}
	return implode($delimiter, $foo);
}

/**
 * 健康状态 
 * 
 * @desc将一组数字状态转成一组文字数组
 * @param     string
 * @return    string
 */
function setMultiplyStatus($arr) {
	$foo = array();
	$arr = explode(',', $arr);
	foreach ($arr as $item) {
		$foo[] = setSingerStatus($item);
	}
	return implode(',', $foo);
}

/**
 * @desc 将1转成星期一
 *
 * @param     string $meal
 * @return    string $result
 */
function numChangeToMeal($meal) {
	$meal = intval($meal);
	switch ($meal) {
		case 0:
			$result = "早餐";
			break;
		case 1 :
			$result = "午餐";
			break;
		case 2 :
			$result = "午点";
			break;
		case 3 :
			$result = "晚餐";
	}
	return $result;
}

/**
 * @desc 将单个数字状态转成文字状态
 * @param     number
 * @return    string
 */
function setSingerStatus($number) {
	$number = intval($number);
	switch ($number) {
		case 1:
			$number = '体温正常';
	   		break;
		case 2:
			$number = '发烧';
			break;
		case 3:
			$number = '喝得少';
			break;
		case 4:
			$number = '吃得好';
			break;
		case 5:
			$number = '吃得少';
			break;
		case 6 :
			$number = '没便便';
			break;
		case 7 :
			$number = '开心';
			break;
		case 8 :
			$number = '大哭';
			break;
		case 9 :
			$number = '肚子痛';
			break;
		case 10 :
			$number = '流鼻涕';
			break;
		case 11 :
			$number = '不睡觉';
			break;
		case 12 :
			$number = '发怒';
			
	}
	return $number;
}

/**
 * @desc 将{'h01','h10','h11'}转成
 * 
 * @param     string $str
 * @return    string $result
 */
function hChangeToNum($str) {
	$result = explode(',', $str);
	
	foreach ($result as &$item) {
		$item = intval(substr($item, 1));
	}
	return implode(',', $result);
}

/**
 * @desc 形如1,11转成 h01,h11
 *
 * @param     string $str
 * @return    string $result
 */
function numAddH($str) {
	$result = explode(',', $str);
	foreach ($result as &$item) {
		if(strlen($item) == 1) {
			$item = 'h0'.$item;
		}
		else {
			$item = 'h'.$item;
		}
	}
	return implode(',', $result);
}




