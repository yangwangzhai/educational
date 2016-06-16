<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>中小学排课系统</title>
    <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/timetable_move.css" />
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/style.css" />
    <script src="static/timetable/js/jquery-1.11.2.min.js" type="text/javascript"></script>
</head>
<script type="text/javascript">
    $(document).ready(function(){
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

        var flag=false;
        var temp_course;
        var temp_week;
        var temp_section;
        var temp_teacher;
        //鼠标滑过某个科目，在右侧教师表显示该科目对应教师的课表
        $(".point_course").on("mouseover",function(){
            var teacher=$(this).attr("data-teacher");
            if(teacher==''){

            }else{
                if(!flag){  //未点击
                    //alert("flag="+flag);
                    $(".point_course").css({"background":""});
                    $(this).css({"background":"#999999"});
                    var teacher=$(this).attr("data-teacher");
                    $("#one_teacher_title").text(teacher+"-课程表");
                    //异步获取该教师的课表
                    $.ajax({
                        url: "index.php?d=timetable&c=timetable&m=get_teacher_timetable",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{teacher:teacher},  //要传递的数据
                        success:function(data){
                            $(".one_teacher_table").empty();
                            $.each(data,function(key,value){
                                var id="one"+value['week']+value['section'];
                                $("#"+id).text(value['grade']+value['classname']);
                            });
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }else{  //点击过
                    //alert("flag="+flag);
                    $(".two_teacher_table").empty();
                    $(".point_course").css({"background":""});
                    $(this).css({"background":"#999999"});
                    var teacher=$(this).attr("data-teacher");
                    $("#two_teacher_title").text(teacher+"-课程表");

                    //异步获取该教师的课表
                    $.ajax({
                        url: "index.php?d=timetable&c=timetable&m=get_teacher_timetable",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{teacher:teacher},  //要传递的数据
                        success:function(data){
                            $.each(data,function(key,value){
                                var id="two"+value['week']+value['section'];
                                $("#"+id).text(value['grade']+value['classname']);
                            });
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }
            }

        });

        //鼠标点击某个科目，在课程表上显示可以调课的位置
        $(".point_course").on("click",function(){
            if($(this).hasClass("good")){
                //互换位置
                var before_course=temp_course;
                var before_week=temp_week;
                var before_section=temp_section;
                var before_teacher=temp_teacher;
                var next_grade=$(this).attr('data-grade');
                var next_classname=$(this).attr('data-classname');
                var next_week=$(this).attr('data-week');
                var next_section=$(this).attr('data-section');
                var next_course=$(this).attr('data-course');
                var next_teacher=$(this).attr('data-teacher');

                var before_id="ct"+before_week+before_section;
                $("#"+before_id).text(next_course);
                $("#"+before_id).attr("data-teacher",next_teacher);
                $("#"+before_id).attr("data-course",next_course);
                $(this).text(before_course);
                $(this).attr("data-teacher",before_teacher);
                $(this).attr("data-course",before_course);

                $.ajax({
                    url: "index.php?d=timetable&c=timetable&m=change_adjust_position",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{next_grade:next_grade,next_classname:next_classname,next_week:next_week,next_section:next_section,next_course:next_course,next_teacher:next_teacher,
                        before_course:before_course,before_week:before_week,before_section:before_section,before_teacher:before_teacher},  //要传递的数据
                    success:function(data){
                        if(data==true){
                            //对换成功
                            $(".point_course").removeClass("point_course_bg point_course_bg2 point_course_bg4 point_course_bg5 good arrange access" );
                            $("#"+before_id).addClass("point_course_bg3");
                            $("#ct"+next_week+next_section).addClass("point_course_bg3");
                            flag=false;
                            $(".two_teacher_table").empty();
                        }else{
                            //alert("对换失败："+data);
                        }

                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        //alert(errorThrown);
                    }
                });

            }else if($(this).hasClass("arrange")){
                //先对换可安排的
                var before_course=temp_course;
                var before_week=temp_week;
                var before_section=temp_section;
                var before_teacher=temp_teacher;
                var next_grade=$(this).attr('data-grade');
                var next_classname=$(this).attr('data-classname');
                var next_week=$(this).attr('data-week');
                var next_section=$(this).attr('data-section');
                var next_course=$(this).attr('data-course');
                var next_teacher=$(this).attr('data-teacher');

                var before_id="ct"+before_week+before_section;
                $("#"+before_id).text('');
                $("#"+before_id).attr("data-teacher",'');
                $("#"+before_id).attr("data-course",'');
                $(this).text(before_course);
                $(this).attr("data-teacher",before_teacher);
                $(this).attr("data-course",before_course);
                $('.temporary').text(next_course);
                $('.temporary').attr('data-grade',next_grade);
                $('.temporary').attr('data-classname',next_classname);
                $('.temporary').attr('data-course',next_course);
                $('.temporary').attr('data-teacher',next_teacher);

                $.ajax({
                    url: "index.php?d=timetable&c=timetable&m=arrange_adjust_position",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{next_grade:next_grade,next_classname:next_classname,next_week:next_week,next_section:next_section,next_course:next_course,next_teacher:next_teacher,
                        before_course:before_course,before_week:before_week,before_section:before_section,before_teacher:before_teacher},  //要传递的数据
                    success:function(data){
                        if(data==true){
                            //安排成功
                            $(".point_course").removeClass("point_course_bg point_course_bg2 point_course_bg4 point_course_bg5 good arrange access" );
                            $("#"+before_id).addClass("point_course_bg3");
                            $("#ct"+next_week+next_section).addClass("point_course_bg3");
                            flag=false;
                            $(".two_teacher_table").empty();
                        }else{
                            //alert("对换失败："+data);
                        }

                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        //alert(errorThrown);
                    }
                });

            }else if($(this).hasClass("access")){
                //从暂存区对换位置
                var before_course=temp_course;
                var before_teacher=temp_teacher;
                var next_grade=$(this).attr('data-grade');
                var next_classname=$(this).attr('data-classname');
                var next_week=$(this).attr('data-week');
                var next_section=$(this).attr('data-section');
                var next_course=$(this).attr('data-course');
                var next_teacher=$(this).attr('data-teacher');

                $(this).text(before_course);
                $(this).attr("data-teacher",before_teacher);
                $(this).attr("data-course",before_course);
                $('.temporary').text(next_course);
                $('.temporary').attr('data-grade',next_grade);
                $('.temporary').attr('data-classname',next_classname);
                $('.temporary').attr('data-course',next_course);
                $('.temporary').attr('data-teacher',next_teacher);

                $.ajax({
                    url: "index.php?d=timetable&c=timetable&m=access_adjust_position",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{next_grade:next_grade,next_classname:next_classname,next_week:next_week,next_section:next_section,next_course:next_course,next_teacher:next_teacher,
                        before_course:before_course,before_teacher:before_teacher},  //要传递的数据
                    success:function(data){
                        if(data==true){
                            //安排成功
                            $(".point_course").removeClass("point_course_bg point_course_bg2 point_course_bg4 point_course_bg5 good arrange access" );
                            $("#"+before_id).addClass("point_course_bg3");
                            $("#ct"+next_week+next_section).addClass("point_course_bg3");
                            flag=false;
                            $(".two_teacher_table").empty();
                        }else{
                            //alert("对换失败："+data);
                        }

                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        //alert(errorThrown);
                    }
                });
            }else if($(this).hasClass("temporary")){    //点击暂存区课程时，去后台获取可与之直接对调的所有课程
                flag=true;
                $(".point_course").removeClass("point_course_bg point_course_bg2 point_course_bg3 point_course_bg4 point_course_bg5");
                $(this).css({"background":""});
                $(this).addClass("point_course_bg4");
                var data_grade=$(this).attr('data-grade');
                var data_classname=$(this).attr('data-classname');
                var data_course=$(this).attr('data-course');
                var data_teacher=$(this).attr("data-teacher");
                temp_course=data_course;
                temp_teacher=data_teacher;
                //异步获取可调课的位置
                $.ajax({
                    url: "index.php?d=timetable&c=timetable&m=get_temporary_adjust_position",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{grade:data_grade,classname:data_classname,course:data_course},  //要传递的数据
                    success:function(data){
                        if(data==0){
                            //alert(data);
                        }else{
                            $('.point_course').removeClass("good");
                            //可直接对调的课程
                            $.each(data,function(key,value){
                                /*alert(value['week']);
                                 alert(value['section']);*/
                                var ct_id="ct"+value['week']+value['section'];
                                //alert(ct_id);
                                $("#"+ct_id).addClass("point_course_bg2");
                                $("#"+ct_id).addClass("access");
                            });
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        //alert(errorThrown);
                    }
                });

            }else{
                //先判断所点击的课程是否有老师授课，没有则不是正规的课程，是一些班会、自习、活动等标签
                var data_teacher=$(this).attr("data-teacher");
                if(data_teacher==''){

                }else{
                    flag=true;
                    $(".point_course").removeClass("point_course_bg point_course_bg2 point_course_bg3 point_course_bg4 point_course_bg5 good arrange access");
                    $(this).css({"background":""});
                    $(this).addClass("point_course_bg4");
                    var data_grade=$(this).attr('data-grade');
                    var data_classname=$(this).attr('data-classname');
                    var data_week=$(this).attr('data-week');
                    var data_section=$(this).attr('data-section');
                    var data_course=$(this).attr('data-course');

                    temp_course=data_course;
                    temp_week=data_week;
                    temp_section=data_section;
                    temp_teacher=data_teacher;
                    //异步获取可调课的位置
                    $.ajax({
                        url: "index.php?d=timetable&c=timetable&m=get_adjust_position",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{grade:data_grade,classname:data_classname,week:data_week,section:data_section,course:data_course},  //要传递的数据
                        success:function(data){
                            if(data==0){
                                //alert(data);
                            }else{
                                $('.point_course').removeClass("good");
                                //可直接对调的课程
                                $.each(data[0],function(key,value){
                                    /*alert(value['week']);
                                     alert(value['section']);*/
                                    var ct_id="ct"+value['week']+value['section'];
                                    //alert(ct_id);
                                    $("#"+ct_id).addClass("point_course_bg2");
                                    $("#"+ct_id).addClass("good");
                                });
                                //可安排，但不可直接对调
                                $('.point_course').removeClass("arrange");
                                $.each(data[1],function(key,value){
                                    /*alert(value['week']);
                                     alert(value['section']);*/
                                    var ct_id_half="ct"+value['week']+value['section'];
                                    /*alert(ct_id_half);*/
                                    $("#"+ct_id_half).addClass("point_course_bg5");
                                    $("#"+ct_id_half).addClass("arrange");
                                });
                            }
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });

                    $("#one_teacher_title").text(data_teacher+"-课程表");
                    //alert(teacher);
                    //异步获取该教师的课表
                    $.ajax({
                        url: "index.php?d=timetable&c=timetable&m=get_teacher_timetable",   //后台处理程序
                        type: "post",         //数据发送方式
                        dataType:"json",    //接受数据格式
                        data:{teacher:data_teacher},  //要传递的数据
                        success:function(data){
                            $(".one_teacher_table").empty();
                            $.each(data,function(key,value){
                                var id="one"+value['week']+value['section'];
                                $("#"+id).text(value['grade']+value['classname']);
                            });
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            //alert(errorThrown);
                        }
                    });
                }

            }


        });

        //根据年级，异步获取班级
        $("#selGrade").on("change",function(){
            var grade=$("#selGrade").val();
            $.ajax({
                url: "index.php?d=timetable&c=timetable&m=get_class_message",   //后台处理程序
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{grade:grade},  //要传递的数据
                success:function(data){
                    $("#selclass").children().remove();
                    $("#selclass").append("<option value=未选择>未选择</option>");
                    $.each(data,function(key,val){
                        $("#selclass").append("<option value="+val+">"+val+"</option>");
                    });
                },
                error:function(XMLHttpRequest, textStatus, errorThrown)
                {
                    //alert(errorThrown);
                }
            });
        });

        $("#selclass").on("change",function(){
            var grade=$("#selGrade option:selected").val();
            var classname=$("#selclass option:selected").val();
            $.ajax({
                url: "index.php?d=timetable&c=timetable&m=get_course_message",
                type: "post",
                dataType: "json",
                data:{grade:grade,classname:classname},
                success:function(data){
                    $(".point_course").empty();
                    $(".one_teacher_table").empty();
                    $(".two_teacher_table").empty();
                    flag=false;
                    $(".point_course").removeClass("point_course_bg point_course_bg2 point_course_bg3 point_course_bg4 point_course_bg5 good arrange access");
                    $.each(data[0],function(key,value){
                        var id="ct"+value['week']+value['section'];
                        $("#"+id).text(value['title']);
                        $("#"+id).attr("data-grade",value['grade']);
                        $("#"+id).attr("data-classname",value['classname']);
                        $("#"+id).attr("data-week",value['week']);
                        $("#"+id).attr("data-section",value['section']);
                        $("#"+id).attr("data-course",value['title']);
                        $("#"+id).attr("data-teacher",value['teacher_truename']);
                        $("#course_table_title").text(value['grade']+"("+value['classname']+")");
                    });
                    $('.temporary').text(data[1][0]['course']);
                    $('.temporary').attr('data-grade',grade);
                    $('.temporary').attr('data-classname',classname);
                    $('.temporary').attr('data-course',data[1][0]['course']);
                    $('.temporary').attr('data-teacher',data[1][0]['teacher']);
                }
            })
        });

        $('#cancel_operate').on('click',function(){
            $(".point_course").removeClass("point_course_bg point_course_bg2 point_course_bg3 point_course_bg4 point_course_bg5 good arrange access");
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
        <div class="soft_con1" style="background:url(static/timetable/images/line_select_005.gif);"></div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <ul class="list-inline form-group-sm">
            <li>
                <select class="form-control" id="selGrade" name="grade"  style="width:120px;">
                    <?php foreach($grades as $grades_value): ?>
                        <option value="<?= $grades_value;?>" <?php if($grade==$grades_value){echo "selected=selected";}?>><?= $grades_value;?></option>
                    <?php endforeach;?>
                </select>
            </li>
            <li>
                <select class="form-control" id="selclass"  name="classname" style="width:120px;">
                    <?php foreach($classnames as $classnames_value): ?>
                        <option value="<?= $classnames_value;?>" <?php if($classname==$classnames_value){echo "selected=selected";}?>><?= $classnames_value;?></option>
                    <?php endforeach;?>
                </select>
            </li>
        </ul>
    </div>
    <hr size="1" style="clear: both;width: 93%;margin-left: 20px;" >
    <?php foreach($list as $class): ?>
        <div style="width: 51%;margin-left: 20px;float: left;">
            <h4 style="color: #00CC00;" id="course_table_title"><?=$grade."(".$classname.")"?></h4>
            <table border="1" style="text-align:center" >
                <thead style="background-color:#37ABF1">
                <tr>
                    <th><input type="button" value="取消操作" id="cancel_operate" style="width: 85px;height: 35px;cursor: pointer;"></th>
                    <?php foreach($weeks as $week_key=>$week):?>
                        <th style="width:80px;"><?= $week;?></th>
                    <?php endforeach;?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($sections as $section_key=>$sction):?>
                    <tr>
                        <td style="background-color: #37ABF1"><?=$section_key?></td>
                        <?php foreach($weeks as $week_key=>$week):?>
                            <td style="cursor: pointer;" class="point_course"
                                id="<?='ct'.$week_key.$section_key?>"
                                data-grade="<?=$class['grade']?>"
                                data-classname="<?=$class['classname']?>"
                                data-week="<?=$week_key?>"
                                data-section="<?=$section_key?>"
                                data-course="<?=$class['table'][$section_key][$week_key]['title']?>"
                                data-teacher="<?=$class['table'][$section_key][$week_key]['teacher_truename']?>"
                            >
                                <?=$class['table'][$section_key][$week_key]['title']?>
                            </td>
                        <?php endforeach;?>
                    </tr>
                <?php endforeach;?>
                <!--<tr>
                    <td rowspan="2" style="background-color: #37ABF1">暂存区</td>
                    <?php /*foreach($weeks as $week_key=>$week):*/?>
                        <td></td>
                    <?php /*endforeach;*/?>
                </tr>
                <tr>
                    <?php /*foreach($weeks as $week_key=>$week):*/?>
                        <td></td>
                    <?php /*endforeach;*/?>
                </tr>-->
                <tr>
                    <td style="background-color: #37ABF1">暂存区</td>
                    <td class="temporary point_course" style="cursor: pointer;"
                        data-grade="<?=$grade?>"
                        data-classname="<?=$classname?>"
                        data-course="<?=$temporary[0]['course']?>"
                        data-teacher="<?=$temporary[0]['teacher']?>"
                        >
                        <?=$temporary[0]['course']?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td rowspan="2" style="background-color: #37ABF1">颜色说明</td>
                    <td style="background: #FFC1C1;"></td>
                    <td style="background: #54FF9F;"></td>
                    <td style="background: #aa7700"></td>
                    <td style="background: #D8BFD8;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>选中的课程</td>
                    <td>可对调课程</td>
                    <td>可安排，不可直接对调</td>
                    <td>对调后课程</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    <?php endforeach;?>
        <div class="point_teacher">
            <h5 style="color: #00CC00;" id="one_teacher_title"></h5>
            <table border="1" style="text-align:center">
                <thead style="background-color:#37ABF1">
                <tr>
                    <td style="width:25px;height:25px;">&nbsp;</td>
                    <?php foreach($weeks as $week_key=>$week):?>
                        <td style="width:80px;height: 25px;"><?= $week;?></td>
                    <?php endforeach;?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($sections as $section_key=>$sction):?>
                    <tr>
                        <td style="background-color: #37ABF1;width:25px;height: 25px;"><?=$section_key?></td>
                        <?php foreach($weeks as $week_key=>$week):?>
                            <td style="width:80px;height: 25px;" id="<?="one".$week_key.$section_key?>" class="one_teacher_table"></td>
                        <?php endforeach;?>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <div class="teacher">
            <h5 style="color: #00CC00;" id="two_teacher_title"></h5>
            <table border="1" style="text-align:center" >
                <thead style="background-color:#37ABF1">
                <tr>
                    <td style="width:25px;height: 25px;">&nbsp;</td>
                    <?php foreach($weeks as $week_key=>$week):?>
                        <td style="width:80px;height: 25px;"><?= $week;?></td>
                    <?php endforeach;?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($sections as $section_key=>$sction):?>
                    <tr>
                        <td style="background-color: #37ABF1;width:25px;height: 25px;"><?=$section_key?></td>
                        <?php foreach($weeks as $week_key=>$week):?>
                            <td style="width:80px;height: 25px;" id="<?="two".$week_key.$section_key?>" class="two_teacher_table"></td>
                        <?php endforeach;?>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>

</div>
</body>
</html>