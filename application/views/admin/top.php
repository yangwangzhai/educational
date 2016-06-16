<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="static/ql/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="static/ql/js/jquery.js"></script>
    <script type="text/javascript">
        $(function(){
            //顶部导航切换
            $(".nav li a").click(function(){
                $(".nav li a.selected").removeClass("selected")
                $(this).addClass("selected");
            })
        })
    </script>
</head>

<body style="background:url(static/ql/images/topbg.gif) repeat-x;">
<div class="top">
    <div class="topleft">
        <a href="main.html" target="_parent"><img src="static/ql/images/logo.png" title="系统首页" /></a>
    </div>
    <div class="topright">
        <div class="user">
            <span>admin</span>
            <i>消息</i>
            <b>5</b>
        </div>
        <ul>
            <li><span><img src="static/ql/images/help.png" title="帮助"  class="helpimg"/></span><a href="#">帮助</a></li>
            <li><a href="#">关于</a></li>
            <li><a href="index.php?d=admin&c=common&m=login_out" target="_parent">退出</a></li>
        </ul>
    </div>
</div>
<ul class="nav">
    <li><a href="index.php?d=admin&c=common&m=right" target="rightFrame" class="selected"><img src="static/ql/images/icon01.png" title="主页管理" /><h2>主页管理</h2></a></li>
    <li><a href="index.php?d=admin&c=teacher&m=index" target="rightFrame"><img src="static/ql/images/icon05.png" title="教师信息" /><h2>教师信息</h2></a></li>
    <li><a href="index.php?d=admin&c=invigilate&m=index" target="rightFrame"><img src="static/ql/images/icon06.png" title="监考表" /><h2>监考表</h2></a></li>
    <li><a href="index.php?d=admin&c=student&m=index" target="rightFrame"><img src="static/ql/images/icon04.png" title="学籍档案" /><h2>学籍档案</h2></a></li>
    <li><a href="index.php?d=admin&c=admin&m=index" target="rightFrame"><img src="static/ql/images/icon03.png" title="管理员管理" /><h2>管理员管理</h2></a></li>
    <li><a href="index.php?d=admin&c=test_score&m=notice" target="rightFrame"><img src="static/ql/images/icon07.png" title="公告栏" /><h2>公告栏</h2></a></li>
    <li><a href="index.php?d=admin&c=parents&m=index" target="rightFrame"><img src="static/ql/images/icon02.png" title="家长信息" /><h2>家长信息</h2></a></li>
    <li><a href="index.php?d=examination&c=test&m=index"  target="rightFrame"><img src="static/ql/images/icon08.png" title="试题库" /><h2>试题库</h2></a></li>
</ul>
</body>
</html>

