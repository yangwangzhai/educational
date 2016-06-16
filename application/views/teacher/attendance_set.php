<?php $this->load->view('admin/header');?>
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

            var dodate = $(this).attr("data-dodate");
            var set_title = $(this).attr("data-title");
            location.href="<?=$this->baseurl?>&m=set_add&dodate="+dodate+"&set_title="+set_title;
        });

    });
</script>

<div class="mainbox nomargin">

    <form action="<?=$this->baseurl?>&m=set" method="post">
        一周&nbsp;&nbsp; <input type="text" class="txt" name="dodate"
                                id="pubdate"   value="<?php echo $date?>" />&nbsp;&nbsp;
        <input type="submit" name="button" id="button" value="&nbsp;&nbsp;显示&nbsp;&nbsp;" class="btn"/>
        <input type="button" value="&nbsp;&nbsp;月&nbsp;&nbsp;" class="btn"
               onclick="location.href='<?=$this->baseurl?>&m=set_month'"
            />
        <hr />
    </form>
    <table  border="1" cellpadding="5" cellspacing="0" class="timetable">
        <tr style="background:#F7F7F7">
            <td >班次 \ 星期</td>
            <?php foreach(config_item('week2') as $week):?>
                <td ><?=$week?></td>
            <?php endforeach;?>
        </tr>

        <?php foreach($table as $key=>$value):?>
            <tr>
                <td style="background:#F7F7F7"><?=$value['set_title']?></td>
                <?php foreach($weekdate as $k=>$v):?>
                    <td data-dodate="<?=$v?>" data-title="<?=$key?>"  class="table_content" title="">
                    <?php if($value[$k]['iswork']=='0'):?><font color="green">休</font><?php else:?><?php echo $value[$k]['begintime'].'<br>'.$value[$k]['endtime']?><?php endif;?>
                    </td>
                <?php endforeach;?>
            </tr>
        <?php endforeach;?>
    </table>
</div>
<?php $this->load->view('admin/footer');?>
