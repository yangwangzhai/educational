<?php $this->load->view('admin/header');?>
<script>
$(document).ready(function(){	
	
    $("a").click(function(){        
    	//parent.document.getElementById('classid').value = $(this).attr('title'); 	
    	parent.document.getElementById('grade').value = $(this).text();
		parent.dialog.remove();
    });
});
</script>

<ul class="citys">
	<?php foreach(config_item('grade') as $key=>$value):?>
				<li>
				<a href="javascript:;" title="<?=$key?>"><?=$value?></a>
				<?php endforeach;?>
				</li>
</ul>
<?php $this->load->view('admin/footer');?>
