<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/statistic.css" />
    <script src="static/js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="static/js/echarts.common.min.js"></script>
    <script src="static/js/echarts-2.2.7/src/esl.js?version=1.1.6" type="text/javascript"></script>
    <script src="static/js/echarts-2.2.7/src/MyEcharts.js?version=1.1.6" type="text/javascript"></script>
    <script src="static/js/echarts-2.2.7/src/WapCharts.js?version=1.1.6" type="text/javascript"></script>
</head>

<script type="text/javascript">
    $(document).ready(function(){
        $("#pic_fun_base").on("click",function(){
            location.href="index.php?d=admin&c=Test_score&m=statistic_subject";
        });
        $("#pic_fun_rule").on("click",function(){
            location.href="index.php?d=admin&c=Test_score&m=statistic_class";
        });
        $("#pic_fun_paike").on("click",function(){
            location.href="index.php?d=admin&c=Test_score&m=statistic_grade";
        });
        $("#pic_fun_check").on("click",function(){
            location.href="index.php?d=admin&c=Test_score&m=statistic_analysis";
        });
        $("#pic_fun_move").on("click",function(){
            location.href="index.php?d=admin&c=Test_score&m=statistic_multiple";
        });

        $("#my_course_plan").on("click",function(){
            location.href="index.php?d=admin&c=Test_score&m=statistic_multiple";
        });

        $("#my_teacher_plan").on("click",function(){
            location.href="index.php?d=admin&c=Test_score&m=statistic_multiple_sub";
        });

        $("#statistic_multiple_total").on("click",function(){
            location.href="index.php?d=admin&c=Test_score&m=statistic_multiple_total";
        });

        $("#selclass").on("change",function(){
            var classname=$("#selclass").val();
            $.ajax({
                url: "index.php?d=admin&c=Test_score&m=statistic_multiple_get_class",   //后台处理程序
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{classname:classname},  //要传递的数据
                success:function(data){
                    $("#selstudent").children().remove();
                    $("#selstudent").append("<option value=未选择>未选择</option>");
                    $.each(data,function(key,val){
                        $("#selstudent").append("<option value="+val['student']+">"+val['student']+"</option>");
                    });
                },
                error:function(XMLHttpRequest, textStatus, errorThrown)
                {
                    //alert(errorThrown);
                }
            });
        });

    })
