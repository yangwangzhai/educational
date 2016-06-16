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
    <script type="text/javascript" src="static/js/highcharts/highcharts.js?v=1.1"></script>
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <style>
        button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){


            // 日期
            $('#begintime').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            // 日期
            $('#endtime').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
        });
    </script>
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
        .select_box02 {
            font-size: 16px;
            margin-top:20px ;
            margin-bottom: 10px;
        }
        .fr {
            float: right;
        }
        .select_box02 .text-word {
            display: inline-block;
            width: 130px;
            height: 40px;
            padding: 0 10px;
            font: 14px/40px 'Microsoft YaHei';
            border: 1px solid #ced5d8;
            background-color: #fff;
        }
        .select_box02 .submit {
            display: block;
            float: right;
            margin-left: 15px;
            font: 16px/40px 'Microsoft YaHei';
            background-color: #fff;
            width: 120px;
            height: 40px;
            border: 1px solid #ced5d8;
            text-align: center;
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
        <h3>入离园分析</h3>
        <form action="<?=$this->baseurl?>&m=reason" method="post">
        <div class="select_box02 fr" style="width:470px;">
            <input class="text-word"  type="text" name="begintime" id="begintime" value="<?=$begintime?>">
            至
            <input class="text-word"  type="text" name="endtime" id="endtime" value="<?=$endtime?>">
            <input class="submit" type="submit" value="查询">
        </div>
        </form>
    </div>
    <div style=" margin:20px; font-size:13px;">

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="word_items">

                    <p>掌握幼儿非正常离园（退学）的理由可以了解本园软硬件发方面的劣势<br>从而对症下药进行改进以降低学生的流失率<br><br>
                        掌握幼儿选择本园的理由可以了解本园吸引生源的优势所在<br>从而进一步调整招生策略突显本园的优势和特色</p>
                </div>

            </div>
        </div>
        <!-- 1 -->
        <div class="panel panel-default">
            <div class="panel-body text-center">

                <p class="main_tips_top"></p>

                <div class="main_tips_repeat" style="background-color:White; width:910px;height:530px;padding:0;  padding-left:10px;">

                    <script language="javascript" type="text/javascript">


                        ﻿$(function () {
                            $('#container_out').highcharts({
                                chart: {
                                    type: 'pie',
                                    marginTop:'100',
                                    options3d: {
                                        enabled: false,
                                        alpha: 45
                                    }
                                },
                                title: {
                                    text: '全园异常离园(退学)理由分布图<span style="float:right;margin-right:70px;font-size:18px; margin-top:-40px;display:none;"><a class="excel_btn02" href="javascript:more_show(0)">查询离园明细</a></span><span style="display:block; width:887px; height:2px; margin:15px auto 0; background:#78BFFF;"></span>',
                                    align:'left',
                                    style:{ "font":"bold 20px/32px 'Microsoft YaHei'"}
                                    ,x:30
                                    ,y:30
                                    ,useHTML:true
                                },
                                subtitle: {
                                    text: ''
                                },
                                plotOptions: {
                                    pie: {
                                        innerSize: 190,
                                        depth: 45,
                                        cursor: 'pointer',
                                        borderWidth:2,
                                        dataLabels:
                                        {
                                            enabled:false
                                        }
                                        ,showInLegend:true
                                        ,enableMouseTracking:true
                                        ,states:
                                        {
                                            hover:{enabled:false}
                                        }
                                    }
                                },
                                tooltip: {
                                    headerFormat:''
                                    ,pointFormat:''
                                    ,enabled: true
                                    ,useHTML: true
                                    ,formatter: function() {
                                        var w=200;
                                        w = w+25*this.point.y.toString().length;
                                        var l=70;
                                        l = l+7*this.point.y.toString().length;
                                        return '<div style=\"width:'+w+'px; height:20px; line-height:20px; font-family:Microsoft YaHei\"><p style=" position:absolute; left:'+l+'px; top:27px; z-index:99;  width:20px; height:12px; font-size:1px; background:url(static/js/highcharts/color_jt.png) no-repeat"></p><span style=\"float:left; width:16px; height:16px; margin:3px 0  0 0px; display:block; background:'+this.point.color+';\"></span><span style=\"float:left; padding-left:10px;\">'+this.point.name+'：'+this.point.y +'人（'+ Math.round(this.point.percentage*100)/100+'%）'+'</span></div>'

                                    }
                                    ,borderWidth:0
                                    ,animation:false
                                    ,backgroundColor:'#fff'
                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'top',
                                    enabled:true,
                                    itemMarginTop:15
                                    ,symbolRadius:12
                                    ,symbolHeight:17
                                    //,symbolWidth:0
                                    ,symbolPadding:-18
                                    ,useHTML:true
                                    ,margin:20
                                    ,y:60
                                    ,labelFormatter: function() {
                                        return  '<div style="width:200px; font-size:16px;height:25px; border-bottom:1px solid #d4d1e2;padding_bottom:25px;margin-top:-3px;"><span style="float:left; margin-left:30px;font-family:Microsoft YaHei; color:#2f3034; ">'+this.name+'</span><span style="float:right;margin-right:10px ;font-family:Microsoft YaHei; color:#2f3034;">'+this.y+'人</span></div>';
                                    }
                                }
                                ,
                                series: [{
                                    name: '',
                                    data:[
                                        <?php foreach($leaving as $item):?>
                                        <?php if($item['name']=='--') $item['name']='未选择'?>
                                        {name:'<?php echo $item['name']?>',y:<?php  echo $item['value']?>},
                                        <?php endforeach;?>
                                    ]
                                }]
                            });
                        });
                    </script>
                    <div style="width: 880px; height: 500px;  position:relative; z-index:9998;">
                        <div id="container_out" style="min-width: 600px; height: 480px; ">
                        </div>
                    </div>

                </div>

                <p class="main_tips_bottom"></p>
                <br />

                <p class="main_tips_top"></p>

                <div class="main_tips_repeat" style="background-color: White; width: 910px; height: 530px;
                        padding: 0; padding-left: 10px;">

                    <script type="text/javascript">
                        ﻿$(function () {
                            $('#container_in').highcharts({
                                chart: {
                                    type: 'pie',
                                    marginTop:'100',
                                    options3d: {
                                        enabled: false,
                                        alpha: 45
                                    }
                                },
                                title: {
                                    text: '全园入园理由分布图<span style="display:block; width:887px; height:2px; margin:15px auto 0; background:#78BFFF;"></span>',
                                    align:'left',
                                    style:{ "font":"bold 20px/32px 'Microsoft YaHei'"}
                                    ,x:30
                                    ,y:30
                                    ,useHTML:true
                                },
                                subtitle: {
                                    text: ''
                                },
                                plotOptions: {
                                    pie: {
                                        innerSize: 190,
                                        depth: 45,
                                        cursor: 'pointer',
                                        borderWidth:2,
                                        dataLabels:
                                        {
                                            enabled:false
                                        }
                                        ,showInLegend:true
                                        ,enableMouseTracking:true
                                        ,states:
                                        {
                                            hover:{enabled:false}
                                        }
                                    }
                                },
                                tooltip: {
                                    headerFormat:''
                                    ,pointFormat:''
                                    ,enabled: true
                                    ,useHTML: true
                                    ,formatter: function() {
                                        var w=160;
                                        w = w+25*this.point.y.toString().length;
                                        var l=70;
                                        l = l+7*this.point.y.toString().length;
                                        return '<div style=\"width:'+w+'px; height:20px; line-height:20px; font-family:Microsoft YaHei\"><p style=" position:absolute; left:'+l+'px; top:27px; z-index:99;  width:20px; height:12px; font-size:1px; background:url(static/js/highcharts/color_jt.png) no-repeat"></p><span style=\"float:left; width:16px; height:16px; margin:3px 0  0 0px; display:block; background:'+this.point.color+';\"></span><span style=\"float:left; padding-left:10px;\">'+this.point.name+'：'+this.point.y +'人（'+ Math.round(this.point.percentage*100)/100+'%）'+'</span></div>'

                                    }
                                    ,borderWidth:0
                                    ,animation:false
                                    ,backgroundColor:'#fff'
                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'top',
                                    enabled:true,
                                    itemMarginTop:15
                                    ,symbolRadius:12
                                    ,symbolHeight:17
                                    //,symbolWidth:0
                                    ,symbolPadding:-18
                                    ,useHTML:true
                                    ,margin:20
                                    ,y:60
                                    ,labelFormatter: function() {
                                        return  '<div style="width:200px; font-size:16px;height:25px; border-bottom:1px solid #d4d1e2;padding_bottom:25px;margin-top:-3px;"><span style="float:left; margin-left:30px;font-family:Microsoft YaHei; color:#2f3034; ">'+this.name+'</span><span style="float:right;margin-right:10px ;font-family:Microsoft YaHei; color:#2f3034;">'+this.y+'人</span></div>';
                                    }
                                }
                                ,
                                series: [{
                                    name: '',
                                    data:[
                                        <?php foreach($reason as $item):?>
                                        <?php if($item['name']=='--') $item['name']='未选择'?>
                                        {name:'<?php echo $item['name']?>',y:<?php  echo $item['value']?>},
                                        <?php endforeach;?>
                                    ]
                                }]
                            });
                        });
                    </script>
                    <div style="width: 880px; height: 520px;">
                        <div id="container_in" style="min-width: 600px; height: 500px;">
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>

</body>
</html>