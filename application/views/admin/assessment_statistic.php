<?php $this->load->view('admin/header');?>
    <style type="text/css">
#main{width:auto;height:450px;   border: 2px solid #B5CFD9; }
#left{width:20%;height: 100%;  border-right: 1px solid #B5CFD9;}
#right{width:75%;height:100%;border-left: 1px solid #B5CFD9;}
#left,#right{float:left;}
/*************** Pagination  for MeMo Blog ***************/
#page .pagination {border-top:1px solid #dfdfdf; padding-top: 10px; text-align: left; margin-bottom: 10px; font-size: 10px;}
.pagination a ,.pagination a.number {margin: 0 5px 0 0; padding: 3px 6px; border: 1px solid #d0d0d0;}
.pagination a:hover,.pagination a.current {border-color: #000 !important; color: #000 !important;}
</style>
    <script type="text/javascript" src="static/js/highcharts/highcharts.js"></script>
    <script type="text/javascript">
        $(function () {
            var chart;
            var totalMoney=<?php echo $num?>;
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
                        text: "教师<?php echo config_item('semester')[$semester].config_item('MONTH1')[$month]?>考核统计"//图表标题
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
                            return this.point.name+':'+totalMoney*this.point.percentage/100+'个';
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            }
                        }
                    },
                    series: [{//设置每小个饼图的颜色、名称、百分比
                        type: 'pie',
                        name: null,
                        data: [
                            {name:'优秀',y:<?php echo $excellent?>},
                            {name:'良好',y:<?php echo $good?>},
                            {name:'差',y:<?php echo $poor?>},
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


    <div id="main">
        <!--<span style="float: right">
            <a href="index.php?&d=admin&c=assessment&m=add">添加</a>
	</span>-->
        <div id="left">
            <table width="99%" border="1" cellpadding="3" cellspacing="0">

                <tr>
                    <?php foreach($teacher as $k=>$item):?>
                    <?php if($k%2==0 AND $k>0)echo '<tr>'?>
                    <td>
                        <a href="index.php?d=admin&c=assessment&m=detail&teacherid=<?php echo $item['id']?>&month=<?php echo $month?>&semester=<?php echo $semester?>">
                            <?php echo $k+1?>&nbsp;&nbsp;&nbsp;<?php if($item['total']!=''):?><font color="green"><?php echo $item['truename']?>(<?=$item['total']?>)</font><?php else:?><?php echo $item['truename']?><?php endif;?>
                        </a>
                    </td>
                    <?php endforeach;?>
                </tr>
            </table>
            <!--<table width="99%" border="0" cellpadding="3" cellspacing="0" >
                <tr>
                    <td align="right"><a href="">上一页</a></td>
                    <td align="left"><a href="">下一页</a></td>
                </tr>
            </table>-->
            <div class="pagination"><?=$pages?></div>
        </div>
        <div id="right">
            <table width="99%" border="0" cellpadding="3" cellspacing="0" >
                <tr>
                    <td id="container" style="width:100%; height:400px;"></td>
                </tr>
            </table>
            <table width="99%" border="0" cellpadding="3" cellspacing="0" >
                <tr>
                    <td align="right"><a href="index.php?d=admin&c=assessment&m=statistic&month=<?php echo $pre_month?>&semester=<?php echo $semester?>"><?php if($pre_month!=0):?>上一页<?php endif;?></a></td>

                    <td align="left"><a href="index.php?d=admin&c=assessment&m=statistic&month=<?php echo $next_month?>&semester=<?php echo $semester?>"> <?php if($next_month!=0):?>下一页<?php endif;?></a></td>

                </tr>
            </table>
        </div>

    </div>
<?php $this->load->view('admin/footer');?>