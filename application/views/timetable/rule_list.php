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
    jQuery(document).ready(function () {
        jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
    });

    $(function(){
        //顶部导航切换
        $("#demo-list li").click(function(){
            $("#demo-list li.active").removeClass("active")
            $(this).addClass("active");
        })
        //全选
        $(".select_all").on('click',function(){
            $(".my_li").children("a").css("color","#f4816c");
            $(this).attr('select_flag','true');
            var grade=$("#my_hidden_grade").val();
            $.ajax({
                url: "<?=$this->baseurl?>&m=get_forbid_class_message_all",   //后台处理程序
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{grade:grade},  //要传递的数据
                success:function(data){
                    $.each(data,function(key,value){
                        var course_id=value['week']+value['section'];
                        if(value['title']==null){
                            $("#"+course_id).text("不排课");
                        }else{
                            $("#"+course_id).text(value['title']);
                        }
                    })
                }
            });

        });
        //取消全选
        $(".select_all_cancel").on('click',function(){
            $(".my_li").children("a").css("color","#f0f0f0");
            $(".select_all").attr('select_flag','false');
            //清空表格的禁排信息
            $(".course").text('');
        });

        $(".grade_li").click(function(){
            var grade=$(this).children("a").attr("data-grade");
            $("#my_hidden_grade").val(grade);
        });

        //点击变换颜色
        $(".my_li").click(function(){
            $(".my_li").children("a").css("color","#f0f0f0");
            $(this).children("a").css("color","#f4816c");
            var grade=$("#my_hidden_grade").val();
            var classname=$(this).children("a").attr("data-class");
            $("#my_hidden").val(classname);
            //清空表格的禁排信息
            $(".course").text('');
            $.ajax({
                url: "<?=$this->baseurl?>&m=get_forbid_class_message",   //后台处理程序
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{grade:grade,classname:classname},  //要传递的数据
                success:function(data){
                    $.each(data,function(key,value){
                        var course_id=value['week']+value['section'];
                        if(value['title']==null){
                            $("#"+course_id).text("不排课");
                        }else{
                            $("#"+course_id).text(value['title']);
                        }
                        /*alert(value['week']);
                        alert(value['section']);
                        alert(value['title']);*/
                    })
                }
            });
            //alert($("#my_hidden").val());
        })

        //点击表格，不排课或者取消 异步插入数据库
        $(".course").click(function(){
            var select_flag=$('.select_all').attr('select_flag');
            var grade=$("#my_hidden_grade").val();
            var label=$("#my_hidden_label").val();
            var week=$(this).attr("data-week");
            var section=$(this).attr("data-section");
            var message=$(this).text();
            if(message=='') { //如果为空，则添加
                if(label!=""){
                    $(this).text(label);
                }else{
                    $(this).text("不排课");
                }
            }else {
                $(this).text('');
            }
            if(select_flag=='true'){
                alert("这里");
                $.ajax({
                    url: "<?=$this->baseurl?>&m=insert_forbid_class_all",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{grade:grade,week:week,section:section,message:message,label:label},  //要传递的数据
                    success:function(data){
                        //alert(data);
                        $.each(data,function(key,value){
                            //alert(value);
                        })
                    }
                });
            }else{
                alert("okok");
                var classname=$("#my_hidden").val();
                /*alert(grade);
                 alert(classname);
                 alert(label);
                 alert(week);
                 alert(section);
                 alert(message);*/
                $.ajax({
                    url: "<?=$this->baseurl?>&m=insert_forbid_class",   //后台处理程序
                    type: "post",         //数据发送方式
                    //dataType:"json",    //接受数据格式
                    data:{grade:grade,classname:classname,week:week,section:section,message:message,label:label},  //要传递的数据
                    success:function(data){
                        //alert(data);
                    }
                });
            }

        });

        $("#category").change(function() {
            var forbid_name = $("#category").find("option:selected").val();
            if(forbid_name=='班级不排课时间'){
                location.href="<?=$this->baseurl?>&m=rule_set";
            }else if(forbid_name=='课程不排课时间'){
                location.href="<?=$this->baseurl?>&m=forbid_course";
            }else{
                location.href="<?=$this->baseurl?>&m=forbid_teacher";
            }
        })

        $(".menu_a2").click(function(){
            location.href="<?=$this->baseurl?>&m=firstly";
        })

        $(".middle_label_add").click(function(){
            dialog = dialog_url("<?=$this->baseurl?>&m=label_add","添加标签",350,250);
        })

        $(".middle_label_edit").click(function(){
            dialog = dialog_url("<?=$this->baseurl?>&m=label_edit","编辑标签",350,250);
        })
        //选中哪个标签，哪个标签的背景颜色将改变，同时把选中的标签的值存放到隐藏表单中
        $("#show").on('click','input',function(){
            $(".middle_label_input").css('background','');
            var check=$(this).attr('data-check');
            var label=$(this).val();
            if(check=="false"){
                $(this).css('background','#57BAF5');
                $("#my_hidden_label").val(label);
                $(".middle_label_input").attr('data-check','false');
                $(this).attr("data-check","true");
            }else{
                $(this).css('background','');
                $("#my_hidden_label").val('');
                $(this).attr("data-check","false");
            }
        })
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
                <option value="课程不排课时间" <?= $forbid_name=="课程不排课时间"? 'selected="selected"':'';?>>课程不排课时间</option>
                <option value="教师不排课时间" >教师不排课时间</option>
            </select>
            <div style="margin-top: 5px;">
                <tr>
                    <td><input class="select_all" select_flag="false" type="button" value="全选" data-check="false"/></td>
                    <td><input class="select_all_cancel" type="button" value="取消全选" data-check="false"/></td>
                </tr>
            </div>
            <div id="middle_class">
                <div class="content">
                    <div id="jquery-accordion-menu" class="jquery-accordion-menu red">
                        <!--<div class="jquery-accordion-menu-header" id="form"></div>-->
                        <input type="hidden" id="my_hidden_grade" value=""/>
                        <input type="hidden" id="my_hidden" value=""/>
                        <input type="hidden" id="my_hidden_label" value=""/>
                        <ul id="demo-list" class="my_aaa">
                            <?php foreach($grade as $grade_key=>$grade_value):?>
                            <li class="grade_li"><a href="javascript:void(0)" data-grade="<?= $grade_value['grade']?>"><?= $grade_value['grade']?></a>
                                <ul class="submenu">
                                    <?php foreach($classname[$grade_key] as $classname_key=>$classname_value): ?>
                                    <li class="my_li"><a href="javascript:void(0)" data-class="<?= $classname[$grade_key][$classname_key]?>" ><?= $classname_value;?></a></li>
                                    <?php endforeach;?>
                                </ul>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="middle_label">
            <tr>
                <td><input class="middle_label_add" type="button" value="添加标签" data-check="false"/></td>
                <td><input class="middle_label_edit" type="button" value="编辑标签" data-check="false"/></td>
                <span id="show">
                    <?php foreach($label_list as $key=>$value):?>
                        <input class="middle_label_input" type="button" data-check="false" value="<?= $value['label_name']?>"/>
                    <?php endforeach?>
                </span>
            </tr>
        </div>
        <div id="middle_table">
            <div>
            <table id="middle_timetable" border="1px" cellspacing="0" >
                <tr>
                    <td style="width:59px;height:40px;background-color: #0066FF "></td>
                    <?php foreach($weeks as $week_key=>$week):?>
                    <td class="week"><?= $week;?></td>
                    <?php endforeach;?>
                </tr>
                <?php foreach($sections as $section_key=>$sction):?>
                    <tr>
                        <td class="section"><?=$section_key?></td>
                        <?php foreach($weeks as $week_key=>$week):?>
                            <td style="cursor: pointer;font-family: '微软雅黑', Arial, Helvetica, sans-serif;" id="<?=$week_key.$section_key?>" class="course" data-week="<?= $week_key?>" data-section="<?= $section_key?>"></td>
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