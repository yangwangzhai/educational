<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>中小学排课系统</title>
    <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/base_message.css" />
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/style.css" />
    <script src="static/timetable/js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script charset="utf-8" src="static/timetable/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/timetable/js/kindeditor410/lang/zh_CN.js"></script>
    <link rel="stylesheet"	href="static/timetable/js/kindeditor410/themes/default/default.css" />
    <script type="text/javascript" src="static/timetable/js/common.js?1"></script>
</head>
<script type="text/javascript">
    $(document).ready(function(){
        $("#upload_message").on("click",function(){
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

        $("#my_course_plan").on("click",function(){
            location.href="<?=$this->baseurl?>&m=base_message";
        });
        $("#my_teacher_plan").on("click",function(){
            location.href="<?=$this->baseurl?>&m=teacher_message";
        });

        $("#down_template").on("click",function(){
            location.href="uploads/file/template/基础信息模板.xls";
        });

        $("#down_keshibiao").on("click",function(){
            location.href="<?=$this->baseurl?>&m=excel_out_list";
        });

        $("#down_teacher_biao").on("click",function(){
            location.href="<?=$this->baseurl?>&m=excel_out_teacher";
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
    <div id="container">

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
            <div class="soft_con1" style="background:url(static/timetable/images/line_select_001.gif);"></div>
            <div class="soft_con">
                <div id="xzgl" class="soft_con2">
                    <div class="function1" id="my_course_plan" style="<?php if($flag=="base"){echo "border-color: #1996E6;";}?>">
                        <img src="static/timetable/images/pic_fun_adm_detailed_001.gif"/>
                        <p class="p1" style="<?php if($flag=="base"){echo "background-color: #1996E6;font-size: medium;font-weight: bolder;";}?>">课时分配</p>
                    </div>
                    <div class="function1" id="my_teacher_plan" style="<?php if($flag=="teacher"){echo "border-color: #1996E6;";}?>">
                        <img src="static/timetable/images/pic_fun_adm_detailed_002.gif"/>
                        <p class="p1" style="<?php if($flag=="teacher"){echo "background-color: #1996E6;font-size: medium;font-weight: bolder;";}?>">教师分配</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="load">
            <ul>
                <li><img id="down_template" src="static/timetable/images/down_template.jpg" style="cursor: pointer;"></li>
                <li><img id="upload_message" src="static/timetable/images/upload_message.jpg" style="cursor: pointer;"></li>
                <!--<li><a href="<?/*=$this->baseurl*/?>&m=excel_import_list">导入信息</a></li>-->
                <?php if($flag=="base"){ ?>
                    <li><img id="down_keshibiao" src="static/timetable/images/down_keshibiao.jpg" style="cursor: pointer;"></li>
                <?php }else{?>
                    <li><img id="down_teacher_biao" src="static/timetable/images/down_teacher_biao.jpg" style="cursor: pointer;"></li>
                <?php }?>
            </ul>
        </div>
        <div id="content">
            <?php if(!empty($list[0])){?>
                <table id="base_table" border="1px" cellspacing="0" >
                    <?php foreach($list as $key=>$value):?>
                        <tr>
                            <?php foreach($value as $k=>$val):?>
                                <td class="info_td"><?=$val;?></td>
                            <?php endforeach;?>
                        </tr>
                    <?php endforeach;?>
                </table>
            <?php }else{?>
                <h5>请先按以下模板导入基础信息（必须严格按照模板样式导入，否则无法导入）</h5>
                <img src="static/timetable/images/base_message_template.png"/>
            <?php }?>
        </div>



    </div>
</body>

</html>