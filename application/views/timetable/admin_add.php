<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>
<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$id?>">
        <input type="hidden" name="value[catid]" value="<?=$value['catid']?>">
		<table class="opt">
        <th width="90">分组 </th>
				<td><select name="value[catid]" id="gender"><?=getSelect($this->config->item('user_category'), $value['catid'])?></select></td>
			</tr>		
			<tr>
				<th >用户名</th>
				<td><input name="value[username]" type="text" class="txt"
					value="<?=$value[username]?>"  /></td>
			</tr>
			<tr>
				<th>密码</th>
				<td><input name="value[password]" class="txt" type="password"
					id="thumb" value="" />不修改请留空</td>
			</tr>
			<tr>
				<th>姓名</th>
				<td><input name="value[truename]" class="txt" type="text"
					id="thumb" value="<?=$value[truename]?>" /></td>
			</tr>
			<tr>
				<th>手机</th>
				<td><input name="value[telephone]" class="txt" type="text"
					id="thumb" value="<?=$value[telephone]?>" /></td>
			</tr>
			<tr>
				<th>邮箱</th>
				<td><input name="value[email]" class="txt" type="text"
					id="thumb" value="<?=$value[email]?>" /></td>
			</tr>
			<tr>
				<th>备注</th>
				<td><input name="value[remarks]" class="txt" type="text"
					id="thumb" value="<?=$value[remarks]?>" /></td>
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

<?php $this->load->view('admin/footer');?>