<?php error_reporting(0)?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, minimum-scale= 1.0, initial-scale= 1.0">
    <title><?=PRODUCT_NAME?>-教师端</title>
    <link rel="stylesheet" href="static/js/timelinr/style/base.css">
</head>
<body>

<div style="text-align:center;margin:50px 0; font:normal 14px/24px 'MicroSoft YaHei';"><p></p></div>

<div class="htmleaf-container">
    <div class="container">
        <div id="timeline">
            <?php foreach($list as $key=>$item):?>
                <?php if($key%2!=0):?>
            <div class="timeline-item">
                <div class="timeline-icon">
                    <img src="static/js/timelinr/images/star.svg" alt="">
                </div>
                <div class="timeline-content">
                    <h2><?=$key?>月月评</h2>
                    <h3><?php if($item['civilized']=='0')echo '非文明班级'?><?php if($item['civilized']=='1')echo '文明班级'?><?php if($item['civilized']==null)echo '未评月评'?></h3>
                    <p>班级情况:</p>
                    <a href="javascript:void(0)" class="btn">详情。。。</a>
                </div>
            </div>
            <?PHP else:?>
            <div class="timeline-item">
                <div class="timeline-icon">
                    <img src="static/js/timelinr/images/book.svg" alt="">
                </div>
                <div class="timeline-content right">
                    <h2><?=$key?>月月评</h2>
                    <h3><?php if($item['civilized']=='0')echo '非文明班级'?><?php if($item['civilized']=='1')echo '文明班级'?><?php if($item['civilized']==null)echo '未评月评'?></h3>
                    <p>班级情况:<?=$item['situation']?></p>
                    <a href="javascript:void(0)" class="btn">详情。。。</a>
                </div>
            </div>
                    <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
</div>

<!--<div style="text-align:center;margin:50px 0; font:normal 14px/24px 'MicroSoft YaHei';">
    <p>适用浏览器：360、FireFox、Chrome、Safari、Opera、傲游、搜狗、世界之窗. 不支持IE8及以下浏览器。</p>
    <p>来源：<a href="http://down.admin5.com" target="_blank">A5源码</a></p>
</div>-->
</body>
</html>