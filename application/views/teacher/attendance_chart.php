<?php $this->load->view('teacher/header');?>
    <script type="text/javascript" src="static/js/highcharts/highcharts.js"></script>
    <script type="text/javascript" src="static/js/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript">
        $(function () {
            var chart;
            var totalMoney=<?php echo $arr[0]['num']+$arr[1]['num']+$arr[2]['num']+$arr[3]['num']?>;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container',
                        //饼状图关联html元素id值
                        defaultSeriesType: 'pie',
                        //默认图表类型为饼状图
                        plotBackgroundColor: '#ffc',
                        //设置图表区背景色
                        plotShadow: true //设置阴影
                    },
                    title: {
                        text: '打卡统计分析'//图表标题
                        //verticalAlign:'bottom',
                        //y:-60
                    },
                    credits: {
                        enabled: false
                    },
                    tooltip: {//鼠标移动到每个饼图显示的内容
                        pointFormat: '{point.name}: <b>{point.percentage}%</b>',
                        percentageDecimals: 1,
                        formatter: function() {
                            return this.point.name+':'+totalMoney*this.point.percentage/100+'次';
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            //允许选中，点击选中的扇形区可以分离出来显示
                            cursor: 'pointer',
                            //当鼠标指向扇形区时变为手型（可点击）
                            //showInLegend: true, //如果要显示图例，可将该项设置为true
                            dataLabels: {
                                enabled: true,
                                //设置数据标签可见，即显示每个扇形区对应的数据
                                color: '#000000',
                                //数据显示颜色
                                connectorColor: '#999',
                                //设置数据域扇形区的连接线的颜色
                                style: {
                                    fontSize: '12px' //数据显示的大小
                                },
                                formatter: function(index) {
                                    return  '<span style="color:#00008B;font-weight:bold">' + this.point.name + '</span>';
                                }
                            },
                            padding:20
                        }
                    },
                    series: [{//设置每小个饼图的颜色、名称、百分比
                        type: 'pie',
                        name: null,
                        data: [
                            {name:'<?php echo config_item('attendance_type')[$arr[0]['state']]?>',color:'#3DA9FF',y:<?php echo $arr[0]['num']?>},
                            {name:'<?php echo config_item('attendance_type')[$arr[1]['state']]?>',color:'#008FE0',y:<?php echo $arr[1]['num']?>},
                            {name:'<?php echo config_item('attendance_type')[$arr[2]['state']]?>',color:'#00639B',y:<?php echo $arr[2]['num']?>},
                            {name:'<?php echo config_item('attendance_type')[$arr[3]['state']]?>',color:'#CBECFF',y:<?php echo $arr[3]['num']?>},
                        ]
                    }]
                });
            });
            //弹出选择教师
            $("#teachername").click(function(){
                teacherdialog=dialog_url('index.php?d=admin&c=teacher&m=dialog','选择教师：');
            });
        });
    </script>


    <div class="mainbox">
        <form action="<?=$this->baseurl?>&m=chart" method="post">
            月份&nbsp;&nbsp;<input type="text" id="d243" name="pubdate" value="<?php echo $pubdate?>" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM'})" class="Wdate"/>
            <input type="submit" name="button" id="button" value="显示" class="btn"/>

            <hr />
        </form>
        <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist fixwidth" id="sortTable">
            <tr>
                <div id="container" style="width:100%; height:400px;"></div>
            </tr>
        </table>
    </div>
<?php $this->load->view('teacher/footer');?>