<?php $this->load->view('teacher/header');?>

<h3 class="marginbot">点击选择班级：</h3>
<?php foreach($teach_class as $value):?>
	<a href="<?=$this->baseurl?>&m=choose&classname=<?=$value?>">
	<?=setClassname($value)?></a>
	&nbsp;&nbsp;&nbsp;
<?php endforeach;?>

<?php $this->load->view('teacher/footer');?>