<?php
/**
 * 常用函数，通用函数
 * by tangjian
 */


/*
    * 创建图片上传目录和缩略图目录
    * @param string $Folder
    * return void
    */
function _mkdir($Folder)
{
    if (!is_dir($Folder)) {
        $dir = explode('/', $Folder);
        $d = "";
        foreach ($dir as $v) {
            if ($v) {
                $d .= $v . '/';
                if (!is_dir($d)) {
                    $state = mkdir($d);
                    if (!$state) {
                        die('在创建目录' . $d . '时出错！');
                    }
                }
            }
        }
    }
}



/**
 *  对一个二维数组，运用array_unique()函数处理。
 *  先将二维降为一维
 *
 **/
function unique($array){
    $temp=array();
    foreach($array as $key=>$vaule){
        foreach($vaule as $k=>$val){
            $temp[]=$val;
        }
    }
    return array_unique($temp);
}

/**
 *  二维数组筛选出最小值
 *
 */
function getMinAndMaxInArray($arr) {
    if(empty($arr)) {
        return array(10,10);
    }
    $disArr = array();
    foreach($arr as $value) {
        $disArr[] = floatval($value['grade']);
    }
    sort($disArr);
    $resArr = !empty($disArr) ? $disArr[0] : array(10,10);
    unset($disArr);
    return $resArr;
}




/**
 *  对一个二维数组，按照某个键值排序。
 *  $array：要排序的二维数组
 *  $array_key：要排序的键值对应的键
 *  $sort：SORT_DESC降序排，SORT_ASC升序排
 *
 **/
function array_sort($array,$array_key,$sort="SORT_DESC"){
    $arrSort = array();
    foreach($array AS $uniqid => $row){
        foreach($row AS $key=>$value){
            $arrSort[$key][$uniqid] = $value;
        }
    }
    array_multisort($arrSort[$array_key], constant($sort), $array);
    return $array;
}

/**
 *已知数组的键值，求对应的键名
 **/
function arr_key($arr,$arr_value)
{
    $trans=array_flip($arr); //反转数组
    $trans_key=$trans[$arr_value];
    return $trans_key;
}

/**
 *随机抽取数组中的一个元素
 **/
function rand_arr($arr)
{
    $rand_key = array_rand($arr);//随机获取数组某个键值
    $title = $arr[$rand_key];   //随机获取某一节课
    return $title;
}
/**
 * 字符截取 支持UTF8/GBK
 *
 * @param
 *            $string
 * @param
 *            $length
 * @param
 *            $dot
 */
