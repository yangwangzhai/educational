<?php $this->load->view('admin/header');?>
<script>
$(document).ready(function(){	
	
    $("a").click(function(){        
    	parent.document.getElementById('studentid').value = $(this).attr('title'); 	
    	parent.document.getElementById('studentname').value = $(this).text();    	
		parent.studentdialog.remove();
    });
});
</script>

<ul class="citys">	
    <li>
	<?php foreach($list as $value):?>
		<a href="javascript:;" title="<?=$value['id']?>"><?=$value['name']?></a>
	<?php endforeach;?>
	</li>	
</ul>

<?php $this->load->view('admin/footer');?>