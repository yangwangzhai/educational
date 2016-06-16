<?php $this->load->view('admin/header');?>
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
        });

    </script>
    <div class="mainbox">

	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            <input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn">
        </form>
	</span> <input type="button" value=" + 添加<?php echo $this->name?> " class="btn"
                   onclick="location.href='<?=$this->baseurl?>&m=add'" />

        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0"
                   class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="30"></th>
                    <th align="left">食品名称</th>
                    <th align="left">日期</th>
                    <th align="left">价格（单价）元</th>
                    <th >数量</th>
                    <th width="160">合计</th>
                    <th width="160">备注</th>
                    <th width="160">负责人</th>
                    <th width="100">操作</th>
                </tr>

                <?php foreach($list as $key=>$r) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                                   class="checkbox" /></td>
                        <td><?=$r['title']?></td>
                        <td><?=$r['dodate']?></td>
                        <td><?=$r['price']?></td>
                        <td><?=$r['num']?></td>
                        <td><?=$r['total']?></td>
                        <td><?=$r['content']?></td>
                        <td><?=$r['username']?></td>
                        <td><a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>&nbsp;&nbsp;<a
                                href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>"
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