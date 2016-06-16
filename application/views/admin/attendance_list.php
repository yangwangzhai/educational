<?php $this->load->view('admin/header');?>
    <script type="text/javascript" src="static/js/My97DatePicker/WdatePicker.js"></script>
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
            $("#import").click(function(){
                dialog= dialog_url("<?=$this->baseurl?>&m=import",'导入考勤',468,440);
            });
        });

    </script>
    <div class="mainbox">

	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">

            <input type="text" class="Wdate" id="d413"
               name="pubdate" value="<?php echo $pubdate?>"   onfocus="WdatePicker({dateFmt:'yyyy-MM',minDate:'2008-02',maxDate:'2020-10'})"/>
            <input type="checkbox" name="reset" value="1" <?php if($reset==1) echo 'checked'?>/>不统计休息日
            姓名<input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn">
        </form>
	</span> <input type="button" value="打卡记录" class="btn"
                   onclick="location.href='<?=$this->baseurl?>&m=record'"
            />
        <input type="button"  id="import"  class="btn" value="导入考勤" >
        <input type="button" value="重新分析" class="btn"
               onclick="location.href='<?=$this->baseurl?>&m=refresh&date=<?php echo $pubdate?>'"/>
        <input type="button" value="考勤时间设置" class="btn"
               onclick="location.href='<?=$this->baseurl?>&m=set_month'"/>
        <!--<input type="button" value=" 图表分析" class="btn"
               onclick="location.href='<?/*=$this->baseurl*/?>&m=main&pubdate=<?/*=$pubdate*/?>'" />-->
        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0"
                   class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="10"></th>
                    <th width="30">编号</th>
                    <th width="80">部门</th>
                    <th width="100">姓名</th>
                    <th width="100">考勤正常</th>
                    <th width="150">迟到</th>
                    <th width="150">早退</th>
                    <th width="150">未打卡</th>
                    <th width="150">考勤合计</th>
                </tr>

                <?php foreach($list as $key=>$r) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                                   class="checkbox" /></td>
                        <td><?=$key+1?></td>
                        <td><?=$r['dept']?></td>
                        <td><a href="<?=$this->baseurl?>&m=detail&id=<?=$r['id']?>&pubdate=<?php echo $pubdate?>" title="详情"><?=$r['truename']?></a></td>
                        <td><?=$r['zhengch']?></td>
                        <td><?=$r['chidao']?></td>
                        <td><?=$r['zaotui']?></td>
                        <td><?=$r['weidaka']?></td>
                        <td>早退:<?=$r['zaotui']?>次; 未打卡:<?=$r['weidaka']?>次; 正常:<?=$r['zhengch']?>次; 迟到:<?=$r['chidao']?>次</td>
                <?php }?>
                <tr>
                    <td colspan="17"><input type="checkbox" name="chkall" id="chkall"
                                            onclick="checkall('delete[]')" class="checkbox" /><label
                            for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "
                                                                    class="btn" id="del"/> &nbsp;</td>
                </tr>
            </table>

            <div class="margintop"><div style="display: inline;float: left">共：<?=$count?>条</div>&nbsp;&nbsp;&nbsp;&nbsp;<?=$pages?></div>

        </form>

    </div>
    <script>
        KindEditor.ready(function(K) {
            var uploadbutton = K.uploadbutton({
                button : K('#btn_thumb')[0],
                fieldName : 'imgFile',
                url : './static/js/kindeditor410/php/upload_json.php?dir=file&folder=excel',
                afterUpload : function(data) {
                    if (data.error === 0) {
                        var url = K.formatUrl(data.url, 'relative');
                        location.href="<?=$this->baseurl?>&m=excelIn&filename="+url;
                    } else {
                        alert(data.message);
                    }
                },
                afterError : function(str) {
                    alert('自定义错误信息: ' + str);
                }
            });
            uploadbutton.fileBox.change(function(e) {
                uploadbutton.submit();
            });
            uploadbutton.fileBox.change(function(e) {
                uploadbutton.submit();
            });
        });

    </script>
<?php $this->load->view('admin/footer');?>