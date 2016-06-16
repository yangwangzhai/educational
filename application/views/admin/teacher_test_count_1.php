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
        <div class="soft_con1" style="background:url(static/timetable/images/line_select_003.gif);"></div>
    </div>
    <div class="container-fluid">
        <table style="width:100%">
            <tbody><tr valign="top">
                <td>
                    <style>
                        .rpt td {
                            margin:5px; padding:5px; text-align:center
                        }
                    </style>
                    <table class="rpt" cellpadding="50px" cellspacing="5px">
                        <tbody><tr>
                            <td>
                                <div class="thumbnail" >
                                    <b>请假分次数布图</b>
                                    <form action="<?=$this->baseurl?>&m=reason" method="post">
                                        <div class="select_box02 fr" style="width:320px;">
                                            <input class="text-word"  type="text" name="begintime" id="begintime01" value="<?=$begintime?>">
                                            至
                                            <input class="text-word"  type="text" name="endtime" id="endtime01" value="<?=$endtime?>">
                                            <input class="submit" type="submit" value="查询">
                                        </div>
                                    </form>
                                    <div id="gender" style="width:250px; height:250px; margin-left:50px; margin-top:50px;">
                                        <img src="static/admin_img/loading.gif" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="thumbnail">

                                    <b>请假原因分布图</b>
                                    <form action="<?=$this->baseurl?>&m=reason" method="post">
                                        <div class="select_box02 fr" style="width:320px;">
                                            <input class="text-word"  type="text" name="begintime" id="begintime02" value="<?=$begintime?>">
                                            至
                                            <input class="text-word"  type="text" name="endtime" id="endtime02" value="<?=$endtime?>">
                                            <input class="submit" type="submit" value="查询">
                                        </div>
                                    </form>
                                    <div id="degrees" style="width:250px; height:250px; margin-left:50px; margin-top:50px;">
                                        <img src="static/admin_img/loading.gif" />
                                    </div>
                                </div>

                            </td>

                            <td>
                                <div class="thumbnail">

                                    <b>个人请假分布图</b>
                                    <form action="<?=$this->baseurl?>&m=reason" method="post">
                                        <div class="select_box02 fr" style="width:320px;">
                                            <input class="text-word"  type="text" name="begintime" id="begintime03" value="<?=$begintime?>">
                                            至
                                            <input class="text-word"  type="text" name="endtime" id="endtime03" value="<?=$endtime?>">
                                            <input class="submit" type="submit" value="查询">
                                        </div>
                                    </form>
                                    <div id="marry" style="width:250px; height:250px; margin-left:50px; margin-top:50px;">
                                        <img src="static/admin_img/loading.gif" />
                                    </div>

                                </div>
                            </td>

                        </tr>

                        <tr>
                            <td>

                                <div class="thumbnail">

                                    <b>个人请假原因分布图</b>
                                    <form action="<?=$this->baseurl?>&m=reason" method="post">
                                        <div class="select_box02 fr" style="width:320px;">
                                            <input class="text-word"  type="text" name="begintime" id="begintime04" value="<?=$begintime?>">
                                            至
                                            <input class="text-word"  type="text" name="endtime" id="endtime04" value="<?=$endtime?>">
                                            <input class="submit" type="submit" value="查询">
                                        </div>
                                    </form>
                                    <div id="dept" style="width:350px; height:250px;   margin-top:20px;">
                                        <img src="static/admin_img/loading.gif" />
                                    </div>

                                </div>
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



                        });

                    </script>


                </td>

            </tr>

            </tbody></table>

    </div>

</div>
</body>
</html>
