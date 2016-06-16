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
        <div class="soft_con1" style="background:url(static/timetable/images/line_select_001.gif);"></div>
    </div>
    <div class="row">
        <form method="post" action="<?=$this->baseurl?>&m=statistic_subject">
            <input type="hidden" value="<?= $id;?>" name="id"/>
            <ul class="list-inline form-group-sm">
                <li>
                    <select class="form-control" id="selGrade" name="classname_selected" onchange="selectGrade()" style="width:120px;">
                        <?php foreach($classname_unique as $classname_unique_value): ?>
                            <option value="<?= $classname_unique_value;?>" <?php if($classname_selected==$classname_unique_value){echo "selected=selected";}?>><?= $classname_unique_value;?></option>
                        <?php endforeach;?>
                    </select>
                </li>
                <li>
                    <select class="form-control"  name="subject_selected" onchange="selectGrade()" style="width:120px;">
                        <?php foreach($subject_unique as $subject_unique_value): ?>
                            <option value="<?= $subject_unique_value;?>" <?php if($subject_selected==$subject_unique_value){echo "selected=selected";}?>><?= $subject_unique_value;?></option>
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
        <div style="float: left; "><a href="javascript:void(0)" class="download" onclick="down()">导出科目名次</a></div>
    </div>
    <hr size="1" style="clear: both;width: 82%;margin-left: 20px;" >
    <div style="width: 82%;margin-left: 20px;">
        <h4 style="color: #00CC00;"></h4>
        <table class="table" border="1" style="text-align:center">
            <thead style="background-color:#37ABF1">
            <tr>
                <th style="width:172px;text-align:center;">班别</th>
                <th style="width:172px;text-align:center;">名次</th>
                <th style="width:172px;text-align:center;">姓名</th>
                <th style="width:172px;text-align:center;"><?= $subject_selected?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $key=>$value):?>
                <tr>
                    <td style="background-color: #37ABF1;"><?= $classname_selected?></td>
                    <td <?php /*if($value['score']>=90){echo "style='background-color:#FF8C69;'";}elseif($value['score']<72){echo "style='background-color:#FFFF00;'";}*/?>><?= $key+1;?></td>
                    <td <?php /*if($value['score']>=90){echo "style='background-color:#FF8C69;'";}elseif($value['score']<72){echo "style='background-color:#FFFF00;'";}*/?>><?= $value['student']?></td>
                    <td <?php /*if($value['score']>=90){echo "style='background-color:#FF8C69;'";}elseif($value['score']<72){echo "style='background-color:#FFFF00;'";}*/?>>
                        <?= $value['score']?>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>







</div>
</body>
</html>
