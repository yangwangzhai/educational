<?php $this->load->view('admin/header');?>

    <script>
        $(document).ready(function(){
            $("#add_marking").click(function(){
                dialog = dialog_url("<?=$this->baseurl?>&m=add","新增试卷",550,350);
            });

            $(".edit_marking").click(function(){
                var id=$(this).attr("data-id");
                dialog = dialog_url("<?=$this->baseurl?>&m=edit&id="+id,"编辑排课任务",550,350);
            });

            $(".marking_action").click(function(){
                var id=$(this).attr("data-id");
                dialog = dialog_url("<?=$this->baseurl?>&m=marking_action&id="+id,"批改试卷",1200,650);
            });


        });
    </script>

    <div class="mainbox">
        <input type="button" value="+添加试卷" id="add_marking" class="btn" />
        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="5"></th>
                    <th width="150">ID</th>
                    <th width="200">班级</th>
                    <th width="200">学生姓名</th>
                    <th width="200">分数</th>
                    <th width="200">状态</th>
                    <th width="">操作</th>
                </tr>

                <?php foreach($list as $key=>$value) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$value['id']?>" class="checkbox" /></td>
                        <div id="list">
                            <td><?=$value['id']?></td>
                            <td><?=$value['classname']?></td>
                            <td><?=$value['testname']?></td>
                            <td id="testscore<?=$value['id']?>"><?=$value['testscore']?></td>
                            <td><?=$value['status']?></td>
                        </div>
                        <td>
                            <a href="javascript:void(0)" class="marking_action" data-id="<?=$value['id']?>">阅卷</a>&nbsp;
                            <a href="javascript:void(0)" class="edit_marking" data-id="<?=$value['id']?>">编辑</a>&nbsp;
                            <a href="<?=$this->baseurl?>&m=delete&id=<?=$value['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
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