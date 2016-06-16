<?php $this->load->view('admin/header');?>

<h3 class="marginbot">欢迎登录系统管理后台！</h3>

<ul class="memlist">
	<li><em>系统版本：</em>V1.0</li>
	<li><em>Apache版本：</em><?=apache_get_version()?></li>
	<li><em>PHP版本：</em><?=PHP_VERSION?></li>
	<li><em>MYSQL版本：</em><?=$this->db->platform().' '.$this->db->version();?></li>
	<li><em>版权所有：</em><?=PRODUCT_NAME?></li>
</ul>

<?php $this->load->view('admin/footer');?>