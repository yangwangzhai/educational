<?php
/**
 * 视频处理函数
 * ryo
 */

/**
 * 视频截图函数
 *
 * @param $ffmpeg ffmpeg绝对路径，如："D:/phptemp/yijiayixiao/static/ffmpeg.exe"
 * @param $video 视频文件路径，如："uploads/video/20150508141122_75118.flv"
 * @param $shotpath 截图存储的路径，如："uploads/videoshot/"
 * @param int $begin 第几秒的图片
 * @param int $width 宽
 * @param int $height 高
 * @return string 图片路径
 */
function get_shot($ffmpeg,$videopath, $shotpath,$begin, $width = 400, $height = 300) {
    $sub_dir = date('Ymd',time()).'/';
    if (!file_exists($shotpath.$sub_dir)){
        mkdir ($shotpath.$sub_dir, 0777, true);
    }
    $actual_name = time().'_'.rand(100000,999999).'.jpg';
    $full = $shotpath.$sub_dir.$actual_name;
    $cmd="$ffmpeg -i $videopath -f image2 -ss $begin -s $width*$height -vframes 1 $full";
    exec($cmd);
    return $full;
}

/**
 * @param $ffmpeg ffmpeg绝对路径，如："D:/phptemp/yijiayixiao/static/ffmpeg.exe"
 * @param $videopath 视频文件路径，如："uploads/foo/20150508141122_75118.mp4"
 * @param $destpath 生成视频存储的路径，如："uploads/video/"
 * @param int $qscale 图像品质，默认为1，越小越清晰，文件越大
 * @param int $resolution 分辨率，默认为 800*480
 * @return string 转换后的路径
 */
function transcoding($ffmpeg,$videopath,$destpath, $qscale = 1,$resolution = 0) {
    $filename_arr = explode('.', $videopath);
    $extension =  end( $filename_arr);

    if(strcasecmp($extension, "flv") == 0) {
        return $videopath;
    }
    else {
        $sub_dir = date('Ymd',time()).'/';
        if (!file_exists($destpath.$sub_dir)){
            mkdir ($destpath.$sub_dir, 0777, true);
        }
        $actual_name = time().'_'.rand(100000,999999).'.flv';
        $full = $destpath.$sub_dir.$actual_name;
        if($resolution)
            $cmd="$ffmpeg -i $videopath -y -ab 32 -ar 22050 -qscale $qscale  -r 15 -s 1280*720 $full";
        else
            $cmd="$ffmpeg -i $videopath -y -ab 32 -ar 22050 -qscale $qscale  -r 15 -s 800*480 $full";
        exec($cmd);
        return $full;
    }
}

/**
 * @param $ffmpeg ffmpeg绝对路径，如："D:/phptemp/yijiayixiao/static/ffmpeg.exe"
 * @param $videopath 视频文件路径，如："uploads/foo/20150508141122_75118.mp4"
 * @param $destpath 生成视频存储的路径，如："uploads/video/"
 * @param $start 起始时间，如：80 & 00:00:01
 * @param $stop 结束时间，同上
 * @return string 转换后的路径
 */
function cut_video($ffmpeg,$videopath,$destpath,$start,$stop) {

    $sub_dir = date('Ymd',time()).'/';
    if (!file_exists($destpath.$sub_dir)){
        mkdir ($destpath.$sub_dir, 0777, true);
    }
    $actual_name = time().'_'.rand(100000,999999).'.flv';
    $full = $destpath.$sub_dir.$actual_name;

    $cmd = "$ffmpeg -i $videopath -ss $start -t $stop -acodec copy -vcodec copy $full";
    exec($cmd);
    return $full;
}

function get_total_time($ffmpeg,$videopath) {
    $cmd = "$ffmpeg -i ".$videopath." 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//";
    $vtime = exec($cmd);
    echo  $vtime;
}


// =============================================


