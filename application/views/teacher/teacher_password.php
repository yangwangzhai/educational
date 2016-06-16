<?php $this->load->view('teacher/header');?>

<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=password_save" method="post">
		<table width="99%" border="0" cellpadding="3" cellspacing="0" class="opt">
            <tr>
                <td>

                </td>
                <td><strong>系统初始化密码为：<font color="red">123456</font>，如下修改，请在这里操作</strong></td>
            </tr>
		<tr>
			<td>姓名</td>
			<td><?=$this->teacher['truename']?></td>
		</tr>
		<tr>
				<td width="90">新密码*</td>
				<td><input type="password" class="txt" name="value[password]" 
					value=""  /></td>
			</tr>			
			<tr>
				<td width="90">确认密码*</td>				
				<td><input type="password" class="txt" name="value[password2]"
					value="" /></td>
			</tr>			
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn"
					tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
					name="submit" value=" 取消 " class="btn"
					onclick="javascript:history.back();" /></td>
			</tr>
		</table>
	</form>

</div>

<?php $this->load->view('teacher/footer');?>