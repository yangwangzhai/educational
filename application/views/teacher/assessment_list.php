<?php $this->load->view('teacher/header');?>

    <style type="text/css">
        body,ul {
            margin:0;
            padding:0;
        }

        ul {
            width:100%;
            margin:0 50px;
            padding:10px 0 6px 15px;
            /* width:660px;
             margin:0 100px;
             padding:10px 0 6px 15px;
           /*border:0px solid #E4E1D3;
             border-width:0 3px 3px 3px;*/
        }
        ul li {
            float:left;
            margin:5px 15px 3px 0;
            list-style-type:none;
            display:inline;
        }
        ul li a {
            display:block;
            width:150px;
            height:175px;
            text-decoration:none;
        }
        ul li a img {
            width:102px;
            height:102px;
            border:0;
        }
        ul li a span {
            display:block;
            width:102px;
            height:23px;
            line-height:20px;
            font-size:16px;
            text-align:center;
            color:#333;
            cursor:hand;
            white-space:nowrap;
            overflow:hidden;
        }
        ul li a:hover span {
            color:#c00;
        }
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
    </style>
    <script src="static/js/echarts-2.2.7/src/esl.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#sel").bind("change",function(){
                var value=$(this).val();
                location.href="index.php?d=teacher&c=assessment&m=index&semester="+value;
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
        var option = {
            title:{
                text:'<?php echo config_item('semester')[$semester]?>考核曲线图演示',
                x: "center" //标题水平方向位置
            },
            tooltip : {
                trigger: 'item'//item  axis
            },
            legend: {
                data:['教师测评'],
                y:"left",
                x:'left'
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : [<?php foreach($xdata as $r) echo "'$r 月'".',';?>]
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    axisLabel : {
                        formatter: '{value} 分值'
                    },
                    splitArea: { show: true }
                }
            ],
            series : [
                //条形图
                {
                    "name":"教师测评",
                    "type":"bar",
                    "data":[<?php foreach($ydata as $v) echo $v.',';?>]
                },
                //折线图
                {
                    "name":"教师测评",
                    "type":"line",
                    "data":[<?php foreach($ydata as $v) echo $v.',';?>],
                    //绘制平均线
                    markLine : {
                        data : [
                            {type : 'average', name: '平均值'}
                        ]
                    },
                    //绘制最高最低点
                    markPoint : {
                        data : [
                            {type : 'max', name: '最大值'},
                            {type : 'min', name: '最小值'}
                        ]
                    }
                }
            ]
        };


        /*
         *按需加载
         */
        require(
            [
                'echarts',
                'echarts/chart/line',
                'echarts/chart/bar'
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
        <span style="float: right">
            学期&nbsp;&nbsp;<select name="semester" id="sel" class="styled-select">
                <?=getSelect(config_item('semester'),$semester)?>
            </select>
	</span>
        <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist fixwidth" id="sortTable">
            <tr>
                <div id="container" style="width:100%; height:400px;"></div>
            </tr>
            <br>
            <tr>
                <td>
                    <ul>
                        <?php foreach($xdata as $key=>$val):?>
                        <li>
                            <a class="item" href="<?=$this->baseurl?>&m=detail&month=<?php echo $val?>&semester=<?php echo $semester?>">
                                <img src="static/admin_img/date.png" alt="教师测评" />
                                <span><?php echo $val?>月</span>
                            </a>
                            <span>测评情况：&nbsp;&nbsp;<?=$state[$key]?></span>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </td>
            </tr>
        </table>

    </div>
<?php $this->load->view('teacher/footer');?>