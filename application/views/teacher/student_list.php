<?php $this->load->view('admin/header');?>
    <link rel="stylesheet" type="text/css" href="static/js/fancybox/jquery.fancybox.css" />
    <script type="text/javascript" src="static/js/fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript">
        $(function($)
        {
            $('.fancybox').fancybox({
                padding : 10,
                autoScale:true,
                /*width:768,*/
                openEffect: 'elastic'
            });
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
            $("#import").click(function(){
                dialog= dialog_url("<?=$this->baseurl?>&m=import",'导入幼儿',468,440);
            });
        });

    </script>
    <div class="mainbox">
	<span style="float: right">				
		<form action="<?=$this->baseurl?>&m=index" method="post">
            <input type="hidden" name="classid" id="classid" value="">
            姓名<input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn">
        </form>
	</span> <input type="button" value=" + 添加<?=$this->name?> " class="btn"
                   onclick="location.href='<?=$this->baseurl?>&m=add'" />
        <a href="uploads/excel/import/幼儿表.xls" class="btn" target="_blank">下载幼儿表</a>
        <input type="button"  id="import"  class="btn" value="导入幼儿" >
        <a href="<?=$this->baseurl?>&m=export" class="btn fancybox fancybox.iframe">Excel导出</a>
        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="0" cellspacing="0"
                   class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="10"></th>
                    <th width="30">编号</th>
                    <th width="80">头像</th>
                    <th width="60">姓名</th>
                    <th width="60">性别</th>
                    <th width="60">班级</th>
                    <th width="120">学籍号</th>
                    <th width="100">入园时间</th>
                    <th width="150">家庭住址</th>
                    <th width="120">住宅电话</th>
                    <th width="100">添加时间</th>
                    <th width="100">操作</th>
                </tr>
                <?php foreach($list as $key=>$r) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                                   class="checkbox" /></td>
                        <td><?=$key+1?></td>
                        <td><?php if($r['thumb']){?><img src="<?=$r['thumb']?>" width="40"><?php }?></td>
                        <td>
                            <a href="<?=$this->baseurl?>&m=detail&id=<?=$r['id']?>"><?=$r['name']?></a>
                        </td>
                        <td><?=$r['gender']?></td>
                        <td><?=$r['nickname']?></td>
                        <td><?=$r['number']?></td>
                        <td><?=$r['pubdate']?></td>
                        <td><?=$r['address']?></td>
                        <td><?=$r['tel']?></td>
                        <td><?=times($r['addtime'],0)?></td>
                        <td>
                            <a href="<?=$this->baseurl?>&m=detail&id=<?=$r['id']?>">详情</a>&nbsp;&nbsp;
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

            <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

        </form>

    </div>
    <div style="display:none">
        <div id="inline" style="width:768px; height:150px; overflow:auto">
            <table width="99%" border="0" cellpadding="0" cellspacing="0">
                <th width="80%"><input type="file" name="file_upload" id="file_upload" /></th>
                <th width="18"><a href="javascript:$('#file_upload').uploadify('settings', 'formData', {'upload':'upload'});$('#file_upload').uploadify('upload','*')">上传</a></th>
                </table>


        </div>
    </div>

<?php $this->load->view('admin/footer');?>