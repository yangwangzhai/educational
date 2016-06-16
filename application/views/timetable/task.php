<?php $this->load->view('admin/header');?>

    <script>
        $(document).ready(function(){
            $("#add_task").click(function(){
                dialog = dialog_url("<?=$this->baseurl?>&m=add","新增排课任务",550,350);
            });

            $(".edit_task").click(function(){
                var id=$(this).attr("data-id");
                dialog = dialog_url("<?=$this->baseurl?>&m=edit&id="+id,"编辑排课任务",550,350);
            });

            $(".copy_task").click(function(){
                var id=$(this).attr("data-id");
                dialog = dialog_url("<?=$this->baseurl?>&m=copy&id="+id,"编辑排课任务",550,350);
            });

            $("#download_user_guide").on("click",function(){
                location.href="uploads/file/template/排课系统使用手册.doc";
            });
        });
    </script>

    <div class="mainbox">
	<span style="float: right">
        <input type="submit" name="submit" id="download_user_guide" value="下载使用手册" class="btn">
	</span>
        <input type="button" value="+添加" id="add_task" class="btn" />
        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0" class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="5"></th>
                    <th width="150">ID</th>
                    <th width="200">任务名称</th>
                    <th width="200">学期</th>
                    <th width="200">一周上课天数</th>
                    <th width="200">一天上课节数</th>
                    <th width="">操作</th>
                </tr>

                <?php foreach($list as $key=>$value) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$value['id']?>" class="checkbox" /></td>
                        <div id="list">
                            <td><?=$value['id']?></td>
                            <td><?=$value['task_name']?></td>
                            <td><?=$value['task_term']?></td>
                            <td><?=$value['days_oneweek']?></td>
                            <td><?=$value['section_oneday']?></td>
                        </div>
                        <td>
                            <a href="<?=$this->baseurl?>&m=base_message&id=<?=$value['id']?>">排课</a>&nbsp;
                            <a href="javascript:void(0)" class="copy_task" data-id="<?=$value['id']?>">复制</a>&nbsp;
                            <a href="javascript:void(0)" class="edit_task" data-id="<?=$value['id']?>">编辑</a>&nbsp;
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