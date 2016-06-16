<?php $this->load->view('teacher/header');?>
    <script type="text/javascript" src="static/js/highcharts/highcharts.js"></script>
    <script type="text/javascript" src="static/js/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript">
        $(function () {
            var chart;
            var totalMoney=<?php echo $value['total']?>;
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
                        text: '<?php echo $this->teacher['truename']?>工资组成统计分析'//图表标题
                        //verticalAlign:'bottom',
                        //y:-60
                    },
                    tooltip: {//鼠标移动到每个饼图显示的内容
                        pointFormat: '{point.name}: <b>{point.percentage}%</b>',
                        percentageDecimals: 1,
                        formatter: function() {
                            return this.point.name+':'+totalMoney*this.point.percentage/100;
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
                            {name:'基本工资',color:'#3DA9FF',y:<?php echo $value['basic']?>},
                            {name:'加班费',color:'#008FE0',y:<?php echo $value['overtime']?>},
                            {name:'奖金',color:'#00639B',y:<?php echo $value['bonus']?>},
                            {name:'其他补贴',color:'#CBECFF',y:<?php echo $value['othersubsidy']?>},
                            {name:'高温津贴',color:'#CBECFF',y:<?php echo $value['highsubsidy']?>},
                            {name:'养老保险金',color:'#CBECFF',y:<?php echo $value['retire']?>},
                            {name:'医疗保险金',color:'#CBECFF',y:<?php echo $value['medical']?>},
                            {name:'失业保险金',color:'#CBECFF',y:<?php echo $value['unemployeed']?>},
                            {name:'住房公积金',color:'#CBECFF',y:<?php echo $value['housing']?>},
                            {name:'无薪假期',color:'#CBECFF',y:<?php echo $value['nosalary']?>},
                            {name:'个人所得税',color:'#CBECFF',y:<?php echo $value['tax']?>},
                            {name:'其他调整',color:'#CBECFF',y:<?php echo $value['adjust']?>},
                            /*{name:'实发薪金',color:'#CBECFF',y:<?php echo $value['total']?>},*/
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
        <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist fixwidth" id="sortTable">
            <tr>
                <div id="container" style="width:100%; height:400px;"></div>
            </tr>
        </table>
    </div>
<?php $this->load->view('teacher/footer');?>