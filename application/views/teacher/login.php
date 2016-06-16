<?php $this->load->view('teacher/header');?>

<div class="main_login">
	<h1><?=PRODUCT_NAME?>-教师端</h1>
	<div class="login">		
		<form action="index.php?d=teacher&c=common&m=check_login" method="post">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td width="65" align="left">用户名：</th>
				  <td colspan="2" align="left"><input name="username" type="text" class="text"
						id="username" tabindex="1" /></td>
			  </tr>
				<tr>
					<td align="left">密&nbsp; 码：</th>
				  <td colspan="2" align="left"><input name="password" type="password" class="text"
						id="password" tabindex="2" /></td>
			  </tr>
				<tr >
					<td align="left">验证码：</td>
					<td width="80" align="left"><input name="checkcode" type="text" class="text"
						style="width: 60px" id="checkcode" tabindex="3" /></td>
					<td  align="left"><img src='index.php?c=common&m=checkcode'
						name="code_img" id='code_img' title="点击更换"
						onclick='this.src=this.src+"&"+Math.random()' /></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td colspan="2" align="left"><input name="input" type="submit" value=" 登 录 "
						class="btnok" tabindex="4" /></td>
				</tr>
			</table>
		</form>
	</div>  
</div>
<p style="line-height:30px; text-align:center">建议使用IE8及以上版本的浏览器或谷歌浏览器! </p>
<p style="line-height:30px;; text-align:center">Copyright ©2015 <?=PRODUCT_NAME?> </p>
<?php $this->load->view('teacher/footer');?>