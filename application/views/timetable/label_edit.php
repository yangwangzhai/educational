<?php $this->load->view('admin/header');?>

    <script>
        function edit(){
            var num=$(".txt").length;
            $("#show input",window.parent.document).remove();//先清空所有标签
            //逐个标签添加回来
            for(var i=0;i<num;i++){
                $("#show",window.parent.document).append("<input class='middle_label_input' type='button' data-check='false' value="+$(".txt").eq(i).val()+">");
            }
            return true;

        }

        $(document).ready(function(){
            $(".delete_img").on('click',function(){
                var id=$(this).attr('data-id');
                var flag=confirm('确定要删除?');
                if(flag==true){
                    $(this).parent().parent().remove();
                    var num=$(".txt").length;
                    $("#show input",window.parent.document).remove();//先清空所有标签
                    //逐个标签添加回来
                    for(var i=0;i<num;i++){
                        $("#show",window.parent.document).append("<input class='middle_label_input' type='button' data-check='false' value="+$(".txt").eq(i).val()+">");
                    }
                    $.ajax({
                        type:'post',
                        dataType:"json",
                        url:'index.php?d=timetable&c=rule&m=delete_label',
                        data:{id:id},
                        success:function(data){
                            if(data!=''){
                                //alert(data);
                            }else{
                                alert('删除失败');
                            }
                        }
                    });
                }else{

                }

            })
        });



    </script>

    <div class="mainbox nomargin">
        <form action="<?=$this->baseurl?>&m=label_save_edit" method="post">
            <table border="0" cellpadding="0" cellspacing="0" class="opt">
                <?php if(!empty($label_list)){foreach($label_list as $key=>$value){?>
                    <tr>
                        <input type="hidden" name="value[<?= $key;?>][id]" id="my_hidden_id" value="<?= $value['id']?>">
                        <th width="60">标签名：</th>
                        <td><input style="width: 200px;" type="text" class="txt" name="value[<?= $key;?>][label_name]" value="<?= $value['label_name']?>"/></td>
                        <td><img class="delete_img" src="static/timetable/admin_img/delete.jpg" style="cursor: pointer;" data-id="<?=$value['id']?>"></td>
                    </tr>
                <?php }}else{?>
                    <tr>
                        <th width="60">标签名：</th>
                        <td><input style="width: 200px;" type="text" class="txt" name="value[label_name]" value=""/></td>
                    </tr>
                <?php }?>
                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <input type="submit" name="submit" value=" 保 存 " onclick="edit()" onsubmit="return edit()" class="btn" tabindex="3" /> &nbsp;&nbsp;&nbsp;
                        <input type="button" name="submit" value=" 取 消 " class="btn" onclick="javascript:history.back();"/>&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            </table>
        </form>
    </div>

<?php $this->load->view('admin/footer');?>