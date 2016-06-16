<?php $this->load->view('teacher/header');?>
<style type="text/css">
    .styled-select {
        width: 258px;
        height: 28px;
        overflow: hidden;

    }
</style>
    <table class="opt">

        <tr>
            <th>教师整改内容</th>
            <td><textarea  name="content"
                           style="width: 700px; height: 100px;"></textarea></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td><input type="button" id="submit" value="提交" class="btn"
                       tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
                                                                name="button" value=" 取消 " class="btn"
                                                                onclick="javascript:parent.dialog.remove();" /></td>
        </tr>
    </table>
<script type="application/javascript">
    $(document).ready(function(){
        $("#submit").bind("click",function(){
            var content=$("textarea[name='content']").val();
            if(content=='')
            {
                alert('内容不能为空');
                $("textarea[name='content']").focus();
                return false;
            }

            $.ajax({
                url: "<?=$this->baseurl?>&m=active",   //后台处理程序
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{content:content,type:'<?php echo $type?>',id:<?php echo $id?>},  //要传递的数据
                success:function(data){
                    if(data==1)
                    {
                        //parent.dialog.remove();
                        parent.location.href='<?php echo $_SESSION ['url_forward']?>';
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown)
                {
                    alert(errorThrown);
                }
            });

        });
    });
</script>
<?php $this->load->view('teacher/footer');?>
