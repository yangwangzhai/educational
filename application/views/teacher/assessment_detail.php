<?php $this->load->view('teacher/header');?>
    <script src="static/js/echarts-2.2.7/src/esl.js"></script>
    <script type="text/javascript">

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
            title: {
                text: "<?php echo $title?>曲线图演示", //正标题
                /*link: "http://www.stepday.com", //正标题链接 点击可在新窗口中打开*/
                x: "center", //标题水平方向位置
                //正标题样式
                textStyle: {
                    fontSize:24
                }

            },
            tooltip : {
                trigger: 'axis'//item  axis
            },
            legend: {
                data: ['得分情况', '标准得分'], //这里需要与series内的每一组数据的name值保持一致
                y:"bottom"
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
            xAxis: [
                {
                    type: 'category',
                    data: ['师德师风','常规管理','教育教学','保育工作','教科研究','考勤情况','总分'],
                    name: "测评项"
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
                {
                    name: '得分情况',
                    type: 'bar',
                    data: [<?php echo $morality.','.$management.','.$teaching.','.$conservation.','.$research.','.$attendance.','.$total;?>]
                },
                {
                    name: '标准得分',
                    type: 'bar',
                    data: [20,20,45,20,20,15,140]
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

            <a href="<?=$this->baseurl?>&m=details&id=<?php echo $id?>"><?php if($id!=''):?>详情<?php endif;?></a>
	</span>
        <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist fixwidth" id="sortTable">
            <tr>
                <div id="container" style="width:100%; height:400px;"></div>
            </tr>
            <br>
            <tr>
                <td align="right"><a href="<?=$this->baseurl?>&m=detail&month=<?php echo $pre_month?>&semester=<?php echo $semester?>"><?php if($pre_month!=0):?>上一页<?php endif;?></a></td>

                <td align="left"><a href="<?=$this->baseurl?>&m=detail&month=<?php echo $next_month?>&semester=<?php echo $semester?>"> <?php if($next_month!=0):?>下一页<?php endif;?></a></td>

            </tr>
        </table>
    </div>
<?php $this->load->view('teacher/footer');?>