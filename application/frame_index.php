<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=PRODUCT_NAME?>-总管理后台</title>
<link rel="stylesheet" href="static/admin_img/admincp.css?1" type="text/css" media="all" />
<script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
<meta content="105167721@qq.com" name="Copyright" />
<script type="text/javascript">

// code by tangjian
$(document).ready(function(){
    $('.nav li').click(function(){
    	$('.nav li').removeClass();
		$('.frame_left a').removeClass();
    	$(this).addClass("tabon");

		var index = $(this).index();// 一级栏目索引
    	$(".frame_left > ul").hide().eq( index ).show(); // 显示二级栏
		$(".frame_left > ul").eq( index ).find("a").first().addClass("on");// 选中二级栏第一项
    });

	// 二级栏目 点击 激活
    $('.frame_left a').click(function(){
    	$('.frame_left a').removeClass();
    	$(this).addClass("on");
        });

/*$("#leftdaaa").animate({
    width: "10px",
    height: "100%",
    fontSize: "10em",
    borderWidth: 10
}, 1000 );
*/
});
</script>
<style>
html, body { width: 100%; height: 100%; overflow: hidden; }
</style>
    <style type="text/css">
        #zd{width:160px;margin:0px;}
        #zd h3{cursor:pointer;line-height:30px;height:30px;color: #0a0bcc;}
        #zd a{display:block;line-height:24px;color: #9e0ffe;}
        #zd a:hover{background-color:#eee;color: #BC2A4D;}
        #zd div{display:none;border:0px solid #000;border-top:none;}
    </style>
    <script type="text/javascript">
        function $(id){return document.getElementById(id)}
        window.onload = function(){
            $("zd").onclick = function(e){
                var src = e?e.target:event.srcElement;
                if(src.tagName == "H3"){
                    var next = src.nextElementSibling || src.nextSibling;
                    next.style.display = (next.style.display =="block")?"none":"block";
                }
            }
        }
    </script>
</head>
<body scroll="no">
<div class="mainhd">
	<div class="logo"> <img src="./static/admin_img/logo.png"></div>
	<div class="nav">
		<ul>
			<li><a href="index.php?d=manager&c=article" target="main">家长管理</a></li>
			<li><a href="index.php?d=admin&c=school&m=edit" target="main">招生管理</a></li>
		  	<li><a href="index.php?d=admin&c=document" target="main">教学资源</a></li>
            <li><a href="index.php?d=admin&c=student" target="main">幼儿信息</a></li>
            <li><a href="index.php?d=admin&c=teacher" target="main">教师管理</a></li>
            <li><a href="index.php?d=manager&c=video" target="main">膳食记录</a></li>
			<li><a href="index.php?d=admin&c=admin&m=index" target="main" <?=role('nav/system')?>>系统管理</a></li>
		</ul>
	</div>
	<div class="uinfo">
		<p> 平台管理员<?=$this->admin['username']?>，欢迎登录！<em>
			
			</em> <a href="./" target="_blank">网站首页</a> <a href="index.php?d=admin&c=common&m=login_out" target="_top">退出</a> </p>
	</div>
