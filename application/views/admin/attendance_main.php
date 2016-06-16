<?php $this->load->view('admin/header');?>
<script src="static/js/highcharts/highcharts.js" type="text/javascript"></script>
<script>
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },

            title: {
                text: '<a href="index.php?d=admin&c=attendance&m=index&pubdate=<?php echo $pubdate?>"><?php echo $month?>考勤统计</a>',
                useHTML:true
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: [<?php foreach(config_item('attendance_type') as $r) echo "'$r'".',';?>]
            },
            yAxis: {
                title: {
                    text: '次数'
                }
            },
            series: [
                <?php foreach($list as $k=>$item):?>
                {
                name: '<?php echo config_item('dept')[$k]?>',
                data: [<?php echo $item['zhengch']?>, <?php echo $item['chidao']?>, <?php echo $item['zaotui']?>,<?php echo $item['weidaka']?>]
            },
            <?php endforeach;?>
            ]
        });
        $('#container2').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '考勤统计迟到比例, <?php echo $month?>'
            },
            credits: {
                enabled: false
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '迟到比例',
                data: [
                    <?php foreach($list as $k=>$item):?>
                        ['<?php echo config_item('dept')[$k]?>',   <?php echo $item['chidao']?>],
                    <?php endforeach;?>
                ]
            }]
        });
        $('#container3').highcharts({
            chart: {
                type: 'column'
            },

            title: {
                text: '<a href="index.php?d=admin&c=attendance&m=index&pubdate=<?php echo $pubdate?>">往月考勤比较</a>',
                useHTML:true
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: [<?php foreach($month_ar as $r) echo "'$r'".',';?>]
            },
            yAxis: {
                title: {
                    text: '缺勤次数'
                }
            },
            series: [
                <?php foreach($m_list as $k=>$item):?>
                {
                    name: '<?php echo config_item('dept')[$k]?>',
                    data: [<?php foreach($item as $r) echo "$r[weidaka]".',';?>]
                },
                <?php endforeach;?>
            /*{
                name: '行政部',
                data: [8, 1, 9, 1, 6, 3, 2, 7  ]
            }, {
                name: '总经办',
                data: [1, 2, 2, 2, 5, 2, 4, 3 ]
            },{
                name: '技术一组',
                data: [1, 5, 4, 3, 4, 4, 2, 6 ]
            },{
                name: '技术二组',
                data: [3, 3, 3, 4, 3, 7, 2, 3 ]
            },{
                name: '后勤',
                data: [5, 9, 6, 5, 2, 2, 7, 9 ]
            },{
                name: '市场部',
                data: [2, 3, 4, 6, 1, 9, 2, 3 ]
            }*/]
        });
    });

</script>

<div class="mainbox">
    <table>
        <tr>
            <td>    <div id="container" style=" height: 200px"></div></td>
            <td>    <div id="container2" style="height: 200px"></div></td>
        </tr>

        <tr>
            <td>    <div id="container3" style="height: 200px;"></div></td>
        </tr>
    </table>



</div>


<?php $this->load->view('admin/footer');?>