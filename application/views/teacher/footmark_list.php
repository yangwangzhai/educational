<?php $this->load->view('teacher/header');?>
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
	
});

</script>
<div class="mainbox">

	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            学期<select name="semester">
                <?=getSelect(config_item('semester'))?>
            </select>
			 <input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn">
		</form>
	</span> <input type="button" value=" + 添加<?=$this->name?> " class="btn"
		onclick="location.href='<?=$this->baseurl?>&m=add'" />
       
		
        <form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth" id="sortTable">
			<tr>
				<th width="10"></th>
                <th width="30">编号</th>
				<th width="60">学生</th>
                <th width="100">班级</th>
				<th width="100">学期</th>
				<th width="100">评价老师</th>
				<th width="100">评价日期</th>
				<th width="100">操作</th>
			</tr>

    <?php foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
					class="checkbox" /></td>
                <td><?=$key+1?></td>
				<td><a href="<?=$this->baseurl?>&m=detail&id=<?=$r['id']?>"><?=$r['name']?></a></td>
                <td><?=setClassname($r['classname'])?></td>
				<td><?=$r['semester']?></td>
				<td><?=$r['truename']?></td>
				<td><?=$r['pubdate']?></td>
				<td><a href="javascript:" title="点击更改状态" class="updatestatus <?php if($r['status']==0){echo 'red';} ?>" name="<?=$r['id']?>"><?=$this->status[$r['status']]?></a>&nbsp;&nbsp;
                    <a href="<?=$this->baseurl?>&m=detail&id=<?=$r['id']?>">详情</a><br>
                    <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>&nbsp;&nbsp;
                    <a href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>"
					onclick="return confirm('确定要删除吗？');">删除</a></td>
			</tr>
    <?php }?>
            <tr>
                <td colspan="12"><input type="checkbox" name="chkall" id="chkall"
                                        onclick="checkall('delete[]')" class="checkbox" /><label
                        for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "
                                                                class="btn" id="del" /> &nbsp;</td>
            </tr>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('teacher/footer');?>