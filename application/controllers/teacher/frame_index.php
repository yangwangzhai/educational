<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=PRODUCT_NAME?>-园长端</title>
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
            <li><a href="index.php?d=admin&c=teacher" target="main">教师管理</a></li>
            <li><a href="index.php?d=admin&c=student" target="main">幼儿信息</a></li>
			<li><a href="index.php?d=admin&c=&c=parents" target="main">家长管理</a></li>
			<li><a href="index.php?d=admin&c=recruit_student" target="main">招生管理</a></li>
		  	<li><a href="index.php?d=admin&c=resource&catid=1" target="main">教学资源</a></li>
            <li><a href="index.php?d=admin&c=school&m=edit" target="main">运营分析</a></li>

            <li><a href="index.php?d=admin&c=menu" target="main">膳食记录</a></li>

			<li><a href="index.php?d=admin&c=admin&m=index" target="main" <?=role('nav/system')?>>系统管理</a></li>
		</ul>
	</div>
	<div class="uinfo">
		<p> 平台管理员<?=$this->admin['username']?>，欢迎登录！<a href="javascript:history.go(-1);" title="返回上一页"><img src="./static/admin_img/back.png"></a><a href="index.php?d=admin&c=common&m=index"><img src="./static/admin_img/home.png"></a></a> <a href="index.php?d=admin&c=common&m=login_out" target="_top"><img src="./static/admin_img/exit.png"></a> </p>
	</div>
