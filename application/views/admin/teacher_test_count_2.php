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
            location.href="index.php?d=admin&c=Teacher&m=statistic";
        });
        $("#pic_fun_rule").on("click",function(){
            location.href="index.php?d=admin&c=Teacher&m=teacher_leave_count";
        });
        $("#pic_fun_paike").on("click",function(){
            location.href="index.php?d=admin&c=Teacher&m=teacher_test_count_1";
        });
        $("#pic_fun_check").on("click",function(){
            location.href="index.php?d=admin&c=Teacher&m=teacher_test_count_2";
        });
        $("#pic_fun_move").on("click",function(){
            location.href="index.php?d=admin&c=Teacher&m=teacher_attendance_count";
        });
    })
</script>

<body>
<div style=" margin:20px; font-size:13px;">
    <div class="soft_function">
        <div class="soft_con_icon">
            <ul>
                <li id="pic_fun_base"><a id="pic_fun_adm" href="javascript:void(0);"><img src="static/timetable/images/teacher_statistic01.png" /><p style="color:#008dd9">人事统计</p></a></li>
                <li id="pic_fun_rule"><a id="pic_fun_crm" href="javascript:void(0);"><img  src="static/timetable/images/teacher_statistic02.png" /><p>请假统计</p></a></li>
                <li id="pic_fun_paike"><a id="pic_fun_project" href="javascript:void(0);"><img  src="static/timetable/images/teacher_statistic03.png" /><p>主管测评</p></a></li>
                <li id="pic_fun_check"><a id="pic_fun_k" href="javascript:void(0);"><img  src="static/timetable/images/teacher_statistic04.png" /><p>学生测评</p></a></li>
                <li id="pic_fun_move"><a id="pic_fun_mobile" href="javascript:void(0);"><img  src="static/timetable/images/teacher_statistic05.png" /><p>考勤统计</p></a></li>
            </ul>
        </div>
        <div class="soft_con1" style="background:url(static/timetable/images/line_select_004.gif);"></div>
    </div>
    <div class="container-fluid">
        <table style="width:100%">
            <tbody><tr valign="top">
                <!--<td width="130px">

                    <a href="">教师属性分析</a> <br><br>

                    <a href="">入职率/离职率</a> <br>

                </td>-->

                <td>
                    <style>
                        .rpt td {
                            margin:5px; padding:5px; text-align:center
                        }
                    </style>
                    <table class="rpt" cellpadding="50px" cellspacing="5px">
                        <tbody><tr>
                            <td>

                                <div class="thumbnail">

                                    <b>员工性别比</b>
                                    <div id="gender" style="width:250px; height:250px; margin-left:50px; margin-top:50px;">
                                        <img src="static/admin_img/loading.gif" />
                                    </div>
                                </div>

                            </td>

                            <td>
                                <div class="thumbnail">

                                    <b>员工学历比</b>
                                    <div id="degrees" style="width:250px; height:250px; margin-left:50px; margin-top:50px;">
                                        <img src="static/admin_img/loading.gif" />
                                    </div>
                                </div>

                            </td>

                            <td>
                                <div class="thumbnail">

                                    <b>婚姻比</b>
                                    <div id="marry" style="width:250px; height:250px; margin-left:50px; margin-top:50px;">
                                        <img src="static/admin_img/loading.gif" />
                                    </div>

                                </div>
                            </td>

                        </tr>

                        <tr>
                            <td>

                                <div class="thumbnail">

                                    <b>各部门员工比率</b>
                                    <div id="dept" style="width:350px; height:250px;   margin-top:20px;">
                                        <img src="static/admin_img/loading.gif" />
                                    </div>

                                </div>
                            </td>
                            <td>
                                <div class="thumbnail">

                                    <b>员工工龄比</b>
                                    <div id="joinin" style="width:350px; height:250px;   margin-top:20px;">
                                        <img src="static/admin_img/loading.gif" />
                                    </div>
                                </div>

                            </td>
                            <td>

                                <div class="thumbnail">

                                    <b>生日比</b>

                                    <div id="birthday" style="width:350px; height:250px;   margin-top:20px;">
                                        <img src="static/admin_img/loading.gif" />
                                    </div>                                    </div>


                            </td>

                        </tr>
                        </tbody>
                    </table>

                    <script>
                        $(document).ready(function () {
                            //data:数据格式：{name：xxx,value:xxx}...
                            $.ajax({
                                url: "<?=$this->baseurl?>&m=ajax_statistic",
                                data: { types:"gender" },
                                cache: false,
                                type: "post",
                                async: false,
                                dataType: 'json',
                                success: function (data) {
                                    DrawPie(data, "gender", "男女比率")
                                }
                            });

                            $.ajax({
                                url: "<?=$this->baseurl?>&m=ajax_statistic",
                                data: { types: "degrees" },
                                cache: false,
                                type: "post",
                                async: false,
                                dataType: 'json',
                                success: function (data) {
                                    DrawPie(data, "degrees", "学历比率");
                                }
                            });

                            $.ajax({
                                url: "<?=$this->baseurl?>&m=ajax_statistic",
                                data: { types: "marry" },
                                cache: false,
                                type: "post",
                                async: false,
                                dataType: 'json',
                                success: function (data) {
                                    DrawPie(data, "marry", "婚姻比率")
                                }
                            });

                            $.ajax({
                                url: "<?=$this->baseurl?>&m=ajax_statistic",
                                data: { types: "dept" },
                                cache: false,
                                async: false,
                                type: "post",
                                dataType: 'json',
                                success: function (data) {
                                    // DrawBar(data, "dept", "部门比率");
                                    //var aa=[{name:'后勤部',group:'',value:12},{name:'教务部',group:'',value:8}];
                                    DrawBars(data, "dept", "部门比率", true,false,"bar");
                                    //data:数据格式：Result2=[{name:XXX,group:XXX,value:XXX},{name:XXX,group:XXX,value:XXX]
                                }
                            });

                            $.ajax({
                                url: "<?=$this->baseurl?>&m=ajax_statistic",
                                data: { types: "birthday" },
                                cache: false,
                                async: false,
                                type: "post",
                                dataType: 'json',
                                success: function (data) {
                                    //  DrawBar(data, "birthday", "生日比");
                                    DrawBars(data, "birthday", "生日比", true,false,"bar");

                                }
                            });

                        });

                    </script>


                </td>

            </tr>

            </tbody></table>

    </div>

</div>
</body>
</html>
