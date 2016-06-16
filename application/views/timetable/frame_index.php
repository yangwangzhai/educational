<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= PRODUCT_NAME ?>-学校管理后台</title>
    <link rel="stylesheet" href="static/admin_img/admincp.css?1" type="text/css" media="all"/>
    <script type="text/javascript" src="static/js/jquery-1.7.1.min.js"></script>
    <meta content="105167721@qq.com" name="Copyright"/>
    <script type="text/javascript">

        // code by tangjian
        $(document).ready(function () {
            $('.nav li').click(function () {
                $('.nav li').removeClass();
                $('.frame_left a').removeClass();
                $(this).addClass("tabon");

                var index = $(this).index();// 一级栏目索引
                $(".frame_left > ul").hide().eq(index).show(); // 显示二级栏
                $(".frame_left > ul").eq(index).find("a").first().addClass("on");// 选中二级栏第一项
            });

            // 二级栏目 点击 激活
            $('.frame_left a').click(function () {
                $('.frame_left a').removeClass();
                $(this).addClass("on");
            });

            $(".course_plan").click(function(){
                $(this).addClass("course_plan_css");
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
        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
    </style>
</head>
<body scroll="no">
<div class="mainhd">
    <div class="logo"><img src="./static/admin_img/logo.png"></div>
    <div class="nav">
        <ul>
            <li class="tabon"><a href="index.php?d=admin&c=task" target="main">排课</a></li>
            <li><a href="index.php?d=admin&c=admin&m=index" target="main">管理员管理</a></li>
        </ul>
    </div>
    <div class="uinfo">
        <p> 欢迎 <?= $this->admin['username'] ?> 登录<em>

            </em>  <a href="index.php?d=admin&c=common&m=login_out" target="_top">退出</a>
        </p>
    </div>
</div>
<table cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td valign="top" width="160"
            style="background: #F2F9FD; width: 160px; padding-top: 15px;">
            <div class="frame_left">
                <!--学校班级-->
                <ul >
                    <li><a class="course_plan" href="index.php?d=admin&c=task" target="main">1 排课任务</a></li>
                </ul>
                <!--系统管理-->
                <ul style="display: none;">
                    <li><a href="index.php?d=admin&c=admin&m=index" target="main"> ▪
                            管理员管理</a></li>
                </ul>
            </div>
        </td>
        <td valign="top" height="100%">
            <iframe
                src="index.php?d=admin&&c=task" name="main" width="100%"
                height="90%" frameborder="0" scrolling="yes"
                style="overflow: visible;">
            </iframe>
        </td>
    </tr>
</table>
</body>
</html>