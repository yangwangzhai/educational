<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css"	href="static/timetable/css/statistic.css" />
    <script src="static/js/jquery-1.11.2.min.js" type="text/javascript"></script>
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
        $(".download").on("click",function(){
            location.href="index.php?d=admin&c=Test_score&m=out_quality_analysis";
        });
        $(".download2").on("click",function(){
            location.href="index.php?d=admin&c=Test_score&m=out_quality_analysis2";
        });
        $('#chkShow').on('click',function(){
            if($('#chkShow').is(':checked')) {
                //获取选中的科目
                var subject=$('#sel_subject').val();
                location.href="index.php?d=admin&c=Test_score&m=statistic_analysis&check=true&subject="+subject;
            }
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
        <div class="soft_con1" style="background:url(static/timetable/images/line_select_004.gif);"></div>
    </div>
    <div class="row">
        <form method="post" action="<?=$this->baseurl?>&m=statistic_analysis">
            <input type="hidden" value="<?= $id;?>" name="id"/>
            <ul class="list-inline form-group-sm">
                <li>
                    <select class="form-control" id="sel_subject"  name="subject_selected" style="width:120px;">
                        <?php foreach($subject_unique as $subject_unique_value): ?>
                            <option value="<?=trim($subject_unique_value);?>" <?php if(trim($subject_selected)==trim($subject_unique_value)){echo "selected=selected";}?>><?=$subject_unique_value;?></option>
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
        <div style="float: left;"><input type="checkbox" id="chkShow" />显示人数</div>
        <div id="down_img" style="float: left;margin-left: 550px;"><img src="static/timetable/images/down.png" style="height:18px;width:18px;margin-bottom: 2px;"/></div>
        <!--<div style="float: left; "><a href="javascript:void(0)" class="download">导出综合分析</a></div>-->
        <div style="float: left;margin-left: 10px; "><a href="javascript:void(0)" class="download2">导出综合分析-2</a></div>
    </div>
    <hr size="1" style="clear: both;width: 82%;margin-left: 20px;" >
    <div style="width: 82%;margin-left: 20px;">
        <h4 style="color: #00CC00;"></h4>
        <table class="table" border="1" style="text-align:center">
            <thead style="background-color:#37ABF1">
            <tr>
                <td style="width:172px;text-align:center;vertical-align: middle;"rowspan="2">班别</td>
                <td style="width:172px;text-align:center;" colspan="5"><?=trim($subject_selected);?></td>
            </tr>
            <tr>
                <td style="width:172px;text-align:center;">0.9优秀率</td>
                <td style="width:172px;text-align:center;">0.8优秀率</td>
                <td style="width:172px;text-align:center;">及格率</td>
                <td style="width:172px;text-align:center;">平均分</td>
                <td style="width:172px;text-align:center;">任课老师</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $key=>$value):?>
                <tr>
                    <td style="background-color: #37ABF1;"><?=$value['classname'];?></td>
                    <td><?=$value['excellent_rate1']."%";?></td>
                    <td><?=$value['excellent_rate2']."%";?></td>
                    <td><?=$value['pass_rate']."%";?></td>
                    <td><?=$value['avg_score'];?></td>
                    <td></td>
                </tr>
            <?php endforeach;?>
            <tr>
                <td style="background-color: #37ABF1;">年级</td>
                <td><?=$grade['excellent_rate1_grade']."%";?></td>
                <td><?=$grade['excellent_rate2_grade']."%";?></td>
                <td><?=$grade['pass_rate_grade']."%";?></td>
                <td><?=$grade['avg_score_grade'];?></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>







</div>
</body>
</html>
