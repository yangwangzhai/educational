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
        })

        $(".grade_li").click(function(){
            var grade=$(this).children("a").attr("data-grade");
            $("#my_hidden_grade").val(grade);
        })

        //全选
        $(".select_all").on('click',function(){
            $(".my_li").children("a").css("color","#f4816c");
            $(this).attr('select_flag','true');
            var grade=$("#my_hidden_grade").val();
            $.ajax({
                url: "<?=$this->baseurl?>&m=get_firstly_message_all",   //后台处理程序
                type: "post",
                dataType:"json",
                data:{grade:grade},
                success:function(data){
                    $.each(data,function(key,value){
                        var course_id=value['week']+value['section'];
                        $("#"+course_id).text(value['title']);
                    })
                }
            });

        });
        //取消全选
        $(".select_all_cancel").on('click',function(){
            $(".my_li").children("a").css("color","#f0f0f0");
            $(".select_all").attr('select_flag','false');
            //清空表格的禁排信息
            $(".course_firstly").text('');
        });

        //点击变换颜色
        $(".my_li").click(function(){
            var select_flag=$(".select_all").attr('select_flag');
            if(select_flag=='true'){
                var grade=$("#my_hidden_grade").val();
                var classname=$(this).children("a").attr("data-class");
                $("#my_hidden").val(classname);
                //清空表格的禁排信息
                $(".course_firstly").text('');
                $.ajax({
                    url: "<?=$this->baseurl?>&m=get_firstly_message",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{grade:grade,classname:classname},  //要传递的数据
                    success:function(data){
                        $.each(data,function(key,value){
                            var course_id=value['week']+value['section'];
                            $("#"+course_id).text(value['title']);
                        })
                    }
                });
            }else{
                $(".my_li").children("a").css("color","#f0f0f0")
                $(this).children("a").css("color","#f4816c");
                var grade=$("#my_hidden_grade").val();
                var classname=$(this).children("a").attr("data-class");
                $("#my_hidden").val(classname);
                //清空表格的禁排信息
                $(".course_firstly").text('');
                $.ajax({
                    url: "<?=$this->baseurl?>&m=get_firstly_message",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{grade:grade,classname:classname},  //要传递的数据
                    success:function(data){
                        $.each(data,function(key,value){
                            var course_id=value['week']+value['section'];
                            $("#"+course_id).text(value['title']);
                        })
                    }
                });
            }
        });

        //选择课程
        $(".last_li").click(function(){
            $(".last_li").children("a").css("color","#f0f0f0");
            $(this).children("a").css("color","#f4816c");
            var coursename=$(this).children("a").text();
            $("#my_hidden_course").val(coursename);
        })

        //点击表格，不排课或者取消 异步插入数据库
        $(".course_firstly").click(function(){
            var grade=$("#my_hidden_grade").val();
            var coursename=$("#my_hidden_course").val();
            var week=$(this).attr("data-week");
            var section=$(this).attr("data-section");
            var message=$(this).text();
            if(message=='') { //如果为空，则添加
                $(this).text(coursename);
            }else {
                $(this).text('');
            }
            var select_flag=$('.select_all').attr('select_flag');
            if(select_flag=='true'){
                $.ajax({
                    url: "<?=$this->baseurl?>&m=insert_firstly_all",   //后台处理程序
                    type: "post",         //数据发送方式
                    //dataType:"json",    //接受数据格式
                    data:{grade:grade,coursename:coursename,week:week,section:section},  //要传递的数据
                    success:function(data){
                        //alert("返回："+data);
                    }
                });
            }else{
                var classname=$("#my_hidden").val();
                /*alert(classname);
                 alert(coursename);
                 alert(week);
                 alert(section);
                 alert(message);*/
                $.ajax({
                    url: "<?=$this->baseurl?>&m=insert_firstly",   //后台处理程序
                    type: "post",         //数据发送方式
                    //dataType:"json",    //接受数据格式
                    data:{grade:grade,classname:classname,coursename:coursename,week:week,section:section},  //要传递的数据
                    success:function(data){
                        //alert("返回："+data);
                    }
                });
            }
        });

        $(".menu_a1").click(function(){
            location.href="<?=$this->baseurl?>&m=rule_set";
        })

        $(".menu_a2").click(function(){
            location.href="<?=$this->baseurl?>&m=firstly";
        })


    })

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
            location.href="index.php?d=timetable&c=timetable&m=table_state";
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

