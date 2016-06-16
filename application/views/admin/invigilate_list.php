<!DOCTYPE html>
<html>
<head>
    <title>监考列表</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div style="margin-left: 10px;margin-top: 20px;">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">添加监考任务</button>
    <hr style="margin-bottom: 5px;margin-top: 5px;"/>
</div>
<div style="margin-left: 10px;margin-bottom: 0px;">
    <table class="table table-hover">
        <thead>
        <tr>
            <th style="width: 130px;">ID</th>
            <th style="width: 130px;">考试名称</th>
            <th style="width: 130px;">学期</th>
            <th style="width: 130px;">日期</th>
            <th style="width: 130px;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$value):?>
            <tr>
                <td><?=$value['id']?></td>
                <td><?=$value['test_name']?></td>
                <td><?=$value['term']?></td>
                <td><?=$value['date']?></td>
                <td>
                    <a href="<?=$this->baseurl?>&m=invigilate_rule&id=<?=$value['id']?>">设置</a>
                    <a href="<?=$this->baseurl?>&m=invigilate_auto&id=<?=$value['id']?>">安排</a>
                    <a href="<?=$this->baseurl?>&m=invigilate_look&id=<?=$value['id']?>">查看</a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#Modal_edit<?=$value['id']?>">修改</a>
                    <a href="<?=$this->baseurl?>&m=delete_inligilate&id=<?=$value['id']?>">删除</a>
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

<!-- 添加监考任务的模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form role="form" method="post" action="<?=$this->baseurl?>&m=save_invigilate_list">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        添加监考任务
                    </h4>
                </div>
                <div class="modal-body" style="height: 250px;">
                    <div class="form-group">
                        <label for="name">考试名称</label>
                        <input type="text" class="form-control" id="name" name="test_name"
                               placeholder="请输入考试名称">
                    </div>
                    <div class="form-group">
                        <label for="name">学期</label>
                        <input type="text" class="form-control" id="name" name="term"
                               placeholder="请输入学期">
                    </div>
                    <div class="form-group">
                        <label for="name">日期</label>
                        <input type="text" class="form-control" id="name" name="date"
                               placeholder="请输入日期">
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
    <!-- 修改课堂检查的模态框（Modal） -->
    <div class="modal fade" id="Modal_edit<?=$value['id']?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="post" action="<?=$this->baseurl?>&m=save_invigilate_list&id=<?=$value['id']?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            修改监考任务
                        </h4>
                    </div>
                    <div class="modal-body" style="height: 250px;">
                        <div class="form-group">
                            <label for="name">年级</label>
                            <input type="text" class="form-control" id="name" name="test_name"
                                   value="<?=$value['test_name']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">学期</label>
                            <input type="text" class="form-control" id="name" name="term"
                                   value="<?=$value['term']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">日期</label>
                            <input type="text" class="form-control" id="name" name="date"
                                   value="<?=$value['date']?>">
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
<?php endforeach ?>

</body>
</html>
