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
			
			$.get("<?=$this->baseurl?>&m=updatestatus", { id: tid, status: mystatus },function(data){
			
			});
	});
	
});

</script>
<div class="mainbox">

	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            <input type="text" name="keywords" value=""> <input type="submit"
				name="submit" value=" 搜索 " class="btn">
		</form>
	</span>
	
	后台操作日志
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth" id="sortTable">
			<tr>
				<th width="60">管理员</th>
				<th >操作内容</th>				
                <th width="120">ip地址</th>             
                <th width="150">浏览器</th>
                <th width="150">操作时间</th>                
                        
			</tr>
    <?php foreach($list as $key=>$r) {?>
    <tr class="sortTr">    			
				<td><?=$r['adminid']?></td>				
                <td><?=$r['title']?></td>
                <td><?=$r['ip']?></td>
                <td><?=$r['browser']?></td>
				<td><?=times($r['addtime'],1)?></td>				
			</tr>
    <?php }?>
    
		</table>

		<div class="margintop"><div style="display: inline;float: left">共：<?=$count?>条</div>&nbsp;&nbsp;&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>