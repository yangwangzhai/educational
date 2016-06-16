<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>中小学排课系统</title>
    <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
    <link rel="stylesheet"	href="static/timetable/js/kindeditor410/themes/default/default.css" />
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/rule.css" />
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/style.css" />
    <link href="static/timetable/css/jquery-accordion-menu.css" rel="stylesheet" type="text/css" />
    <!--<link href="static/css/font-awesome.css" rel="stylesheet" type="text/css" />-->
    <script src="static/timetable/js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="static/timetable/js/jquery-accordion-menu.js" type="text/javascript"></script>
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
    jQuery(document).ready(function () {
        jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
    });

    $(function(){
        //顶部导航切换
        $("#demo-list li").click(function(){
            $("#demo-list li.active").removeClass("active")
            $(this).addClass("active");
        });

        //点击变换颜色
        $(".my_tr").click(function(){
            $(".my_tr").children("td").css("background-color","#ffffff");
            $(this).children("td").css("background-color","#0096be");
            var teacher_id=$(this).attr("data-id");
            $("#my_hidden").val(teacher_id);
            //清空表格的禁排信息
            $(".course").text('');
            $.ajax({
                url: "<?=$this->baseurl?>&m=get_forbid_teacher_message",   //后台处理程序
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{teacher_id:teacher_id},  //要传递的数据
                success:function(data){
                    //alert(data);
                    $.each(data,function(key,value){
                        var course_id=value['week']+value['section'];
                        $("#"+course_id).text("不排课");
                    })
                }
            });
        });

        //点击表格，不排课或者取消 异步插入数据库
        $(".course").click(function(){
            var teacher_id=$("#my_hidden").val();
            var week=$(this).attr("data-week");
            var section=$(this).attr("data-section");
            var message=$(this).text();
            /*alert(teacher_id);
            alert(week);
            alert(section);
            alert(message);*/
            if(message!='不排课'){ //如果为空，则添加
                $(this).text("不排课");
            }else{
                $(this).text('');
            }
            $.ajax({
                url: "<?=$this->baseurl?>&m=insert_forbid_teacher",   //后台处理程序
                type: "post",         //数据发送方式
                //dataType:"json",    //接受数据格式
                data:{teacher_id:teacher_id,week:week,section:section},  //要传递的数据
                success:function(data){
                    //alert(data);
                }
            });
        });

        //异步获取信息
        $("#category").change(function() {
            var forbid_name = $("#category").find("option:selected").val();
            if(forbid_name=='班级不排课时间'){
                location.href="<?=$this->baseurl?>&m=rule_set";
            }else if(forbid_name=='课程不排课时间'){
                location.href="<?=$this->baseurl?>&m=forbid_course";
            }else{
                location.href="<?=$this->baseurl?>&m=forbid_teacher";
            }

        });

        $(".menu_a2").click(function(){
            location.href="<?=$this->baseurl?>&m=firstly";
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
        <div class="task_img_forbid_teacher">
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
        <div class="soft_con1" style="background:url(static/timetable/images/line_select_002.gif);"></div>
        <div class="soft_con">
            <div id="xzgl" class="soft_con2">
                <div class="function1" id="no_class_paike" style="border-color: #1996E6;">
                    <img src="static/timetable/images/pic_fun_crm_detailed_004.gif"/>
                    <p class="p1" style="background-color: #1996E6;font-size: medium;font-weight: bolder;">不排课时间</p>
                </div>
                <div class="function1" id="first_paike">
                    <img src="static/timetable/images/pic_fun_crm_detailed_001.gif"/>
                    <p class="p1">优先排课时间</p>
                </div>
            </div>
        </div>
    </div>

    <div id="middle">
        <select id="category">
            <option value="班级不排课时间">班级不排课时间</option>
            <option value="课程不排课时间" >课程不排课时间</option>
            <option value="教师不排课时间" <?= $forbid_name=="教师不排课时间"? 'selected="selected"':'';?>>教师不排课时间</option>
        </select>
        <div style="margin-top: 5px;">
            <form method="post" action="<?=$this->baseurl?>&m=forbid_teacher">
                <input type="text" name="teacher" value="">
                <input class="btn btn-primary btn-sm" type="submit" value="查询" id="search_teacher_btn">
            </form>

        </div>
        <div id="middle_class">
            <table width="99%" border="1" cellpadding="3" cellspacing="0">
                <input type="hidden" id="my_hidden" value="<?=$teacher_id;?>"/>
                <tr>
                    <th width="60" style="background-color:#0066FF;">姓名</th>
                    <th width="150" style="background-color: #0066FF;">任教科目</th>
                </tr>
                <?php foreach($list as $key=>$r) {?>
                    <tr class="my_tr" data-id="<?=$r['id']?>">
                        <td class="my_td" style="cursor: pointer;height: 30px;<?php if($teacher==$r['teacher']){echo "background-color:#0096be";}?>"><?=$r['teacher']?></td>
                        <td class="my_td" style="cursor: pointer;<?php if($teacher==$r['teacher']){echo "background-color:#0096be";}?>"><?=$r['teach_course']?></td>
                    </tr>
                <?php }?>
            </table>
            <div class="margintop">
                <ul>
                    <!--<li style="height: 20px;">共:<?/*=$count*/?>条</li>-->
                    <li style="height: 20px;"><?=$pages?></li>
                </ul>
            </div>
        </div>
    </div>
    <div style="width: 730px;height: 400px;float: left;margin-left: 20px;margin-top: 3px;">
        <div class="mainbox">
        <table id="middle_timetable" border="1px" cellspacing="0" >
            <tr>
                <td style="width:59px;height:45px;background-color: #0066FF "></td>
                <?php foreach($weeks as $week_key=>$week):?>
                    <td class="week"><?= $week;?></td>
                <?php endforeach;?>
            </tr>
            <?php foreach($sections as $section_key=>$sction):?>
                <tr>
                    <td class="section" style="height: 43px;"><?=$section_key?></td>
                    <?php foreach($weeks as $week_key=>$week):?>
                        <td style="cursor: pointer;font-family: '微软雅黑', Arial, Helvetica, sans-serif;"
                            id="<?=$week_key.$section_key?>" class="course" data-week="<?= $week_key?>"
                            data-section="<?= $section_key?>">
                            <?php if(($week_section['week'].$week_section['section'])==$week_key.$section_key){echo "不排课";}?>
                        </td>
                    <?php endforeach;?>
                </tr>
            <?php endforeach;?>
        </table>
        </div>
    </div>
</div><!--end for rule-->
</body>
<!--<script type="text/javascript">
    (function($) {
        $.expr[":"].Contains = function(a, i, m) {
            return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
        };
        function filterList(header, list) {
            //@header 头部元素
            //@list 无需列表
            //创建一个搜素表单
            var form = $("<form>").attr({
                "class":"filterform",
                action:"#"
            }), input = $("<input>").attr({
                "class":"filterinput",
                type:"text"
            });
            $(form).append(input).appendTo(header);
            $(input).change(function() {
                var filter = $(this).val();
                if (filter) {
                    $matches = $(list).find("a:Contains(" + filter + ")").parent();
                    $("li", list).not($matches).slideUp();
                    $matches.slideDown();
                } else {
                    $(list).find("li").slideDown();
                }
                return false;
            }).keyup(function() {
                $(this).change();
            });
        }
        $(function() {
            filterList($("#form"), $("#demo-list"));
        });
    })(jQuery);
</script>-->

</html>