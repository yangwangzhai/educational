<?php $this->load->view('admin/header');?>
    <style type="text/css">
        .styled-select {
            margin: 15px 15px;
            width: 150px;
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
        .btn-xs, .btn-group-xs>.btn {
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .bg-green {
            background-color: #00a65a !important;
        }
        .bg-red, .bg-yellow, .bg-aqua, .bg-blue, .bg-light-blue, .bg-green, .bg-navy, .bg-teal, .bg-olive, .bg-lime, .bg-orange, .bg-fuchsia, .bg-purple, .bg-maroon, .bg-black {
            color: #f9f9f9 !important;
        }
        a {
            color: #428bca;
            text-decoration: none;
        }
        a {
            background: 0 0;
        }
    </style>
    <script src="static/js/echarts-2.2.7/src/esl.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".styled-select").bind("change",function(){
                var value=$(this).val();
                location.href="<?=$this->baseurl?>&m=statistic&month=<?=$month?>&year="+value;
            });
        });
        /*
         * 按需加载
         * 引入echart.js依赖的zrender.js, 再引入echart.js
         */
        require.config({
            packages: [
                {
                    name: 'zrender',
                    location: 'static/js/zrender-2.1.0/src', // zrender与echarts在同一级目录
                    main: 'zrender'
                },
                {
                    name: 'echarts',
                    location: 'static/js/echarts-2.2.7/src',
                    main: 'echarts'
                }
            ]
        });

        /***/

        option = {
            title : {
                text: '<?php echo $year.'年'.$month;?>家长反馈统计',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient : 'vertical',
                x : 'left',
                data:[<?php foreach(config_item('feedback_type') as $r) echo "'$r'".',';?>]
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {
                        show: true,
                        type: ['pie', 'funnel'],
                        option: {
                            funnel: {
                                x: '25%',
                                width: '50%',
                                funnelAlign: 'center',
                                max: 20
                            }
                        }
                    },
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            series : [
                {
                    name:'家长反馈',
                    type:'pie',
                    radius : ['50%', '70%'],
                    itemStyle : {
                        normal : {
                            label : {
                                show : false
                            },
                            labelLine : {
                                show : false
                            }
                        },
                        emphasis : {
                            label : {
                                show : true,
                                position : 'center',
                                textStyle : {
                                    fontSize : '30',
                                    fontWeight : 'bold'
                                }
                            }
                        }
                    },
                    data:[
                        <?php foreach($list as $v):?>
                        {value:<?php echo $v['num']?>, name:'<?php echo $v['feedback_type']?>'},
                        <?php endforeach;?>
                    ]
                }
            ]
        };

        /*
         *按需加载
         */
        require(
            [
                'echarts',
                'echarts/chart/pie',
                'echarts/chart/funnel'
            ],
            //渲染ECharts图表
            function DrawEChart(ec) {
                //图表渲染的容器对象
                var chartContainer = document.getElementById("container");
                //加载图表
                var myChart = ec.init(chartContainer);
                myChart.setOption(option);
            }
        );
    </script>
    <div class="mainbox">
        <table style="BORDER:#ddd 1px solid; margin-bottom: 20px"  cellSpacing=1 cellPadding=1 width="100%" border=1>
            <tr>
                <td width="100%" height="20">
                    <select name="year" class="styled-select">
                        <?php echo getSelect(config_item("YEAR"),$year)?>
                    </select>
                    <?php foreach(config_item("MONTH") as $k=>$val):?>
                        <a class="btn btn-flat btn-xs <?php if($month==$k)echo 'bg-green'?>" href="<?=$this->baseurl?>&m=statistic&month=<?=$k?>&year=<?=$year?>"><?php echo $val?></a>
                    <?php endforeach;?>
                </td>
            </tr>
        </table>
        <table style="BORDER:#ddd 1px solid;" cellSpacing=1 cellPadding=1 width="100%" border=1>
                <tr>
                    <td id="container" style="width:100%; height:400px;"></td>
                </tr>
        </table>
    </div>


<?php $this->load->view('admin/footer');?>