</div>
<table cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td valign="top" width="160"
				style="background: #eeeeee; width: 160px; padding-top: 15px;"><div class="frame_left">
                <!--教师管理-->
                <ul style="display: none;">
                    <li><a href="index.php?d=admin&c=teacher&m=index" target="main"> ▪ 人事档案</a></li>
                    <li><a href="index.php?d=admin&c=teacher_leave&m=index" target="main"> ▪ 行政管理</a></li>
                    <li><a href="index.php?d=admin&c=assessment" target="main"> ▪ 教师测评</a></li>
                    <li><a href="index.php?d=admin&c=class_list&m=main" target="main"> ▪ 班级管理</a></li>
                    <li><a href="index.php?d=admin&c=jobs&m=index" target="main"> ▪ 招聘管理</a></li>
                    <li><a href="index.php?d=admin&c=train&m=index" target="main"> ▪ 培训管理</a></li>
                    <li><a href="index.php?d=admin&c=contract&m=index" target="main"> ▪ 合同管理</a></li>
                    <li><a href="index.php?d=admin&c=salary&m=index" target="main"> ▪ 薪酬管理</a></li>
                    <li><a href="index.php?d=admin&c=attendance&m=index" target="main"> ▪ 考勤管理</a></li>
                    <li><a href="index.php?d=admin&c=attendance&m=set_month" target="main"> ▪ 考勤时间设置</a></li>
                   <!-- <li><a href="index.php?d=admin&c=node&m=index" target="main"> ▪ 节点提醒</a></li>-->
                    <!--<li><a href="index.php?d=admin&c=task" target="main"> ▪ 课外作业</a></li>-->
                </ul>
                <!--幼儿信息-->
                <ul style="display: none;">
                    <li><a href="index.php?d=admin&c=student" target="main"> ▪ 学籍档案</a></li>
                    <li><a href="index.php?d=admin&c=physical" target="main"> ▪ 体征数据</a></li>
                    <li><a href="index.php?d=admin&c=footmark" target="main"> ▪ 学期表现</a></li>
                    <li><a href="index.php?d=admin&c=record" target="main"> ▪ 成长记录</a></li>
                    <!--<li><a href="index.php?d=admin&c=inout_stat" target="main"> ▪ 到校情况</a></li>-->
                    <li><a href="index.php?d=admin&c=student_leave" target="main"> ▪ 学生请假</a></li>

                </ul
				<!--家长管理-->
				<ul style="display: none;">
					<li><a href="index.php?d=admin&c=parents"
							target="main"> ▪ 家长信息</a></li>
                    <li><a href="index.php?d=admin&c=parents&m=main"
                           target="main"> ▪ 家长分组</a></li>
					<li><a href="index.php?d=admin&c=share"
							target="main"> ▪ 经验分享</a></li>
					<li><a href="index.php?d=admin&c=parents_study&m=index"
							target="main"> ▪ 家长学习</a></li>
                    <li><a href="index.php?d=admin&c=feedback&m=index"
                           target="main"> ▪ 家长反馈</a></li>

				</ul>

				<!--招生管理-->
				<ul style="display: none;">
                    <li><a href="index.php?d=admin&c=recruit_student&m=index"
                           target="main"> ▪ 学生资源库</a></li>
                    <li><a href="index.php?d=admin&c=recruit_plan&m=index"
                           target="main"> ▪ 招生计划</a></li>
                    <li><a href="index.php?d=admin&c=recruit_statistics&m=index"
                           target="main"> ▪ 招生统计</a></li>
				</ul>
				<!--教学资源-->
				<ul style="display: none;">
                    <li><a href="index.php?d=admin&c=resource&catid=1"	target="main"> ▪ 教学素材</a></li>
                    <li><a href="index.php?d=admin&c=resource&catid=2" target="main"> ▪ 优秀案例</a></li>
                    <li><a href="index.php?d=admin&c=package&m=main"	target="main"> ▪ 问答资源包</a></li>
				</ul>
                <!--运营分析-->
                <ul style="display: none;">

                    <!--<li><a href="index.php?d=admin&c=resource&catid=2" target="main"> ▪ 教学教案</a></li>
                    <li><a href="index.php?d=admin&c=package&m=main"	target="main"> ▪ 教学计划</a></li>-->
                    <li><a href="index.php?d=admin&c=attendance&m=main&pubdate=<?=date('Y-m',strtotime('-1 month',time()))?>" target="main"> ▪ 教师考勤</a></li>
                    <li><a href="index.php?d=admin&c=teacher&m=statistic"	target="main"> ▪ 师资统计</a></li>

                    <li><a href="index.php?d=admin&c=class_list&m=statistic" target="main"> ▪ 班级统计</a></li>
                    <!--<li><a href="index.php?d=admin&c=student&m=reason" target="main"> ▪ 入离园分析</a></li>
                    <li><a href="index.php?d=admin&c=student&m=statistic" target="main"> ▪ 幼儿分析</a></li>-->
                    <li><a href="index.php?d=admin&c=parents&m=statistic" target="main"> ▪ 家长统计</a></li>
                    <li><a href="index.php?d=admin&c=feedback&m=statistic" target="main"> ▪ 家长反馈</a></li>
                    <li><a href="index.php?d=admin&c=recruit_plan&m=statistic" target="main"> ▪ 招生统计</a></li>
                </ul>
				<!--膳食记录-->
				<ul style="display: none;">
                    <li><a href="index.php?d=admin&c=menu" target="main"> ▪
                            一周食谱</a></li>
					<li><a href="index.php?d=admin&c=recipes" target="main"> ▪
                            营养食谱库</a></li>
					<li><a href="index.php?d=admin&c=purchase&m=index"
							target="main"> ▪ 采购管理</a></li>

				</ul>
                <!--公告通知
                <ul style="display: none;">
                    <li><a href="index.php?d=admin&c=school&m=edit"
                           target="main"> ▪ 学校简介</a></li>
                    <li><a href="index.php?d=admin&c=news&m=index&catid=1"
                           target="main"> ▪ 新闻资讯</a></li>
                    <li><a href="index.php?d=admin&c=news&m=index&catid=2"
                           target="main"> ▪ 通知公告</a></li>
                    <li><a href="index.php?d=admin&c=news&m=index&catid=3"
                           target="main"> ▪ 教师工作动态</a></li>

                </ul>-->
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
</html>