function str_cut ($string, $length, $dot = '', $charset = 'utf-8')
{
    $strlen = strlen($string);
    if ($strlen <= $length)
        return $string;
    $string = str_replace(
        array(
            ' ',
            '&nbsp;',
            '&amp;',
            '&quot;',
            '&#039;',
            '&ldquo;',
            '&rdquo;',
            '&mdash;',
            '&lt;',
            '&gt;',
            '&middot;',
            '&hellip;'
        ),
        array(
            '∵',
            ' ',
            '&',
            '"',
            "'",
            '"',
            '"',
            '—',
            '<',
            '>',
            '·',
            '…'
        ), $string);
    $strcut = '';
    if ($charset == 'utf-8') {
        $length = intval($length - strlen($dot) - $length / 3);
        $n = $tn = $noc = 0;
        while ($n < strlen($string)) {
            $t = ord($string[$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1;
                $n ++;
                $noc ++;
            } elseif (194 <= $t && $t <= 223) {
                $tn = 2;
                $n += 2;
                $noc += 2;
            } elseif (224 <= $t && $t <= 239) {
                $tn = 3;
                $n += 3;
                $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $tn = 4;
                $n += 4;
                $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $tn = 5;
                $n += 5;
                $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $tn = 6;
                $n += 6;
                $noc += 2;
            } else {
                $n ++;
            }
            if ($noc >= $length) {
                break;
            }
        }
        if ($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
        $strcut = str_replace(
            array(
                '∵',
                '&',
                '"',
                "'",
                '"',
                '"',
                '—',
                '<',
                '>',
                '·',
                '…'
            ),
            array(
                ' ',
                '&amp;',
                '&quot;',
                '&#039;',
                '&ldquo;',
                '&rdquo;',
                '&mdash;',
                '&lt;',
                '&gt;',
                '&middot;',
                '&hellip;'
            ), $strcut);
    } else {
        $dotlen = strlen($dot);
        $maxi = $length - $dotlen - 1;
        $current_str = '';
        $search_arr = array(
            '&',
            ' ',
            '"',
            "'",
            '"',
            '"',
            '—',
            '<',
            '>',
            '·',
            '…',
            '∵'
        );
        $replace_arr = array(
            '&amp;',
            '&nbsp;',
            '&quot;',
            '&#039;',
            '&ldquo;',
            '&rdquo;',
            '&mdash;',
            '&lt;',
            '&gt;',
            '&middot;',
            '&hellip;',
            ' '
        );
        $search_flip = array_flip($search_arr);
        for ($i = 0; $i < $maxi; $i ++) {
            $current_str = ord($string[$i]) > 127 ? $string[$i] . $string[++ $i] : $string[$i];
            if (in_array($current_str, $search_arr)) {
                $key = $search_flip[$current_str];
                $current_str = str_replace($search_arr[$key],
                    $replace_arr[$key], $current_str);
            }
            $strcut .= $current_str;
        }
    }
    return $strcut . $dot;
}
//截取单双字符的字符串
function utf_substr($str,$len)
{
    for($i=0;$i<$len;$i++)
    {
        $temp_str=substr($str,0,1);
        if(ord($temp_str) > 127)
        {
            $i++;
            if($i<$len)
            {
                $new_str[]=substr($str,0,3);
                $str=substr($str,3);
            }
        }
        else{
            $new_str[]=substr($str,0,1);
            $str=substr($str,1);
        }
    }
    return join($new_str);
}
/**
 * 显示信息
 *
 * @param string $message
 *            内容
 * @param string $url_forward
 *            跳转的网址
 * @param string $title
 *            标题
 * @param int $second
 *            停留的时间
 * @return
 *
 *
 *
 */
function show_msg ($message, $url_forward = '', $title = '提示信息', $second = 3)
{
    include (APPPATH . 'views/show_msg.php');
    exit();
}


/**
 * 图片上传函数
 *
 * @param
 *            string 上传文本框的名称
 * @return string 图片保存在数据库里的路径
 */
function uploadFile ($filename, $dir_name = 'image')
{
    // 有上传文件时
    if (empty($_FILES)) return '';

    $save_path = 'uploads/' .$dir_name . '/';
    $max_size = 8000 * 1024; // 最大文件大小8M
    $AllowedExtensions = array('jpg','jpeg','png','bmp','gif','3gp','amr','aac'); // 允许格式

    $file_size = $_FILES[$filename]['size'];
    if ($file_size > $max_size) {
        return '';
    }
    $Extensions = fileext($_FILES[$filename]['name']);
    if (! in_array($Extensions, $AllowedExtensions)) {
        return '';
    }
    if (! file_exists($save_path)) { // 创建文件夹          
        mkdir($save_path);
    }
    $save_path .= date("Ymd") . "/";
    if (! file_exists($save_path)) {
        mkdir($save_path);
    }
    $file_name = date('YmdHis') . '_' . rand(10000, 99999) . '.' . $Extensions;
    $upload_file = $save_path . $file_name;
    if (move_uploaded_file($_FILES[$filename]['tmp_name'], $upload_file)===false) {
        return '';
    }

    return $upload_file;
}

/**
 * 图片上传函数
 *
 * @param
 *            string 上传文本框的名称
 * @return string 图片保存在数据库里的路径
 */
function uploadVideo ($filename, $dir_name = 'video')
{
    // 有上传文件时
    if (empty($_FILES)) return '';

    $save_path = 'uploads/' .$dir_name . '/';
    $max_size = 500 *1000 * 1024; // 最大文件大小500M
    $AllowedExtensions = array('swf', 'flv', 'mp3', 'wav', 'wma','wmv',   'mid',     'avi', 'mpg', 'asf','rm', 'rmvb','mp4'); // 允许格式

    $file_size = $_FILES[$filename]['size'];
    if ($file_size > $max_size) {
        return '';
    }
    $Extensions = fileext($_FILES[$filename]['name']);
    if (! in_array($Extensions, $AllowedExtensions)) {
        return '';
    }
    if (! file_exists($save_path)) { // 创建文件夹
        mkdir($save_path);
    }
    $save_path .= date("Ymd") . "/";
    if (! file_exists($save_path)) {
        mkdir($save_path);
    }
    $file_name = date('YmdHis') . '_' . rand(10000, 99999) . '.' . $Extensions;
    $upload_file = $save_path . $file_name;
    if (move_uploaded_file($_FILES[$filename]['tmp_name'], $upload_file)===false) {
        return '';
    }

    return $upload_file;
}

/**
 * 生成缩略图函数
 *
 * @param $imgurl 图片路径
 * @param $width 缩略图宽度
 * @param $height 缩略图高度
 * @return string 生成图片的路径 类似：./uploads/201203/img_100_80.jpg
 */
function mythumb ($imgurl, $width = 200, $height = 200)
{
    $fileext = fileext($imgurl);
    $num = strlen($imgurl) - strlen($fileext) - 1;
    $newimg = substr($imgurl, 0, $num) . "_{$width}_{$height}.{$fileext}";

    if (file_exists($newimg))
        return $newimg; // 有，返回

    if (file_exists($imgurl)) { // 没有，开始生成
        include_once APPPATH . '/libraries/My_image_class.php';
        $object = new My_image_class();
        $px = getimagesize($imgurl);
        if ($px[0] > 10) {
            $object->imageCustomSizes($imgurl, $newimg, $width, $height);
            return $newimg;
        }
    }
}

/**
 * 生成缩略图 剪切
 *
 * @param $imgurl 图片路径
 * @param $width 缩略图宽度
 * @param $height 缩略图高度
 * @return string 生成图片的路径 类似：./uploads/201203/img_100_80.jpg
 */
function thumb_resize ($imgurl, $width = 100, $height = 100)
{
    if (empty($imgurl))
        return '不能为空';

    include 'application/libraries/image_moo.php';
    $moo = new Image_moo();
    $moo->load($imgurl);
    $moo->resize($width, $height);
    $moo->save_pa("","_{$width}_{$height}");
}

/**
 * 生成缩略图 剪切
 *
 * @param $imgurl 图片路径
 * @param $width 缩略图宽度
 * @param $height 缩略图高度
 * @return string 生成图片的路径 类似：./uploads/201203/img_100_80.jpg
 */
function thumb ($imgurl, $width = 100, $height = 100)
{
    if (empty($imgurl))
        return '不能为空';

    include_once 'application/libraries/image_moo.php';
    $moo = new Image_moo();
    $moo->load($imgurl);
    $moo->resize_crop($width, $height);
    $moo->save_pa("","_{$width}_{$height}");
}

/**
 * 生成缩略图 剪切
 *
 * @param $imgurl 图片路径
 * @param $width 缩略图宽度
 * @param $height 缩略图高度
 * @return string 生成图片的路径 类似：./uploads/201203/img_smll.jpg
 */
function thumb_small ($imgurl, $width = 200, $height = 200)
{
    if (empty($imgurl))
        return '不能为空';

    include_once 'application/libraries/image_moo.php';
    $moo = new Image_moo();
    $moo->load('../'.$imgurl);
    $moo->resize_crop($width, $height);
    $moo->save_pa("","_small");
}

/**
 * 生成缩略图函数 用CI的  同时生成两张图片  100和720像素的
 *
 * @param $imgurl 图片路径
 * @return void
 */
function thumb2($imgurl)
{
    if (empty($imgurl))
        return '不能为空';

    include 'application/libraries/image_moo.php';
    $moo = new Image_moo();
    $moo->load($imgurl);
    $moo->resize_crop(100, 100);
    $moo->save_pa("","_100_100");
    $moo->resize(1000, 1000);
    $moo->save($imgurl,true);
}

/**
 * 新闻资讯 截图
 *
 * @param $imgurl 图片路径
 * @param $width 缩略图宽度
 * @param $height 缩略图高度
 * @return string 生成图片的路径 类似：uploads/201203/img_smll.jpg
 */
function thumb_news ($imgurl)
{
    if (empty($imgurl)) return '1';

    include_once 'application/libraries/image_moo.php';
    $moo = new Image_moo();
    $moo->load('../'.$imgurl);
    $moo->resize_crop(200, 200);
    $moo->save_pa("","_small");
    $moo->resize_crop(800, 400);
    $moo->save_pa("","_800");
}

/**
 * 取得文件扩展 不包括 点
 *
 * @param $filename 文件名
 * @return 扩展名
 */
function fileext ($filename)
{
    // 获得文件扩展名
    $temp_arr = explode(".", $filename);
    $file_ext = array_pop($temp_arr);
    $file_ext = trim($file_ext);
    $file_ext = strtolower($file_ext);

    return $file_ext;
}

/**
 * 返回新名词 uploads/201203/img_100_80.jpg
 *
 * @param $filename 文件名
 * @return 扩展名
 */
function new_thumbname ($imgurl,$width=100,$height=100)
{
    if(empty($imgurl)) return '';
    $fileext = fileext($imgurl);
    $num = strlen($imgurl) - strlen($fileext) - 1;
    $newimg = substr($imgurl, 0, $num) . "_{$width}_{$height}.{$fileext}";
    return $newimg;
}

/**
 * 返回新名词 uploads/201203/img_100_80.jpg
 *
 * @param $filename 文件名
 * @return 扩展名
 */
function new_name ($imgurl, $append='_small')
{
    if(empty($imgurl)) return '';

    $fileext = fileext($imgurl);
    $num = strlen($imgurl) - strlen($fileext) - 1;
    $newimg = substr($imgurl, 0, $num) . "{$append}.{$fileext}";
    return $newimg;
}

/**
 * 返回新名词 uploads/201203/img_small.jpg
 *
 * @param $filename 文件名
 * @return 扩展名
 */
function small_name ($imgurl)
{
    if(empty($imgurl)) return '';

    $fileext = fileext($imgurl);
    $num = strlen($imgurl) - strlen($fileext) - 1;
    $newimg = substr($imgurl, 0, $num) . "_small.{$fileext}";
    if(file_exists('../'.$newimg)) {
        return config_item('img_url').$newimg;
    }
    $newimg = substr($imgurl, 0, $num) . "_100_100.{$fileext}";
    if(file_exists('../'.$newimg)) {
        return config_item('img_url').$newimg;
    }

    return config_item('img_url').$imgurl;
}



/**
 * 获取请求ip
 *
 * @return ip地址
 */
function ip ()
{
    if (getenv('HTTP_CLIENT_IP') &&
        strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR') &&
        strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR') &&
        strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] &&
        strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches[0] : '';
}

/**
 * 写入缓存
 * $name 文件名
 * $data 数据数组
 *
 * @return ip地址
 */
function set_cache ($name, $data)
{

    // 检查目录写权限
    if (@is_writable(APPPATH . 'cache/') === false) {
        return false;
    }
    file_put_contents(APPPATH . 'cache/' . $name . '.php',
        '<?php return ' . var_export($data, TRUE) . ';');
    return true;
}

/**
 * 获取缓存
 * $name 文件名
 *
 * @return array
 */
function get_cache ($name)
{
    $ret = array();
    $filename = APPPATH . 'cache/' . $name . '.php';
    if (file_exists($filename)) {
        $ret = include $filename;
    }

    return $ret;
}

/**
 * 对数据执行 trim 去左右两边空格
 * mixed $data 数组或者字符串
 *
 * @return mixed
 */
function trims ($data)
{
    if (is_array($data)) {
        foreach ($data as &$r) {
            $r = trims($r);
        }
    } else {
        $data = trim($data);
    }

    return $data;
}

/**
 * 时间处理
 */
function times ($time, $type = 0)
{
    if ($type == 0) {
        return date('Y-m-d', $time);
    } else if($type == 1){
        return date('Y-m-d H:i:s', $time);
    } else if($type == 2){
        return date('Y年m月d日', $time);
    }
}

/**
 * 获取分类 指定id 的信息
 */
function category ($catid, $type = 'name')
{
    $a = get_cache('category');
    return $a[$catid][$type];
}

/**
 * 获取分类 指定id 的信息
 */
function getcitys ($catid, $type = 'name')
{
    $a = get_cache('citys');
    return $a[$catid][$type];
}

/**
 * 后去加密后的 字符
 *
 * @param
 *            string
 * @return string
 */
function get_password ($password)
{
    return md5('gfdgd5454_' . $password);
}

/**
 * 取消反引用 返回经stripslashes处理过的字符串或数组
 *
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes ($string)
{
    if (! is_array($string))
        return stripslashes($string);
    foreach ($string as $key => $val)
        $string[$key] = new_stripslashes($val);
    return $string;
}

/**
 * 将字符串转换为数组
 *
 * @param string $data
 * @return array
 *
 */
function string2array ($data)
{
    if ($data == '')
        return array();
    @eval("\$array = $data;");
    return $array;
}

/**
 * 将数组转换为字符串
 *
 * @param array $data
 * @param bool $isformdata
 * @return string
 *
 */
function array2string ($data, $isformdata = 1)
{
    if ($data == '')
        return '';
    if ($isformdata)
        $data = new_stripslashes($data);
    return (var_export($data, TRUE)); // addslashes
}

/**
 * 得到子级 id 包括自己
 *
 * @param
 *            int
 * @return string
 *
 */
function get_child ($myid)
{
    $ret = $myid;
    $data = get_cache('category');
    foreach ($data as $id => $a) {
        if ($a['parentid'] == $myid) {
            $ret .= ',' . $id;
        }
    }

    return $ret;
}

/**
 * 得到子级 id 包括自己
 *
 * @param
 *            int
 * @return array
 *
 */
function get_childarray ($myid)
{
    $return = array();
    $data = get_cache('category');
    foreach ($data as $id => $a) {
        if ($a['parentid'] == $myid) {
            $return[$id] = $a;
        }
    }

    return $return;
}

// 获取限制条件 返回数组
function getwheres ($intkeys, $strkeys, $randkeys, $likekeys, $pre = '')
{
    $wherearr = array();
    $urls = array();

    foreach ($intkeys as $var) {
        $value = isset($_GET[$var]) ? stripsearchkey($_GET[$var]) : '';
        if (strlen($value)) {
            $wherearr[] = "{$pre}{$var}='" . intval($value) . "'";
            $urls[] = "$var=$value";
        }
    }

    foreach ($strkeys as $var) {
        $value = isset($_GET[$var]) ? stripsearchkey($_GET[$var]) : '';
        if (strlen($value)) {
            $wherearr[] = "{$pre}{$var}='$value'";
            $urls[] = "$var=" . rawurlencode($value);
        }
    }

    foreach ($randkeys as $vars) {
        $value1 = isset($_GET[$vars[1] . '1']) ? $vars[0]($_GET[$vars[1] . '1']) : '';
        $value2 = isset($_GET[$vars[1] . '2']) ? $vars[0]($_GET[$vars[1] . '2']) : '';
        if ($value1) {
            $wherearr[] = "{$pre}{$vars[1]}>='$value1'";
            $urls[] = "{$vars[1]}1=" . rawurlencode($_GET[$vars[1] . '1']);
        }
        if ($value2) {
            $wherearr[] = "{$pre}{$vars[1]}<='$value2'";
            $urls[] = "{$vars[1]}2=" . rawurlencode($_GET[$vars[1] . '2']);
        }
    }

    foreach ($likekeys as $var) {
        $value = isset($_GET[$var]) ? stripsearchkey($_GET[$var]) : '';
        if (strlen($value) > 1) {
            $wherearr[] = "{$pre}{$var} LIKE BINARY '%$value%'";
            $urls[] = "$var=" . rawurlencode($value);
        }
    }

    return array(
        'wherearr' => $wherearr,
        'urls' => $urls
    );
}

// 获取下拉框 选项信息
function getSelect ($data, $value = '', $type = 'key')
{
    $str = '';
    foreach ($data as $k => $v) {
        if ($type == 'key') {
            $seled = ($value == $k && $value) ? 'selected="selected"' : '';
            $str .= "<option value=\"{$k}\" {$seled}>{$v}</option>";
        } else {
            $seled = ($value == $v && $value) ? 'selected="selected"' : '';
            $str .= "<option value=\"{$v}\" {$seled}>{$v}</option>";
        }
    }
    return $str;
}

// 显示友好的时间格式
function timeFromNow($dateline) {
    if(empty($dateline)) return false;
    $seconds = time() - $dateline;
    if ($seconds < 60) {
        return "1分钟前";
    }elseif($seconds < 3600){
        return floor($seconds/60)."分钟前";
    }elseif($seconds  < 24*3600){
        return floor($seconds/3600)."小时前";
    }elseif($seconds < 48*3600){
        return date("昨天 H:i", $dateline)."";
    }else{
        return date('m-d', $dateline);
    }
}

// 获取会员信息 单条
function getMember($id) {
    $CI = &get_instance();
    $query = $CI->db->query("select * from fly_member where id=$id limit 1");
    return $query->row_array();
}

// 获取会员信息 昵称 单条
function getNickName($uid) {
    if(empty($uid)) return "";
    $CI = &get_instance();
    $query = $CI->db->query("select nickname from fly_member where id=$uid limit 1");
    $user = $query->row_array();
    return $user['nickname'];
}

// 获取会员信息 昵称 多条
function getMemberNickname($array) {
    if(empty($array)) return array();

    $str_ids = implode(",", $array);
    $CI = &get_instance();
    $query = $CI->db->query("select id,nickname,avatar from fly_member where id in($str_ids)");
    return $query->result_array();
}

// 数据加上会员信息， 头像 昵称，返回二维数组
function addMember($list, $uid = 'uid') {
    foreach($list as $row) {
        if(!empty($row[$uid])) $ids[] = $row[$uid];
    }

    // 获取 注册会员的昵称
    $memberlist = getMemberNickname($ids);

    foreach($list as &$row) {
        $row['avatar'] = '';
        $row['nickname'] = '游客';
        foreach($memberlist as $member) {
            if($row[$uid] == $member[id]) {
                $row['nickname'] = $member[nickname];
                $row['avatar'] = small_name($member['avatar']);
            }
        }
    }

    return $list;
}

// 数据加上会员信息， 头像 昵称，返回二维数组    私信这里用到
function addMember2($list) {
    foreach($list as $row) {
        if(!empty($row['from_uid'])) $ids[] = $row['from_uid'];
    }

    // 获取 注册会员的昵称
    $memberlist = getMemberNickname($ids);

    foreach($list as &$row) {
        $row['avatar'] = '';
        $row['nickname'] = '游客';
        foreach($memberlist as $member) {
            if($row['from_uid'] == $member[id]) {
                $row['nickname'] = $member[nickname];
                $row['avatar'] = small_name($member['avatar']);
            }
        }
    }

    return $list;
}


// 输出 错误，退出程序 返回 json
function error ($code=0, $msg='have some error')
{
    $error = array( // 返回的错误码
        'error_code' => $code,
        'error_msg' => $msg
    );
    echo json_encode($error, JSON_UNESCAPED_UNICODE);
    exit;
}

// 成功后，输出 json  $data 可以是字符串或者数组
function success ($data='some thing', $id=0)
{
    if (is_string($data)) {
        $data = array(
            'msg' => $data,
            'id' => $id,
            'time' => time()
        );
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

//检查邮箱是否有效
function isemail($email) {
    return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

// 异步执行
function async_request($host, $file, $method='get') {

    $fp = fsockopen($host, 80, $errno, $errstr, 30);
    if (!$fp) {
        echo "$errstr ($errno)<br />\n";
    } else {
        $out = "GET $file / HTTP/1.1\r\n";
        $out .= "Host: www.example.com\r\n";
        $out .= "Connection: Close\r\n\r\n";

        fwrite($fp, $out);
        /*忽略执行结果
         while (!feof($fp)) {
        echo fgets($fp, 128);
        }*/
        fclose($fp);
    }
}

//图文item
function getRuleNewsItem($ruleid) {
    if(is_array($ruleid)) {
        $idsql = "ruleid in('".implode("','",$ruleid)."')";
    } else {
        $idsql = "ruleid='{$ruleid}'";
    }
    $CI = &get_instance();
    $query = $CI->db->query("select * from fly_weixin_news where {$idsql} order by id asc");
    $list = $query->result_array();

    $strArr = array();
    foreach($list as &$value) {
        $value['time'] = timeFromNow($value[addtime]);
        $strArr[$value["ruleid"]][] = $value;
    }
    return $strArr;
}

/**
 * @desc 根据生日获取年龄
 * @param     string $birthday
 * @return    integer
 */
function getAge($birthday) {
    $birthday=getDate(strtotime($birthday));
    $now=getDate();
    $month=0;
    if($now['month']>$birthday['month'])
        $month=1;
    if($now['month']==$birthday['month'])
        if($now['mday']>=$birthday['mday'])
            $month=1;
    return $now['year']-$birthday['year']+$month;
}


/**
 * @desc 将 字符串或者数组
 * @param     mix
 * @return    mix
 */
function getNumber($data) {
    //数组
    if(is_array($data)) {
        foreach ($data as &$value) {
            $value = getNumber($value);
        }
        return $data;
    }

    $result = '';
    $count = mb_strlen($data);
    for($i=0;$i<$count;$i++) {
        $temp = mb_substr($data, $i,1);
        if (is_numeric($temp)) $result .= $temp;
    }

    return $result;
}

/**
 * curl post method
 *
 * @param string $url
 * @param string json $data_string
 * @return json
 */
function http_post_data($url, $data_string) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
    );
    ob_start();
    curl_exec($ch);
    $return_content = ob_get_contents();
    ob_end_clean();

    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return array($return_code, $return_content);
}

// 成功后，输出 json
function show ($status=0, $msg='ok',$id=0)
{
    $error = array(
        'status'=>$status,
        'msg' => $msg,
        'id' => $id,
        'time' => time()
    );
    echo json_encode($error);
    exit;
}

// 统一格式，输出 json
function show_json ($code=0, $msg='ok', $data='')
{
    $result = array(
        'code'=>$code,
        'message' => $msg,
        'time' => time(),
        'data' => $data
    );

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}


// 去空格，前后中的空格
function trim_all ($string)
{
    $search = array(' ', ' ','　',"\r\n", "\n", "\r");
    return str_replace($search, '', trim($string));
}

/**
 * 生成缩略图函数  同时生成两张图片  100和720像素的
 *
 * @param $imgurl 图片路径
 * @return void
 */
function thumb3($imgurl)
{
    if (empty($imgurl))
        return '不能为空';

    include_once 'application/libraries/image_moo.php';
    $moo = new Image_moo();
    $moo->load($imgurl);
    $moo->resize_crop(200, 200);
    $moo->save_pa("","_small");
    $moo->resize(700, 700);
    $moo->save_pa("","_middle");
    $moo->resize(1100, 1100);
    $moo->save_pa("","_big");
}

/**
 * curl post method
 *
 * @param string $url
 * @param array $postFields
 * @return json
 */
function http_post($url, $postFields)
{
    //open connection
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST,count($postFields));
    curl_setopt($ch, CURLOPT_POSTFIELDS,$postFields);
    $fields_string = '';
    foreach ($postFields as $key=>$value)
    {
        $fields_string .= $key.'='.urlencode($value).'&';
    }

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER,'http://'.$_SERVER['HTTP_HOST']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
    //curl_setopt($ch, CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
    //execute post
    $result = curl_exec($ch);
    //print_r($result);
    if($result === false)
    {
        $aError = array('error'=> 'Curl error:' . curl_error($ch));
        return json_encode($aError);
    }
    //close connection
    curl_close($ch);

    return json_decode($result,true);
}
/**
 *计算两个时间的年龄
 */
function get_age($birth,$dodate)
{
    list($by,$bm,$bd)=explode('-',$birth);
    $cm=date('n',strtotime($dodate));
    $cd=date('j',strtotime($dodate));
    $age=date('Y',strtotime($dodate))-$by-1;
    if ($cm>$bm || $cm==$bm && $cd>$bd) $age++;
    return $age;
}






