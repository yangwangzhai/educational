<!DOCTYPE html>
<html>
<head>
    <title>教研计划、总结</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            $('#teach_activity_resource_add').on('click',function(){
                location.href="index.php?d=admin&c=teacher&m=teach_activity_resource_add";
            });
        })
    </script>

</head>
<body>
<div style="margin-left: 10px;margin-top: 20px;">
    <button type="button" class="btn btn-info" id="teach_activity_resource_add">添加计划、总结</button>
    <hr style="margin-bottom: 5px;margin-top: 5px;"/>
</div>
<div style="margin-left: 10px;margin-bottom: 0px;">
    <table class="table table-hover">
        <thead>
        <tr>
            <th style="width: 130px;">ID</th>
            <th style="width: 130px;">发布人</th>
            <th style="width: 130px;">主题</th>
            <th style="width: 130px;">发布日期</th>
            <th style="width: 130px;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$value):?>
            <tr>
                <td><?=$value['id']?></td>
                <td><?=$value['teacher']?></td>
                <td><?=$value['title']?></td>
                <td><?=$value['addtime']?></td>
                <td>
                    <a href="#" data-toggle="modal" data-target="#Modal<?=$key?>">下载附件</a>
                    <a href="<?=$this->baseurl?>&m=teach_activity_resource_edit&id=<?=$value['id']?>">修改</a>
                    <a href="<?=$this->baseurl?>&m=teach_activity_resource_delete&id=<?=$value['id']?>">删除</a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<div style="margin-left: 10px;margin-top: -15px;">
    <hr style="margin-bottom: 0px;margin-top:0px;"/>
</div>
<div style="margin-left: 10px;margin-top: 10px;">
    <tr><?php echo $pages; ?></tr>
</div>

<?php foreach($list as $key=>$value):?>
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="Modal<?=$key?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        下载附件
                    </h4>
                </div>
                <div class="modal-body" style="height: 250px;">
                    <div class="form-group">
                        <ul class="list-group">
                            <?php foreach($resource_list[$key] as $kk=>$vv):?>
                            <li class="list-group-item">
                                <span class="badge" style="background-color: #bce8f1;width: 50px;"><a style="font-size: medium;" href="<?=$vv['savename'];?>">下载</a></span>
                                <?=$vv['filename'];?>
                            </li>
                            <?php endforeach?>
                        </ul>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
<?php endforeach;?>


</body>
</html>