</script>
<body>
<div style=" margin:20px; font-size:13px;">
    <div class="soft_function">
        <div class="soft_con_icon">
            <ul>
                <li id="pic_fun_base"><a id="pic_fun_adm" href="javascript:void(0);"><img src="static/timetable/images/teacher_statistic01.png" /><p style="color:#008dd9">科目名次</p></a></li>
                <li id="pic_fun_rule"><a id="pic_fun_crm" href="javascript:void(0);"><img  src="static/timetable/images/teacher_statistic02.png" /><p>班级名次</p></a></li>
                <li id="pic_fun_paike"><a id="pic_fun_project" href="javascript:void(0);"><img  src="static/timetable/images/teacher_statistic03.png" /><p>年级名次</p></a></li>
                <li id="pic_fun_check"><a id="pic_fun_k" href="javascript:void(0);"><img  src="static/timetable/images/teacher_statistic04.png" /><p>综合分析</p></a></li>
                <li id="pic_fun_move"><a id="pic_fun_mobile" href="javascript:void(0);"><img  src="static/timetable/images/teacher_statistic05.png" /><p>统计</p></a></li>
            </ul>
        </div>
        <div class="soft_con1" style="background:url(static/timetable/images/line_select_005.gif);"></div>
        <div class="soft_con">
            <div id="xzgl" class="soft_con2">
                <div class="function1" id="my_course_plan" style="<?php if($flag=="personal"){echo "border-color: #1996E6;";}?>">
                    <img src="static/timetable/images/pic_fun_adm_detailed_001.gif"/>
                    <p class="p1" style="<?php if($flag=="personal"){echo "background-color: #1996E6;font-size: medium;font-weight: bolder;";}?>">个人统计</p>
                </div>
                <div class="function1" id="my_teacher_plan" style="<?php if($flag=="teacher"){echo "border-color: #1996E6;";}?>">
                    <img src="static/timetable/images/pic_fun_adm_detailed_002.gif"/>
                    <p class="p1" style="<?php if($flag=="teacher"){echo "background-color: #1996E6;font-size: medium;font-weight: bolder;";}?>">班级统计</p>
                </div>
                <div class="function1" id="statistic_multiple_total" style="<?php if($flag=="teacher"){echo "border-color: #1996E6;";}?>">
                    <img src="static/timetable/images/pic_fun_adm_detailed_002.gif"/>
                    <p class="p1" style="<?php if($flag=="teacher"){echo "background-color: #1996E6;font-size: medium;font-weight: bolder;";}?>">总分统计</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form method="post" action="<?=$this->baseurl?>&m=statistic_multiple">
            <input type="hidden" value="<?= $id;?>" name="id"/>
            <ul class="list-inline form-group-sm">
                <li>
                    <select class="form-control" id="selclass" name="classname_selected"  style="width:120px;">
                        <?php foreach($classname_unique as $classname_unique_value): ?>
                            <option value="<?= $classname_unique_value;?>" <?php if($classname_selected==$classname_unique_value){echo "selected=selected";}?>><?= $classname_unique_value;?></option>
                        <?php endforeach;?>
                    </select>
                </li>
                <li>
                    <select class="form-control" id="selstudent"  name="student_selected" style="width:120px;">
                        <?php foreach($student_arr as $student_arr_value): ?>
                            <option value="<?=trim($student_arr_value['student']);?>" <?php if(trim($student_selected)==trim($student_arr_value['student'])){echo "selected=selected";}?>><?=$student_arr_value['student'];?></option>
                        <?php endforeach;?>
                    </select>
                </li>
                <li>
                    <input class="btn btn-primary btn-sm" type="submit" value="查询" >
                </li>
            </ul>
        </form>
    </div>
    <hr size="1" style="clear: both;width: 82%;margin-left: 20px;" >
    <div style="width: 82%;margin-left: 20px;">
        <div style="float: left;">
            <h4 style="color: #00CC00;margin-left: 150px;">第一次月考个人科目对比</h4>
            <div id="main1" style="width: 500px;height:400px;border-right: dashed;float: left;"></div>
        </div>
        <div>
            <h4 style="color: #00CC00;margin-left: 150px;">个人历次各科变化图</h4>
            <div id="main2" style="width: 100%;height:400px;"></div>
        </div>

    </div>
    <hr size="1" style="clear: both;width: 82%;margin-left: 20px;" >
    <div style="width: 82%;margin-left: 20px;">
        <div style="float: left;">
            <h4 style="color: #00CC00;margin-left: 150px;">个人历次考试总分排名变化图</h4>
            <div id="main3" style="width: 500px;height:400px;border-right: dashed;float: left;"></div>
        </div>
        <div>
            <h4 style="color: #00CC00;margin-left: 150px;">个人历次各科变化图</h4>
            <div id="main4" style="width: 100%;height:400px;"></div>
        </div>

    </div>
</div>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main1'));
    // 指定图表的配置项和数据
    var option = {
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data:['个人得分','班级均分','年级均分']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {
                    title:"个人"
                }
            }
        },
        xAxis : [
            {
                type : 'category',
                data : [<?= $subject;?>]
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'个人得分',
                type:'bar',
                barWidth : 10,
                data:[<?= $score;?>]
            },

            {
                name:'班级均分',
                type:'bar',
                barWidth : 10,
                data:[<?= $avg_score;?>]
            },
            {
                name:'年级均分',
                type:'bar',
                barWidth : 10,
                data:[<?= $data_grade;?>]
            },

        ]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main2'));
    // 指定图表的配置项和数据
    var option = {
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:[<?= $subject;?>]
        },
        toolbox: {
            feature: {
                saveAsImage: {
                    title:"历次各科分数"
                }
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                data : [<?= $test_name;?>]
            }
        ],
        yAxis : [
            {
                type : 'value'

            }
        ],
        series : [
            <?php foreach($score_each as $score_each_value):?>
            {
                name:'<?=$score_each_value['subject'];?>',
                type:'line',
                data:[<?=$score_each_value['score'];?>]

            },
            <?php endforeach;?>
        ]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
    window.onresize = myChart.resize;
</script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main3'));
    // 指定图表的配置项和数据
    var option = {
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['年级排名','班级排名']
        },
        toolbox: {
            feature: {
                saveAsImage: {
                    title:"历次总分排名"
                }
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                data : [<?= $test_name;?>]
            }
        ],
        yAxis : [
            {
                type : 'value'

            }
        ],
        series : [
            <?php foreach($rank_each as $rank_each_value):?>
            {
                name:'<?=$rank_each_value['rank_type'];?>',
                type:'line',
                data:[<?=$rank_each_value['rank'];?>]
            },
            <?php endforeach;?>
        ]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
    window.onresize = myChart.resize;
</script>
</body>
</html>
