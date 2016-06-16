<?php $this->load->view('teacher/header');?>
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <style>
        button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
    </style>
    <script type="text/javascript">
        $(function($)
        {
            // 数据列表 点击开始排序
            var sortFlag = 0;
            $("#sortTable th").click(function()
            {
                var tdIndex = $(this).index();
                var temp = "";
                var trContent = new Array();
                //alert($(this).text());

                // 把要排序的字符放到行的最前面，方便排序
                $("#sortTable .sortTr").each(function(i){
                    temp = "##" + $(this).find("td").eq(tdIndex).text() + "##";
                    trContent[i] = temp + '<tr class="sortTr">' + $(this).html() + "</tr>";
                });

                // 排序
                if(sortFlag==0) {
                    trContent.sort(sortNumber);
                    sortFlag = 1;
                } else {
                    trContent.sort(sortNumber);
                    trContent.reverse();
                    sortFlag = 0;
                }

                // 删除原来的html 添加排序后的
                $("#sortTable .sortTr").remove();
                $("#sortTable tr").first().after( trContent.join("").replace(/##(.*?)##/, "") );
            });


            // 点击更改状态
            $(".updatestatus").click(function(){
                var tid = $(this).attr("name");
                var mystatus = 0;
                if($(this).text() == "已审")
                {
                    $(this).text("未审");
                    $(this).addClass("red");
                } else {
                    mystatus = 1;
                    $(this).text("已审");
                    $(this).removeClass("red");
                }

                $.get("<?=$this->baseurl?>&m=updatestatus", { id: tid, status: mystatus },function(data){

                });
            });
            $("#del").click(function(){
                var arr=[];
                var i=0;
                $("input[name='delete[]']:checkbox:checked").each(function(){
                    arr[i]=$(this).val();
                    i++;
                });
                if(arr.length==0)
                {
                    alert('你未选择任何表');
                    return false;
                }
                if(confirm('确定要删除吗？'))
                {
                    return true;
                }
                return false;
            });
            // 开始
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
    <div class="mainbox">

	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=record" method="post">
            日期从&nbsp;&nbsp;<input type="text" class="txt" name="begintime"
                                   id="begintime"   value="" />
            至&nbsp;&nbsp;<input type="text" class="txt" name="endtime"
                                     id="endtime"   value="" />
            姓名<input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn">
        </form>
	</span> <input type="button" value="打卡记录" class="btn"/>

        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0"
                   class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="10"></th>
                    <th width="30">编号</th>
                    <th width="80">部门</th>
                    <th width="100">姓名</th>
                    <th width="100">时间</th>
                    <th width="150">星期</th>
                    <th width="150">指纹</th>
                    <th width="150">操作</th>
                </tr>

                <?php foreach($list as $key=>$r) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                                   class="checkbox" /></td>
                        <td><?=$key+1?></td>
                        <td><?=config_item('dept')[$r['dept']]?></td>
                        <td><?=$r['name']?></td>
                        <td><?=$r['checktime']?></td>
                        <td><?=$r['week']?></td>
                        <td><?=$r['uid']?></td>
                        <td>
                            <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>&nbsp;&nbsp;
                            <a href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>"
                               onclick="return confirm('确定要删除吗？');">删除</a></td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="17"><input type="checkbox" name="chkall" id="chkall"
                                            onclick="checkall('delete[]')" class="checkbox" /><label
                            for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "
                                                                    class="btn" id="del"/> &nbsp;</td>
                </tr>
            </table>

            <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

        </form>

    </div>
<?php $this->load->view('teacher/footer');?>