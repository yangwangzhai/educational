<!DOCTYPE html>
<html>
<head>
    <title>教研组信息</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div style="margin-left: 10px;margin-top: 20px;">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">添加教研组</button>
    <hr style="margin-bottom: 5px;margin-top: 5px;"/>
</div>
<div style="margin-left: 10px;margin-bottom: 0px;">
    <table class="table table-hover">
        <thead>
        <tr>
            <th style="width: 150px;">组名</th>
            <th style="width: 150px;">组长</th>
            <th style="width: 150px;">人数</th>
            <th style="width: 150px;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$value):?>
            <tr>
                <td><?=$value['group']?></td>
                <td><?=$value['teach_supervisor']?></td>
                <td><?=$value['num']?></td>
                <td>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#Modal<?=$key?>">组员</a>
                    <a href="#">修改</a>
                    <a href="#">删除</a>
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

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form role="form" method="post" action="<?=$this->baseurl?>&m=save_assessment_list">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        添加教研组
                    </h4>
                </div>
                <div class="modal-body" style="height: 250px;">
                    <div class="form-group">
                        <label for="name">组名</label>
                        <input type="text" class="form-control" id="name" name="grade"
                               placeholder="请输入年级">
                    </div>
                    <div class="form-group">
                        <label for="name">组长</label>
                        <input type="text" class="form-control" id="name" name="classname"
                               placeholder="请输入班级">
                    </div>
                    <div class="form-group">
                        <label for="name">人数</label>
                        <input type="text" class="form-control" id="name" name="term"
                               placeholder="请输入人数">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="submit" class="btn btn-primary">
                        提交保存
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal -->
</div>

<?php foreach($list as $key=>$value):?>
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="Modal<?=$key?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="post" action="<?=$this->baseurl?>&m=save_assessment_list">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            <?=$value['group']?>组信息
                        </h4>
                    </div>
                    <div class="modal-body" style="height: 250px;">
                        <div class="form-group">
                            <tr>
                                <label for="name">组长</label>
                                <td><?=$value['teach_supervisor']?></td>
                            </tr>
                        </div>
                        <div class="form-group">
                        <tr>
                            <label for="name">组员</label>
                                <?php foreach($value['group_detail'] as $group_detail_key=>$group_detail_value):?>
                                <td><?=$group_detail_value['truename']?></td>
                                <?php endforeach;?>
                        </tr>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">关闭
                        </button>
                        <button type="submit" class="btn btn-primary">
                            提交保存
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal -->
    </div>
<?php endforeach;?>

</body>
</html>
