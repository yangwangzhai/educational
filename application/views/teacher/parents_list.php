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

                $.get("<?=$this->baseurl?>&m=update_status", { id: tid, status: mystatus },function(data){

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
            $("#import").click(function(){
                dialog= dialog_url("<?=$this->baseurl?>&m=import",'导入家长',468,440);
            });
        });

    </script>
    <div class="mainbox">

	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            关系&nbsp;&nbsp;<select name="relatives">
                <?=getSelect($relatives,$relatives_s)?>
            </select>
            配合度&nbsp;&nbsp;<select name="fit">
                <?=getSelect($fit,$fit_s)?>
            </select>
            经验&nbsp;&nbsp;<select name="experience">
                <?=getSelect($experience,$experience_s)?>
            </select>
            学历&nbsp;&nbsp;<select name="degrees">
                <?=getSelect($degrees,$degrees_s)?>
            </select>
            <input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn">
        </form>
	</span> <input type="button" value=" + 添加<?php echo $this->name?> " class="btn"
                   onclick="location.href='<?=$this->baseurl?>&m=add'" />
        <!--<input type="button" value=" 导出<?php echo $this->name?> " class="btn"
               onclick="location.href='<?=$this->baseurl?>&m=excelOut'" />-->
        <a href="uploads/excel/import/家长表.xls" class="btn" target="_blank">下载家长表</a>
        <input type="button"  id="import"  class="btn" value="导入家长" >
        <!--<input type="button" value=" 家长图表分析" class="btn"
               onclick="location.href='<?/*=$this->baseurl*/?>&m=statistic'" />-->
        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0"
                   class="datalist fixwidth" id="sortTable">
                <tr>

                    <th width="10"></th>
                    <th width="30">编号</th>
                    <th width="70">家长姓名</th>
                    <th width="70">学生姓名</th>
                    <th width="60">班级</th>
                    <th width="70">代步工具</th>
                    <th width="80">户籍所在地</th>
                    <th width="80">家庭环境</th>
                    <th width="80">学历</th>
                    <th width="60">配合度</th>
                    <th width="70">育儿经验</th>
                    <th width="70">参与次数</th>
                    <th width="100">联系电话</th>
                    <th width="80">备注</th>
                    <th width="120">操作</th>
                </tr>
                <?php foreach($list as $key=>$r) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                                   class="checkbox" /></td>
                        <td><?=$key+1?></td>
                        <td><?=$r['username']?></td>
                        <td><?=$r['studentname']?></td>
                        <td><?=$r['nickname']?></td>
                        <td><?=$r['transport']?></td>
                        <td><?=$r['place']?></td>
                        <td><?=$r['environment']?></td>
                        <td><?=$r['degrees']?></td>
                        <td><?=$r['fit']?></td>
                        <td><?=$r['experience']?></td>
                        <td><?=$r['activities']?>次</td>
                        <td><?=$r['tel']?></td>
                        <td><?=$r['content']?></td>
                        <td><a href="javascript:" title="点击更改状态" class="updatestatus <?php if($r['status']==0){echo 'red';} ?>" name="<?=$r['id']?>"><?=$this->status[$r['status']]?></a>&nbsp;&nbsp;<a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
                            <br><a href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>"
                                onclick="return confirm('确定要删除吗？');">删除</a></td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="16"><input type="checkbox" name="chkall" id="chkall"
                                            onclick="checkall('delete[]')" class="checkbox" /><label
                            for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "
                                                                    class="btn" id="del"/> &nbsp;</td>
                </tr>
            </table>

            <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

        </form>

    </div>
<?php $this->load->view('admin/footer');?>