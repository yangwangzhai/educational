<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?=PRODUCT_NAME?>-园长端</title>

    <!-- Bootstrap -->
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="static/js/highcharts/highcharts.js?v=1"></script>
    <script type="text/javascript" src="static/js/highcharts/MyHighcharts.js?v=1.1"></script>
</head>
<body>
<div class="container-fluid">
    <style type="text/css">
        .main_header {
            width: 908px;
            height: 45px;
        }
        .main_header h3 {
            float: left;
            font: 24px/45px 'Microsoft YaHei';
            text-indent: 25px;
            color: #2b99f8;
        }
        .select_box {
            float: right;
            margin-left: 20px;
            height: 45px;
            margin-top:20px ;
            margin-bottom: 10px;
        }
        .select_box select{
            display: inline;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;

        }
        .word_items {
            margin-left: 20px;
            margin-bottom: 30px;
        }
        .word_items p{
            font-size: 20px;
        }
    </style>
    <div class="main_header">
        <h3>家长统计分析</h3>
        <div class="select_box">
            <!--<select id="grade">
                <?/*=getSelect($grade,$grade_sel)*/?>
            </select>
            <select>
                <option>请选择班级</option>
            </select>-->
            <span style="font-weight: bold;">选择年级：</span>
            <select class="form-control" name="value[grade]" id="grade" style="display: inline;width: auto">
                <?=getSelect($grade)?>
            </select>
            <span style="font-weight: bold;">选择班级：</span>
            <select class="form-control" name="value[class]" id="class" style="display: inline;width: auto">
                <option value="0">未选择</option>
            </select>
        </div>
    </div>
    <div style=" margin:20px; font-size:13px;">

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="word_items">
                    <p>掌握本园幼儿的家庭背景的分布情况<br>可以更好地决定本园的定位、收费等运营策略</p>
                </div>
            </div>
        </div>
        <!-- 1 -->
        <div class="panel panel-default">
            <div class="panel-body text-center">

                <table style="width:897px;"><tbody><tr><td valign="top">


                            <div style="width: 400px; height: 370px;">
                                <div id="container_in" style="min-width: 400px; height: 350px;" >
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="width: 400px; height: 370px; padding-left: 50px">
                                <div id="container_out" style="min-width: 400px; height: 350px;">
                                </div>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="width: 400px; height: 370px;">
                                <div id="container_in_left" style="min-width: 400px; height: 350px;" >
                                </div>
                            </div>

                        </td>
                        <td>
                            <div style="width: 400px; height: 370px; padding-left:50px">
                                <div id="container_out_right" style="min-width: 400px; height: 350px;">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="width: 400px; height: 370px;">
                                <div id="container_i_left" style="min-width: 400px; height: 350px;" >
                                </div>
                            </div>

                        </td>
                        <td>

                            <div style="width: 400px; height: 370px; padding-left:50px">
                                <div id="container_ou_right" style="min-width: 400px; height: 350px;">
                                </div>
                            </div>


                        </td>
                    </tr>
                    </tbody></table>

            </div>
        </div>

    </div>
</div>

<script type="application/javascript">
    function get_data(grade,classid)
    {
        $.ajax({
            url: "<?=$this->baseurl?>&m=ajax_statistic",
            data: { types:"relatives",grade:grade,classid:classid },
            type: "post",
            async: false,
            dataType: 'json',
            success: function (data) {

                var opt = HighChart.ChartOptionTemplates.Pie1(data,'',"亲属关系分布图");

                var container = $("#container_in");

                HighChart.RenderChart(opt, container);
            }
        });
        //配合度
        $.ajax({
            url: "<?=$this->baseurl?>&m=ajax_statistic",
            data: { types:"fit",grade:grade,classid:classid },
            type: "post",
            async: false,
            dataType: 'json',
            success: function (data) {

                var opt = HighChart.ChartOptionTemplates.Pie1(data,'',"家长配合度分布图");

                var container = $("#container_out");

                HighChart.RenderChart(opt, container);
            }
        });
        //家庭环境
        $.ajax({
            url: "<?=$this->baseurl?>&m=ajax_statistic",
            data: { types:"environment",grade:grade,classid:classid  },
            type: "post",
            async: false,
            dataType: 'json',
            success: function (data) {

                var opt = HighChart.ChartOptionTemplates.Pie1(data,'',"家庭环境分布图");

                var container = $("#container_in_left");

                HighChart.RenderChart(opt, container);
            }
        });
        //育儿经验
        $.ajax({
            url: "<?=$this->baseurl?>&m=ajax_statistic",
            data: { types:"experience",grade:grade,classid:classid  },
            type: "post",
            async: false,
            dataType: 'json',
            success: function (data) {

                var opt = HighChart.ChartOptionTemplates.Pie1(data,'',"家长育儿经验分布图");

                var container = $("#container_out_right");

                HighChart.RenderChart(opt, container);
            }
        });
        //家长学历
        $.ajax({
            url: "<?=$this->baseurl?>&m=ajax_statistic",
            data: { types:"degrees",grade:grade,classid:classid  },
            type: "post",
            async: false,
            dataType: 'json',
            success: function (data) {

                var opt = HighChart.ChartOptionTemplates.Pie1(data,'',"家长学历分布图");

                var container = $("#container_i_left");

                HighChart.RenderChart(opt, container);
            }
        });
        $.ajax({
            url: "<?=$this->baseurl?>&m=ajax_statistic",
            data: { types:"transport",grade:grade,classid:classid  },
            type: "post",
            async: false,
            dataType: 'json',
            success: function (data) {

                var opt = HighChart.ChartOptionTemplates.Pie1(data,'',"家长代步工具分布图");

                var container = $("#container_ou_right");

                HighChart.RenderChart(opt, container);
            }
        });
    }
    $(document).ready(function () {
        //data:数据格式：{name：xxx,value:xxx}...
        /*var data = [{ name: 'olive', value: 116 }, { name: 'momo', value: 115 }, { name: 'only', value: 222 }, { name: 'for', value: 324}];

        var opt = HighChart.ChartOptionTemplates.Pie1(data,'',"饼图示例");

        var container = $("#container_in");

        HighChart.RenderChart(opt, container);*/
        //亲属关系分布图
        get_data('all','all');

    });

</script>
<script type="application/javascript">
    $(document).ready(function(){
        $("#grade").bind("change",function(){
            var grade=$(this).val();
            if(grade==0)
            {
                get_data('all','all');
                $("#class").html("<option value='0'>未选择</option>");
            }
            else
            {
                get_data(grade,'all');
                $.ajax({
                    url:"index.php?&d=admin&c=class_list&m=ajaxclass",
                    type:"post",
                    async: false,
                    dataType:"json",
                    data:{grade:grade},
                    success:function(data){
                        if(data!='false')
                        {
                            $("#class").html("<option value='0'>未选择</option>");
                            $.each(data,function(key,value){
                                $("#class").append("<option value="+key+">"+value+"</option>")
                            });
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        alert(errorThrown);
                    }
                });
            }
        });
        $("#class").bind("change",function(){
            var grade=$("#grade").val();
            var classid=$(this).val();
            if(classid==0)
            {
                get_data(grade,'all');
                $("#class").html("<option value='0'>未选择</option>");
            }
            else
            {
                get_data('all',classid);
            }
        });
    });
</script>

</body>
</html>