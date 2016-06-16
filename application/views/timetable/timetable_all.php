<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>中小学排课系统</title>
    <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css"	href="static/css/table.css" />
    <link rel="stylesheet" type="text/css"	href="static/css/style.css" />
    <link rel="stylesheet"	href="static/js/kindeditor410/themes/default/default.css" />
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <script type="text/javascript" src="static/js/common.js?1"></script>
</head>

<body>
<script>
    function timetable_ajax(grade,classname){
        $.ajax({
            url: "<?=$this->baseurl?>&m=get_course_plan",   //后台处理程序
            type: "post",         //数据发送方式
            dataType:"json",    //接受数据格式
            data:{grade:grade,classname:classname},  //要传递的数据
            success:function(data){
                $("#course_plan tr:not(:first)").remove();// 清空id为course_id的那行
                $.each(data,function(key,value){
                    $("#course_plan tr:last").after("<tr ><td style='width: 100px;'>"+value['course']+"</td></tr>");
                    $("#course_plan tr:last").append("<td style='width: 60px;color: #000000;text-align: center;'>"+value['course_num']+"</td>");
                    //异步获取该班已经排的课程数目
                    $.ajax({
                        url: "<?=$this->baseurl?>&m=get_have_course",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        async: false,       //设置ajax为同步（默认为异步）
                        data:{grade:grade,classname:classname,course:value['course']},  //要传递的数据
                        success:function(mess){
                            var num1=parseInt(value['course_num']);//字符串转为整型
                            var num2=parseInt(mess);        //字符串转为整型
                            var not_course_num=num1-num2;
                            $("#course_plan tr:last").append("<td style='width: 60px;color: #0000cc;text-align: center;'>"+mess+"</td>");
                            $("#course_plan tr:last").append("<td style='width: 60px;color: #dd0000;text-align: center;'>"+not_course_num+"</td>");
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                });
            },
            error:function(XMLHttpRequest, textStatus, errorThrown)
            {
                //alert(errorThrown);
            }
        });
    }

    $(document).ready(function(){
        // 点击表格事件 用于修改 添加课程
        $(".table_content").click(function(){
            //点击之后，对应的班级的课表变颜色
            $('.timetable').removeClass("timetable2");
            $(this).parent().parent().parent().addClass("timetable2");

            var id = $(this).attr("data-id");
            if(id != "") {                          //修改课程
                var grade = $(this).attr("data-grade");
                var classname = $(this).attr("data-classname");
                var week = $(this).attr("data-week");
                var section = $(this).attr("data-section");
                var course=$(this).text();
                dialog = dialog_url("<?=$this->baseurl?>&m=edit&id="+id+"&grade="+grade+"&classname="+classname+"&course="+course,grade+classname+'班--周'+week+'--第'+section+'节',550,350);
                //location.href="<?=$this->baseurl?>&m=edit&id="+id;
                //异步获取该班级的课程计划
                //timetable_ajax(classname);

            } else {                                //添加课程
                //点击，则对应的课表变颜色
                $('.timetable').removeClass("timetable2");
                $(this).parent().parent().parent().addClass("timetable2");

                var grade = $(this).attr("data-grade");
                var classname = $(this).attr("data-classname");
                var class_chiname = $(this).attr("data-class_chiname");
                var week = $(this).attr("data-week");
                var section = $(this).attr("data-section");
                var term = $(this).attr("data-term");
                coursedialog = dialog_url("<?=$this->baseurl?>&m=add&grade="+grade+"&classname="+classname+"&week="+week+"&section="+section,grade+classname+'--周'+week+'--第'+section+'节',500,350);
                //location.href="<?=$this->baseurl?>&m=add&classname="+classname+"&week="+week+"&section="+section;
                //timetable_ajax(classname);
            }
        });

        //点击变颜色，同时列出该班所有课程排课情况
        $(".table_title").click(function(){
            $('.timetable').removeClass("timetable2");
            $(this).parent().parent().parent().addClass("timetable2");
            var grade=$(this).attr("data-grade");
            var classname=$(this).attr("data-classname");
            //var schoolid=$(this).attr("data-schoolid");
            timetable_ajax(grade,classname);
        });


    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#load_a").on("click",function(){
            var dialog = dialog_url("<?=$this->baseurl?>&m=excel_import_list","导入基础信息",480,250);
        });

        $("#pic_fun_base").on("click",function(){
            location.href="index.php?d=admin&c=task&m=base_message";
        });
        $("#pic_fun_rule").on("click",function(){
            location.href="index.php?d=admin&c=rule&m=rule_set";
        });
        $("#pic_fun_paike").on("click",function(){
            location.href="index.php?d=admin&c=timetable&m=table_state";
        });
        $("#pic_fun_check").on("click",function(){
            location.href="index.php?d=admin&c=timetable&m=course_list";
        });
        $("#pic_fun_move").on("click",function(){
            location.href="index.php?d=admin&c=timetable&m=course_move";
        });

        $("#no_class_paike").on("click",function(){
            location.href="<?=$this->baseurl?>&m=rule_set";
        });
        $("#first_paike").on("click",function(){
            location.href="<?=$this->baseurl?>&m=firstly";
        });

    })
</script>

<div class="task_name">
    <div class="container">
        <div class="taskN" style="float: left;">
            <a title="返回列表" href="index.php?d=admin&c=task&m=index">当前任务</a>
        </div>
        <div class="task_img">
            <img src="static/images/jiantou.png" style="height:15px;width:15px;margin-bottom: 2px;"/>
        </div>
        <div class="taskN" >
            <a title="返回列表" href="index.php?d=admin&c=task&m=base_message"><?= $this->session->userdata('task_name')?></a>
        </div>
    </div>
</div>
<div id="container">
        <div class="soft_function">
            <div class="soft_con_icon">
                <ul>
                    <li id="pic_fun_base"><a id="pic_fun_adm" href="javascript:void(0);"><img src="static/images/pic_fun_adm_hover.gif" width="150" height="150"/><p style="color:#008dd9">基础信息</p></a></li>
                    <li id="pic_fun_rule"><a id="pic_fun_crm" href="javascript:void(0);"><img  src="static/images/pic_fun_crm.gif" width="150" height="150"/><p>规则条件</p></a></li>
                    <li id="pic_fun_paike"><a id="pic_fun_project" href="javascript:void(0);"><img  src="static/images/pic_fun_mobile.gif" width="150" height="150"/><p>自动排课</p></a></li>
                    <li id="pic_fun_check"><a id="pic_fun_k" href="javascript:void(0);"><img  src="static/images/pic_fun_k.gif" width="150" height="150"/><p>查看课表</p></a></li>
                    <li id="pic_fun_move"><a id="pic_fun_mobile" href="javascript:void(0);"><img  src="static/images/pic_fun_project.gif" width="150" height="150"/><p>调整课表</p></a></li>
                </ul>
            </div>
            <div class="soft_con1" style="background:url(static/images/line_select_005.gif);"></div>
        </div>
        <div id="main_timetable">
        <?php foreach($list as $class): ?>
        <table  border="1px"  cellpadding="3" cellspacing="0" class="timetable " >
            <tr >
                <td></td>
                <td class="table_title" colspan="<?= count($sections)?>" data-grade="<?=$class['grade']?>"  data-classname="<?=$class['classname']?>"  style="cursor: pointer;" title="查看排课进度"><?=$class['grade']."-".$class['classname']?></td>
            </tr>
            <tr style="background:#F7F7F7">
                <td style="background:#F7F7F7; width:20px;"></td>
                <?php foreach($weeks as $week_key=>$week):?>
                    <td><?= $week;?></td>
                <?php endforeach;?>
            </tr>
            <?php foreach($sections as $section_key=>$sction):?>
            <tr>
                <td style="background:#F7F7F7; width:20px;"><?=$section_key?></td>
                <?php foreach($weeks as $week_key=>$week):?>
                <td id="<?=$class['grade'].$class['classname'].$section_key.$week_key?>" data-term="<?= $term?>" data-grade="<?=$class['grade']?>" data-classname="<?=$class['classname']?>" data-id="<?=$class['table'][$section_key][$week_key]['id']?>" data-week="<?=$week_key?>" data-section="<?=$section_key?>" class="table_content" title="点击编辑">
                    <?=$class['table'][$section_key][$week_key]['title']?>
                </td>
                <?php endforeach;?>
            </tr>
            <?php endforeach;?>
        </table>
            <?php endforeach;?>
            <br />
        </div>
        <div id="change">
            <div id="course_plan">
                <table>
                    <tr style="height: 26px;">
                        <td width="55">科目</td>
                        <td style="width: 55px;color: #000000;text-align: center;">计划</td>
                        <td style="width: 55px;color: #0000cc;text-align: center;">已排</td>
                        <td style="width: 55px;color: #dd0000;font-weight: bolder;text-align: center;">未排</td>
                    </tr>
                </table>
            </div>
        </div>
    <!-- power by tangjian  -->
</div>
<!--<p style="height: 60px;"></p>-->
</body>
</html>
