<?php $this->load->view('teacher/header');?>
<link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
<script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
<style>
    button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
</style>
<script>
$(document).ready(function(){
    $('#pubdate').Zebra_DatePicker({
        months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
        days:['日', '一', '二', '三', '四', '五', '六'],
        lang_clear_date:'清除',
        show_select_today:'今天'
    });
	// 点击表格事件 用于修改 添加食谱
	$(".table_content").click(function(){
			var classid = <?php echo $classid?>;
			var pubdate = $(this).attr("data-pubdate");
			var meal = $(this).attr("data-meal");
			location.href="<?=$this->baseurl?>&m=add&classid="+classid+"&pubdate="+pubdate+"&meal="+meal;
	});
});
</script>

<div class="mainbox nomargin">

    <form action="<?=$this->baseurl?>&m=index" method="post">
        一周食谱&nbsp;&nbsp; <input type="text" class="txt" name="pubdate"
                       id="pubdate"   value="<?php echo $date?>" />&nbsp;&nbsp;
班级选择：<input type="text" class="txt" value="<?php echo $classname?>" />
         <input type="submit" name="button" id="button" value="显示" class="btn"/>

					<hr />
    </form>
	<table  border="1" cellpadding="5" cellspacing="0" class="timetable">
		<tr style="background:#F7F7F7">
			<td >餐次 \ 星期</td>
			<?php foreach(config_item('week2') as $week):?>
			<td ><?=$week?></td>
			<?php endforeach;?>			
		</tr>
        <?php foreach($table as $key=>$value):?>
            <tr>
                <td style="background:#F7F7F7"><?=$value['mealtime']?></td>
                <?php foreach($weekdate as $k=>$v):?>
                    <td data-pubdate="<?=$v?>" data-meal="<?=$key?>"  class="table_content" title="">
                        <?php echo $value[$k]['content']?>
                    </td>
                <?php endforeach;?>
            </tr>
        <?php endforeach;?>

	</table>
</div>
<?php $this->load->view('teacher/footer');?>