</div>
<table cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td valign="top" width="160"
				style="background: #F2F9FD; width: 160px; padding-top: 15px;"><div class="frame_left"> 
				<!--家长管理-->
				<ul style="display: none;">
					<li><a href="index.php?d=manager&c=article"
							target="main"> ▪ 家长分组</a></li>
					<li><a href="index.php?d=manager&c=picture"
							target="main"> ▪ 经验分享</a></li>
					<li><a href="index.php?d=manager&c=brief"
							target="main"> ▪ 家长学习</a></li>
				</ul>
			
				<!--招生管理-->
				<ul style="display: none;">
                    <li><a href="index.php?d=admin&c=school&m=edit"
                           target="main"> ▪ 学生资源库</a></li>
                    <li><a href="index.php?d=admin&c=news&m=index&catid=1"
                           target="main"> ▪ 招生计划</a></li>
                    <li><a href="index.php?d=admin&c=news&m=index&catid=2"
                           target="main"> ▪ 招生计划</a></li>
					<li><a href="index.php?d=admin&c=school&m=edit"
							target="main"> ▪ 学校简介</a></li>
                    <li><a href="index.php?d=admin&c=news&m=index&catid=1"
                           target="main"> ▪ 新闻资讯</a></li>
                    <li><a href="index.php?d=admin&c=news&m=index&catid=2"
                           target="main"> ▪ 通知公告</a></li>
                    <li><a href="index.php?d=admin&c=news&m=index&catid=3"
                           target="main"> ▪ 教师工作动态</a></li>
				</ul>
				<!--教学资源-->
				<ul style="display: none;">
                    <h3>▪ 教学素材</h3>
                    <li><a href="index.php?d=admin&c=document"	target="main"> ▪ 教学素材</a></li>
                    <li><a href="index.php?d=admin&c=document"	target="main"> ▪ 课件管理</a></li>
                    <li><a href="index.php?d=admin&c=audio" target="main"> ▪ 音频管理</a></li>
                    <li><a href="index.php?d=admin&c=video" target="main"> ▪ 视频管理</a></li>
                    <div>
                    <li><a href="index.php?d=admin&c=audio" target="main"> ▪ 优秀案例</a></li>
                    </div>
				
				
				<!--幼儿信息-->
				<ul style="display: none;">
                    <li><a href="index.php?d=admin&c=student" target="main"> ▪ 体征数据</a></li>
                    <li><a href="index.php?d=admin&c=student_leave" target="main"> ▪ 成长记录</a></li>
                    <li><a href="index.php?d=admin&c=student" target="main"> ▪ 学籍档案</a></li>
                    <li><a href="index.php?d=admin&c=student_leave" target="main"> ▪ 到校情况</a></li>
					<li><a href="index.php?d=admin&c=student" target="main"> ▪ 学生信息</a></li>
                    <li><a href="index.php?d=admin&c=student_leave" target="main"> ▪ 学生请假</a></li>

				</ul
				<!--教师管理-->
				<ul style="display: none;">
                    <li><a href="index.php?d=admin&c=teacher&m=index" target="main"> ▪ 人事管理</a></li>
                    <li><a href="index.php?d=admin&c=class_list&m=index" target="main"> ▪ 行政管理</a></li>
                    <li><a href="index.php?d=admin&c=teacher_leave" target="main"> ▪ 教学测评</a></li>
                    <li><a href="index.php?d=admin&c=task" target="main"> ▪ 班级管理</a></li>
                    <li><a href="index.php?d=admin&c=teacher&m=index" target="main"> ▪ 教师信息</a></li>
					<li><a href="index.php?d=admin&c=class_list&m=index" target="main"> ▪ 班级列表</a></li>
                    <li><a href="index.php?d=admin&c=teacher_leave" target="main"> ▪ 教师请假</a></li>
                    <li><a href="index.php?d=admin&c=task" target="main"> ▪ 课外作业</a></li>
				</ul>
				
				<!--膳食记录-->
				<ul style="display: none;">		
					<li><a href="index.php?d=manager&c=school" target="main"> ▪
                            营养食谱库</a></li>
					<li><a href="index.php?d=manager&c=timetable&m=index"
							target="main"> ▪ 采购管理</a></li>
					
				</ul>
				<!--系统管理-->
				<ul style="display: none;">
					<li><a href="index.php?d=admin&c=admin&m=index" target="main"> ▪
						管理员管理</a></li>
					<li><a href="index.php?d=admin&c=admin&c=adminlog&m=index" target="main"> ▪
						后台操作日志</a></li>
				</ul>
			</div></td>
		<td valign="top" height="100%"><iframe
					src="index.php?d=admin&c=common&m=main" name="main" width="100%"
					height="90%" frameborder="0" scrolling="yes"
					style="overflow: visible;"></iframe></td>
	</tr>
</table>
</body>
<script type="text/javascript">

    function test(obj){
        if(obj.innerText=="+"){
            myul.style.display="block";
            obj.innerText="-";
        }else if(obj.innerText=="-"){
            myul.style.display="none";
            obj.innerText="+";
        }
    }

</script>
</html>