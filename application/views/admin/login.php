<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>欢迎登录教务后台管理系统</title>
    <link href="static/ql/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="static/ql/js/jquery.js"></script>
    <script language="javascript">
        $(function(){
            $('.loginbox').css({'position':'absolute','left':($(window).width()-630)/2});
            $(window).resize(function(){
                $('.loginbox').css({'position':'absolute','left':($(window).width()-630)/2});
            })
        });
    </script>
</head>

<body style="background-color:#1c77ac; background-image:url(static/ql/images/loginbg.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">
<form method="post" action="index.php?d=admin&c=common&m=check_login">
    <div class="loginbody">
        <span class="systemlogo"></span>
        <div class="loginbox">
            <ul>
                <li><input name="username" type="text" class="loginuser" value="admin" onclick="JavaScript:this.value=''"/></li>
                <li><input name="password" type="text" class="loginpwd" value="密码" onclick="JavaScript:this.value=''"/></li>
                <li><input name="" type="submit" class="loginbtn" value=""  /></li>
            </ul>
        </div>
    </div>
</form>
</body>
</html>
