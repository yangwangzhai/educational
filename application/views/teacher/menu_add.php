<?php $this->load->view('teacher/header');?>

<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post">
        <input type="hidden"  name="value[pubdate]" value="<?php echo $value['pubdate']?>" />
        <input type="hidden"  name="value[meal]" value="<?php echo $value['meal']?>" />
		<table border="0" cellpadding="0" cellspacing="0" class="opt">
			<tr>
				<th>班级</th>
				<td>
                    <input type="text" class="txt"  value="<?php echo $value['nickname']?>" readonly />
                    <input type="hidden"  name="value[classid]" value="<?php echo $value['classid']?>"  /></td>
			</tr>
			
			<tr><th style="color:red;font-size:14px">注意：</th>
				<td style="color:red;font-size:14px">菜名与图片请务必成对出现</td>
			</tr>
			
			<tr>
				<th>菜名</th>
				<td><input name="value[content][]" value="" />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb0"
					value="" /><input type="button" value="选择.."
					onclick="upfile('thumb0')" class="btn" /></td>
				<td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="" /></td>
			</tr>	
			<tr>
				<th>菜名</th>
				<td><input name="value[content][]" value="" />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb1"
					value="" /><input type="button" value="选择.."
					onclick="upfile('thumb1')" class="btn" /></td>
				<td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="" /></td>
			</tr>
			<tr>
				<th>菜名</th>
				<td><input name="value[content][]" value=""  />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb2"
					value="" /><input type="button" value="选择.."
					onclick="upfile('thumb2')" class="btn" /></td>
				<td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="" /></td>
			</tr>
			<tr>
				<th>菜名</th>
				<td><input name="value[content][]" value="" />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb3"
					value="" /><input type="button" value="选择.."
					onclick="upfile('thumb3')" class="btn" /></td>
				<td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="" /></td>
			</tr>
			<tr>
				<th>菜名</th>
				<td><input name="value[content][]" value="" />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb4"
					value="" /><input type="button" value="选择.."
					onclick="upfile('thumb4')" class="btn" /></td>
				<td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="" /></td>
			</tr>	
			<tr>
				<th>菜名</th>
				<td><input name="value[content][]" value="" />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb5"
					value="" /><input type="button" value="选择.."
					onclick="upfile('thumb5')" class="btn" /></td>
				<td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="" /></td>
			</tr>	
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn"
					tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
					name="submit" value=" 取消 " class="btn"
					onclick="javascript:history.back();" /></td>
			</tr>
		</table>
	</form>

</div>

<?php $this->load->view('teacher/footer');?>