<script language="javascript">
    $(window).scroll(function() {
        var class_height=$("#middle").height();
        var course_height=$("#middle_table_firstly").height();
        var scroll_top = $(window).scrollTop();
        if(course_height<class_height){
            var top=(class_height-course_height)/2+490;
            $("#middle_table_firstly").css({top:top+"px" });
        }else{
            var top=490;
            $("#middle_table_firstly").css({top:top+"px" });
        }
    });

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
        <div class="soft_con1" style="background:url(static/timetable/images/line_select_002.gif);"></div>
        <div class="soft_con">
            <div id="xzgl" class="soft_con2">
                <div class="function1" id="no_class_paike">
                    <img src="static/timetable/images/pic_fun_crm_detailed_004.gif"/>
                    <p class="p1">不排课时间</p>
                </div>
                <div class="function1" id="first_paike" style="border-color: #1996E6;">
                    <img src="static/timetable/images/pic_fun_crm_detailed_001.gif"/>
                    <p class="p1" style="background-color: #1996E6;font-size: medium;font-weight: bolder;">优先排课时间</p>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-top: 5px;margin-left: 20px;">
        <tr>
            <td><input class="select_all" select_flag="false" type="button" value="全选" data-check="false"/></td>
            <td><input class="select_all_cancel" type="button" value="取消全选" data-check="false"/></td>
        </tr>
    </div>
    <div id="middle">
        <div id="middle_class">
            <div class="content">
                <div id="jquery-accordion-menu" class="jquery-accordion-menu red">
                    <!--<div class="jquery-accordion-menu-header" id="form"></div>-->
                    <input type="hidden" id="my_hidden_grade" value=""/>
                    <input type="hidden" id="my_hidden" value=""/>
                    <input type="hidden" id="my_hidden_course" value=""/>
                    <ul id="demo-list" class="my_aaa">
                        <?php foreach($grade as $grade_key=>$grade_value): ?>
                            <li class="grade_li"><a href="javascript:void(0)" data-grade="<?= $grade_value['grade']?>"><?= $grade_value['grade']?></a>
                                <ul class="submenu">
                                    <?php foreach($classname[$grade_key] as $classname_key=>$classname_value): ?>
                                        <li class="my_li"><a href="javascript:void(0)" data-class="<?= $classname[$grade_key][$classname_key]?>" ><?= $classname_value;?></a>
                                            <ul class="submenu">
                                                <?php foreach($course[$grade_key] as $course_key=>$course_value): ?>
                                                    <li class="last_li"><a href="javascript:void(0)"><?= $course_value;?></a></li>
                                                <?php endforeach;?>
                                            </ul>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="middle_table_firstly" >
        <table id="middle_timetable_firstly" border="1px" cellspacing="0" >
            <tr>
                <td style="width:59px;height:40px;background-color: #0066FF "></td>
                <?php foreach($weeks as $week_key=>$week):?>
                    <td class="week"><?= $week;?></td>
                <?php endforeach;?>
            </tr>
            <?php foreach($sections as $section_key=>$sction):?>
                <tr>
                    <td class="section_firstly"><?=$section_key?></td>
                    <?php foreach($weeks as $week_key=>$week):?>
                        <td style="cursor: pointer;font-family: '微软雅黑', Arial, Helvetica, sans-serif;" id="<?=$week_key.$section_key?>" class="course_firstly" data-week="<?= $week_key?>" data-section="<?= $section_key?>"></td>
                    <?php endforeach;?>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div><!--end for rule-->
</body>


</html>