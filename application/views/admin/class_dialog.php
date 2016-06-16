<?php $this->load->view('admin/header');?>
<script>
$(document).ready(function(){	
	
    $("a").click(function(){        
    	parent.document.getElementById('classid').value = $(this).attr('title');
    	parent.document.getElementById('classname').value = $(this).text();
		parent.dialog.remove();
    });
});
</script>

<ul class="citys">
	<?php foreach($classname as $key=>$value):
				echo ' <li><strong>第'.($key).'届</strong></li><li>';
						foreach($value as $item):
				?>
				<a href="javascript:;" title="<?=$item['id']?>"><?=$item['classname']?></a>
				<?php endforeach;?>
				</li>
	<?php endforeach;?>
</ul>
<?php $this->load->view('admin/footer');?>
