<?php $this->load->view('admin/header');?>

    <script>
        $(document).ready(function(){
            $("#add_task").click(function(){
                dialog = dialog_url("<?=$this->baseurl?>&m=test_add","新增考试名称",650,500);
            });

            $(".edit_task").click(function(){
                var id=$(this).attr("data-id");
                dialog = dialog_url("<?=$this->baseurl?>&m=test_edit&id="+id,"编辑考试名称",650,500);
            });
            $(".analysis_task").click(function(){
                dialog = dialog_url("<?=$this->baseurl?>&m=analysis_state","成绩分析中",300,200);
                var id=$(this).attr("data-id");
                $.ajax({
                    url: "<?=$this->baseurl?>&m=statistic_rank",   //后台处理程序
                    type: "post",         //数据发送方式
                    //dataType:"json",    //接受数据格式
                    data:{id:id},  //要传递的数据
                    success:function(data){
                        if(data){
                            location.href="<?=$this->baseurl?>&m=statistic_list";
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        //alert(errorThrown);
                    }
                });
            });


        });
    </script>

    <div class="mainbox">
        <input type="button" value="+添加考试" id="add_task" class="btn" />
        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="5"></th>
                    <th width="150">ID</th>
                    <th width="200">考试名称</th>
                    <th width="200">考试年级</th>
                    <th width="200">考试日期</th>
                    <th width="">操作</th>
                </tr>

                <?php foreach($list as $key=>$value) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$value['id']?>" class="checkbox" /></td>
                        <div id="list">
                            <td><?=$value['id']?></td>
                            <td><?=$value['test_name']?></td>
                            <td><?=$value['grade']?></td>
                            <td><?=$value['date']?></td>
                        </div>
                        <td>
                            <a href="javascript:void(0)" class="analysis_task" data-id="<?=$value['id']?>">分析</a>&nbsp;
                            <a href="<?=$this->baseurl?>&m=statistic_subject&id=<?=$value['id']?>">查看</a>&nbsp;
                            <a href="javascript:void(0)" class="edit_task" data-id="<?=$value['id']?>">编辑</a>&nbsp;
                            <a href="<?=$this->baseurl?>&m=test_delete&id=<?=$value['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="12">
                        <input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" />
                        <label for="chkall">全选/反选</label>&nbsp;
                        <input type="submit" value=" 删除 " class="btn" onclick="return confirm('确定要删除吗？');" /> &nbsp;
                    </td>
                </tr>
            </table>
            <tr><?php echo $pages; ?></tr>
        </form>
    </div>



<?php $this->load->view('admin/footer');?>