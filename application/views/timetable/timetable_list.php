<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>中小学排课系统</title>
    <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/timetable_list.css" />
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/style.css" />
    <script src="static/timetable/js/jquery-1.11.2.min.js" type="text/javascript"></script>
</head>
<script type="text/javascript">
    $(document).ready(function(){
        $("#li_teacher").on("click",function(){
           location.href="index.php?d=timetable&c=timetable&m=change_teacher";
        });
        $("#li_grade").on("click",function(){
            location.href="index.php?d=timetable&c=timetable&m=change_total";
        });
        $(".download").on("click",function(){
            location.href="index.php?d=timetable&c=timetable&m=out_class";
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

        $("#timetable_class").on("click",function(){
            location.href="index.php?d=timetable&c=timetable&m=course_list";
        });
        $("#timetable_teacher").on("click",function(){
            location.href="index.php?d=timetable&c=timetable&m=change_teacher";
        });
        $("#timetable_all").on("click",function(){
            location.href="index.php?d=timetable&c=timetable&m=change_total";
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
    <div class="soft_con1" style="background:url(static/timetable/images/line_select_004.gif);"></div>
    <div class="soft_con">
        <div id="xzgl" class="soft_con2">
            <div class="function1" id="timetable_class" style="border-color: #1996E6;">
                <img src="static/timetable/images/pic_fun_project_detailed_002.gif"/>
                <p class="p1" style="background-color: #1996E6;font-size: medium;font-weight: bolder;">班级课表</p>
            </div>
            <div class="function1" id="timetable_teacher">
                <img src="static/timetable/images/pic_fun_project_detailed_003.gif"/>
                <p class="p1">教师课表</p>
            </div>
            <div class="function1" id="timetable_all">
                <img src="static/timetable/images/pic_fun_k_detailed_002.gif"/>
                <p class="p1">总课表</p>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <form method="post" action="<?=$this->baseurl?>&m=course_list">
        <ul class="list-inline form-group-sm">
            <li>
                <select class="form-control" id="selGrade" name="grade" onchange="selectGrade()" style="width:120px;">
                    <?php foreach($grades as $grades_value): ?>
                        <option value="<?= $grades_value;?>" <?php if($grade==$grades_value){echo "selected=selected";}?>><?= $grades_value;?></option>
                    <?php endforeach;?>
                </select>
            </li>
            <li>
                <input class="btn btn-primary btn-sm" type="submit" value="查询" >
            </li>
        </ul>
    </form>
</div>
<div class="divDown">
    <div style="float: left;visibility: hidden;"><input type="checkbox" onchange="showTeacher()" id="chkShow" checked="true"/>显示老师</div>
    <div id="down_img" style="float: left;margin-left: 550px;"><img src="static/timetable/images/down.png" style="height:18px;width:18px;margin-bottom: 2px;"/></div>
    <div style="float: left;"><a href="javascript:void(0)" class="download" onclick="down()">导出班级课表</a></div>
</div>
<hr size="1" style="clear: both;width: 93%;margin-left: 20px;" >
<?php foreach($list as $class): ?>
<div style="width: 93%;margin-left: 20px;">
    <h4 style="color: #00CC00;"><?=$class['grade']."(".$class['classname'].")"?></h4>
<table class="table table-bordered" border="1" style="text-align:center" id="1395101133225984">
    <thead style="background-color:#37ABF1">
        <tr id="rightTable_head"><th>&nbsp;</th>
            <?php foreach($weeks as $week_key=>$week):?>
                <th class="week"><?= $week;?></th>
            <?php endforeach;?>
        </tr>
    </thead>
    <tbody>
    <?php foreach($sections as $section_key=>$sction):?>
        <tr>
            <td style="background-color: #37ABF1;"><?=$section_key?></td>
        <?php foreach($weeks as $week_key=>$week):?>
            <td id="td_1395101133225984_7" timeindex="7">
                <div>
                    <span class="courseName"><?=$class['table'][$section_key][$week_key]['title']?></span>
<!--                    <span class="teacherName" style="display: inline;"><?php /*if(!empty($class['table'][$section_key][$week_key]['teacher_truename'])){echo "(".$class['table'][$section_key][$week_key]['teacher_truename'].")";} */?></span>
-->                </div>
            </td>
        <?php endforeach;?>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
</div>
<?php endforeach;?>











</div>
</body>
</html>