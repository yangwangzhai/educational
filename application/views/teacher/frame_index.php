<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=PRODUCT_NAME?>-教师端</title>
<link rel="stylesheet" href="static/admin_img/admincp.css?1" type="text/css" media="all" />
<script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
<meta content="105167721@qq.com" name="Copyright" />
<script type="text/javascript">

// code by tangjian
$(document).ready(function(){
    $('.nav li').click(function(){
    	$('.nav li').removeClass();
		$('.frame_left a').removeClass();
    	/*$(this).addClass("tabon");//导航栏选中*/
        $(this).children("a").css({
            "background":"#FFF",
            'color' : '#f77b01'
        });
        var thisA=$(this).children("a").html();
        $(this).parent().children().each(function(){
            if($(this).children("a").html()!=thisA)
            {
                $(this).children("a").removeAttr("style");
            }

        });
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
</head>
<body scroll="no">
<div class="mainhd">
	<div class="logo"> <img src="./static/admin_img/logo.png"></div>

    <div class="nav">
		<ul>
            <li><a href="index.php?d=teacher&c=teacher_leave&m=index" target="main">个人中心</a></li>
            <li><a href="index.php?d=teacher&c=student" target="main">学生管理</a></li>
			<li><a href="index.php?d=teacher&c=&c=parents" target="main">家长管理</a></li>
            <li><a href="index.php?d=teacher&c=class_list&m=index" target="main">班级管理</a></li>
		  	<li><a href="index.php?d=teacher&c=teacher&m=detail" target="main">个人设置</a></li>

		</ul>
	</div>
	<div class="uinfo">
		<p> 欢迎<?=$this->teacher['truename']?>老师！<a href="javascript:history.go(-1);" title="返回上一页"><img src="./static/admin_img/back.png"></a><a href="index.php?d=teacher&c=common&m=index"><img src="./static/admin_img/home.png"></a></a> <a href="index.php?d=teacher&c=common&m=login_out" target="_top"><img src="./static/admin_img/exit.png"></a> </p>
	</div>
</div>
<table cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td valign="top" width="160"
				style="background: #eeeeee; width: 160px; padding-top: 15px;"><div class="frame_left">
                <ul style="display: none;">
                    <li><a href="index.php?d=teacher&c=teacher_leave&m=index" target="main"> ▪ 行政管理</a></li>
                    <li><a href="index.php?d=teacher&c=assessment" target="main"> ▪ 教师测评</a></li>
                    <li><a href="index.php?d=teacher&c=train&m=index" target="main"> ▪ 培训信息</a></li>
                    <li><a href="index.php?d=teacher&c=contract&m=index" target="main"> ▪ 合同信息</a></li>
                    <li><a href="index.php?d=teacher&c=salary&m=index" target="main"> ▪ 薪酬信息</a></li>
                    <li><a href="index.php?d=teacher&c=attendance&m=detail" target="main"> ▪ 考勤管理</a></li>
                    <li><a href="index.php?d=teacher&c=attendance&m=set_month" target="main"> ▪ 考勤时间设置</a></li>

                </ul>
                <!--幼儿信息-->
                <ul style="display: none;">
                    <li><a href="index.php?d=teacher&c=student" target="main"> ▪ 学生管理</a></li>
                    <li><a href="index.php?d=teacher&c=physical" target="main"> ▪ 体征数据</a></li>
                    <li><a href="index.php?d=teacher&c=footmark" target="main"> ▪ 学期表现</a></li>
                    <li><a href="index.php?d=teacher&c=record" target="main"> ▪ 成长记录</a></li>
                    <li><a href="index.php?d=teacher&c=student_leave" target="main"> ▪ 学生请假</a></li>

                </ul
				<!--家长管理-->
				<ul style="display: none;">
					<li><a href="index.php?d=teacher&c=parents"
							target="main"> ▪ 家长信息</a></li>
					<li><a href="index.php?d=teacher&c=share"
							target="main"> ▪ 经验分享</a></li>
                    <li><a href="index.php?d=teacher&c=feedback&m=index"
                           target="main"> ▪ 家长反馈</a></li>

				</ul>
                <ul style="display: none;">
                    <li><a href="index.php?d=teacher&c=class_list&m=index"
                           target="main"> ▪ 班级选择</a></li>
                    <li><a href="index.php?d=teacher&c=class_list&m=class_info"
                           target="main"> ▪ 班级信息</a></li>
                    <li><a href="index.php?d=teacher&c=class_list&m=review_list"
                           target="main"> ▪ 班级月评</a></li>
                    <li><a href="index.php?d=teacher&c=menu&m=index"
                           target="main"> ▪ 班级食谱</a></li>
                </ul>
				<!--招生管理-->
				<ul style="display: none;">
                    <li><a href="index.php?d=teacher&c=teacher&m=edit"
                           target="main"> ▪ 个人资料</a></li>
                    <li><a href="index.php?d=teacher&c=teacher&m=history"
                           target="main"> ▪ 教育/培训</a></li>
                    <li><a href="index.php?d=teacher&c=teacher&m=password"
                           target="main"> ▪ 修改密码</a></li>
				</ul>
			</div></td>
		<td valign="top" height="100%"><iframe
					src="index.php?d=teacher&c=common&m=main" name="main" width="100%"
					height="90%" frameborder="0" scrolling="yes"
					style="overflow: visible;"></iframe></td>
	</tr>
</table>
</body>
</html>