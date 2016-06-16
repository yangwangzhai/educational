<?php $this->load->view('admin/header');?>
<style type="text/css">
    .styled-select {
        width: 258px;
        height: 28px;
        overflow: hidden;

    }
</style>
    <!--<input type="hidden" name="id" value="<?php /*echo $id*/?>"/>
    <input type="hidden" name="type" value="<?php /*echo $type*/?>"/>-->
    <table class="opt">
        <?php if($type=='ok' || $type=='cancel'):?>
        <tr>
            <th><?php if($type=='ok'):?>整改意见<?php else:?>理由:<?php endif;?></th>
            <td><textarea  name="content"
                          style="width: 700px; height: 100px;"></textarea></td>
        </tr>
        <?php elseif($type=='rectify'):?>
        <tr>
            <th>教师回复</th>
            <td><textarea  name="content"
                           style="width: 700px; height: 100px;"></textarea></td>
        </tr>
            <?php elseif($type=='verify'):?>
            <tr>
                <th>分数</th>
                <td><select name="score" class="styled-select">
                        <?=getSelect(config_item('feedback_score'))?>
                    </select></td>
            </tr>
            <tr>
                <th>审核评论</th>
                <td><textarea  name="content"
                               style="width: 700px; height: 100px;"></textarea></td>
            </tr>
            <?php elseif($type=='check'):?>
            <tr>
                <th>领导审阅</th>
                <td><textarea  name="content"
                               style="width: 700px; height: 100px;"></textarea></td>
            </tr>
        <?php endif;?>
        <tr>
            <th>&nbsp;</th>
            <td><input type="button" id="submit" value="提交" class="btn"
                       tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
                                                                name="button" value=" 取消 " class="btn"
                                                                onclick="javascript:parent.dialog.remove();" /></td>
        </tr>
    </table>
<script type="application/javascript">
    /*$(document).ready(function(){
        $("#submit").bind("click",function(){
            $("#form").submit();
            *//*parent.dialog.remove();*//*
        });
    });*/
    $(document).ready(function(){
        $("#submit").bind("click",function(){
            var content=$("textarea[name='content']").val();
            if(content=='')
            {
                alert('内容不能为空');
                $("textarea[name='content']").focus();
                return false;
            }
            var score=1;
            if('<?php echo $type?>'=='verify')
            {
                score=$("select[name='score']").val();
            }

            $.ajax({
                url: "<?=$this->baseurl?>&m=active",   //后台处理程序
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{content:content,score:score,type:'<?php echo $type?>',id:<?php echo $id?>},  //要传递的数据
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
<?php $this->load->view('admin/footer');?>
