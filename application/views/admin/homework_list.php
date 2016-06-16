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


            // 点击更改状态
            $(".updatestatus").click(function(){
                var tid = $(this).attr("name");
                if($(this).text() == "未审")
                {
                    $.get("<?=$this->baseurl?>&m=updatestatus", { id: tid, status: 1 },function(data){
                    });
                    $(this).text("已审");
                    $(this).removeClass("red");
                }
            });
        });

    </script>
    <div class="mainbox">

	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            <input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn">
        </form>
	</span> <input type="button" value=" + 添加<?=$this->name?> " class="btn"
                   onclick="location.href='<?=$this->baseurl?>&m=add'" />

        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="100%" border="0" cellpadding="3" cellspacing="0"
                   class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="30" ></th>
                    <th width="80">学生姓名</th>
                    <th width="100">学期</th>
                    <th width="100">班级</th>
                    <th width="100">作业科目</th>
                    <th width="80" align="center">分数</th>
                    <th width="150">批改时间</th>
                    <th width="80">操作</th>
                </tr>
                <?php foreach($list as $key=>$r) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                                   class="checkbox" /></td>
                        <td><?=$r['name'] ?></td>
                        <td ><?=$r['semester'] ?></td>
                        <td ><?=$r['classname'] ?></td>
                        <td ><?=$r['subject']?></td>
                        <td ><?=$r['score']?></td>
                        <td ><?=$r['pubdate']?></td>
                        <td>
                            <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>&nbsp;&nbsp;
                            <a href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>"
                               onclick="return confirm('确定要删除吗？');">删除</a></td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="11"><input type="checkbox" name="chkall" id="chkall"
                                            onclick="checkall('delete[]')" class="checkbox" /><label
                            for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "
                                                                    class="btn" onclick="return confirm('确定要删除吗？');" /> &nbsp;</td>
                </tr>
            </table>
            <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>
        </form>
    </div>
<?php $this->load->view('admin/footer');?>