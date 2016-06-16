<?php $this->load->view('admin/header');?>
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
            // 入园年龄
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
		<form action="<?=$this->baseurl?>&m=index" method="post">
            <!--入职时间&nbsp;&nbsp;<input type="text" class="txt" name="begintime"
                                   id="begintime"   value="<?php echo $begintime?>" />
            合同到期时间&nbsp;&nbsp;<input type="text" class="txt" name="endtime"
                                     id="endtime"   value="<?php echo $endtime?>" />-->
            状态&nbsp;&nbsp;<select name="contract_status">
                <?=getSelect($contract_status,$status)?>
            </select>
            姓名<input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn">
        </form>
	</span> <input type="button" value="+添加<?=$this->name?>" class="btn"
                   onclick="location.href='<?=$this->baseurl?>&m=add'"
            />

        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0"
                   class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="30"></th>
                    <th width="30">编号</th>
                    <th width="60">姓名</th>
                    <th width="150">合同类型</th>
                    <th width="150">合同名称</th>
                    <th width="100">合同状态</th>
                    <th width="150">开始日期</th>
                    <th width="150">结束日期</th>
                    <th width="150">合同编号</th>
                    <th width="100">操作</th>
                </tr>

                <?php foreach($list as $key=>$r) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                                   class="checkbox" /></td>
                        <td><?=$key+1?></td>
                        <td><?=$r['truename']?></td>
                        <td><?=$r['contract_type']?></td>
                        <td><?=($r['title'])?></td>
                        <td><?=$r['contract_status']?></td>
                        <td><?=$r['begintime']?></td>
                        <td><?=$r['endtime']?></td>
                        <td><?=$r['contractno']?></td>
                        <td>
                            <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>&nbsp;&nbsp;
                            <a href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>"
                                onclick="return confirm('确定要删除吗？');">删除</a></td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="12"><input type="checkbox" name="chkall" id="chkall"
                                            onclick="checkall('delete[]')" class="checkbox" /><label
                            for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "
                                                                    class="btn" id="del"/> &nbsp;</td>
                </tr>
            </table>

            <div class="margintop"><div style="display: inline;float: left">共：<?=$count?>条</div>&nbsp;&nbsp;&nbsp;&nbsp;<?=$pages?></div>

        </form>

    </div>


<?php $this->load->view('admin/footer');?>