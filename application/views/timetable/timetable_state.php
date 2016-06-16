<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>中小学排课系统</title>
    <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/rule.css" />
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/style.css" />
    <link href="static/timetable/css/jquery-accordion-menu.css" rel="stylesheet" type="text/css" />
    <!--<link href="static/css/font-awesome.css" rel="stylesheet" type="text/css" />-->
    <script src="static/timetable/js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="static/timetable/js/jquery-accordion-menu.js" type="text/javascript"></script>
    <link rel="stylesheet"	href="static/timetable/js/kindeditor410/themes/default/default.css" />
    <script charset="utf-8" src="static/timetable/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/timetable/js/kindeditor410/lang/zh_CN.js"></script>
    <script type="text/javascript" src="static/timetable/js/common.js?1"></script>
</head>
<style type="text/css">
    #demo-list a{
        overflow:hidden;
        text-overflow:ellipsis;
        -o-text-overflow:ellipsis;
        white-space:nowrap;
        width:100%;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){

        $("#middle_auto_again").on("mouseover",function(){
            $("#middle_auto_again").css({"background":"#9B30FF"});
        });
        $("#middle_auto_again").on("mouseout",function(){
            $("#middle_auto_again").css({"background":"#9F79EE"});
        });

        $("#again").on("click",function(){
            $("#middle_auto_img").remove();
            $("#middle_auto_content").remove();
            $("#middle_auto_again").before("<div id='middle_auto_img'> <img src='static/timetable/images/dong.gif'></div>");
            $("#middle_auto_again").before("<div id='middle_auto_content'>排课中……</div>");
            $("#middle_auto_again").remove();
            location.href="index.php?d=timetable&c=timetable&m=table_all";
        });
    })
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#load_a").on("click",function(){
            var dialog = dialog_url("<?=$this->baseurl?>&m=excel_import_list","导入基础信息",480,250);
        });

        $("#pic_fun_base").on("click",function(){
            location.href="index.php?d=timetable&c=task&m=base_message";
        });
        $("#pic_fun_rule").on("click",function(){
            location.href="index.php?d=timetable&c=rule&m=rule_set";
        });
        $("#pic_fun_paike").on("click",function(){
            location.href="index.php?d=timetable&c=timetable&m=table_state";
        });
        $("#pic_fun_check").on("click",function(){
            location.href="index.php?d=timetable&c=timetable&m=course_list";
        });
        $("#pic_fun_move").on("click",function(){
            location.href="index.php?d=timetable&c=timetable&m=course_move";
        });

        $("#no_class_paike").on("click",function(){
            location.href="<?=$this->baseurl?>&m=rule_set";
        });
        $("#first_paike").on("click",function(){
            location.href="<?=$this->baseurl?>&m=firstly";
        });

    })
</script>

<body>
<div class="task_name">
    <div class="container">
        <div class="taskN" style="float: left;">
            <a title="返回列表" href="index.php?d=timetable&c=task&m=index">当前任务</a>
        </div>
        <div class="task_img">
            <img src="static/timetable/images/jiantou.png" style="height:15px;width:15px;margin-bottom: 2px;"/>
        </div>
        <div class="taskN" >
            <a title="返回列表" href="index.php?d=timetable&c=task&m=base_message"><?= $this->session->userdata('task_name')?></a>
        </div>
    </div>
</div>
<div id="rule">

    <div class="soft_function">
        <div class="soft_con_icon">
            <ul>
                <li id="pic_fun_base"><a id="pic_fun_adm" href="javascript:void(0);"><img src="static/timetable/images/pic_fun_adm_hover.gif" width="150" height="150"/><p style="color:#008dd9">基础信息</p></a></li>
                <li id="pic_fun_rule"><a id="pic_fun_crm" href="javascript:void(0);"><img  src="static/timetable/images/pic_fun_crm.gif" width="150" height="150"/><p>规则条件</p></a></li>
                <li id="pic_fun_paike"><a id="pic_fun_project" href="javascript:void(0);"><img  src="static/timetable/images/pic_fun_mobile.gif" width="150" height="150"/><p>自动排课</p></a></li>
                <li id="pic_fun_check"><a id="pic_fun_k" href="javascript:void(0);"><img  src="static/timetable/images/pic_fun_k.gif" width="150" height="150"/><p>查看课表</p></a></li>
                <li id="pic_fun_move"><a id="pic_fun_mobile" href="javascript:void(0);"><img  src="static/timetable/images/pic_fun_project.gif" width="150" height="150"/><p>调整课表</p></a></li>
            </ul>
        </div>
        <div class="soft_con1" style="background:url(static/timetable/images/line_select_003.gif);"></div>
        <div class="soft_con">
            <div id="xzgl">
                <div id="middle_auto">
                    <div id="middle_auto_img">
                        <img src="static/timetable/images/smile.png">
                    </div>
                    <div id="middle_auto_content">
                        点击，<a href="index.php?d=timetable&c=timetable&m=table_all">开始排课!!!</a>
                    </div>
                    <div id="middle_auto_again">
                        <!--<a href="index.php?d=admin&c=timetable&m=table_replace">再排一次</a>-->
                        <a href="javascript:void(0);" id="again">开始排课</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div><!--end for rule-->
</body>

</html>