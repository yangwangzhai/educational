<?php $this->load->view('admin/header');?>
<script>
$(document).ready(function(){	
    $("a").click(function(){
    	parent.document.getElementById('teachername').value = $(this).text();
        parent.teacherdialog.remove();
        /*$.ajax({
            url: "http://localhost/table/index.php?d=admin&c=timetable&m=rule",   //后台处理程序
            type: "post",         //数据发送方式
            dataType:"json",    //接受数据格式
            data:{teacherid:uid},  //要传递的数据
            success:function(data){
                alert(data);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });*/

    });

});
</script>

<ul class="citys">	
    <li>
	<?php foreach($list as $value):?>
		<a href="javascript:;" ><?=$value['teacher']?></a>
	<?php endforeach;?>
	</li>	
</ul>

<?php $this->load->view('admin/footer');?>