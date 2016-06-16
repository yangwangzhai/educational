<!DOCTYPE html>
<html>
<head>
    <title>教师测评</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <div style="margin-left: 10px;margin-top: 20px;">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">添加班级测评</button>
        <hr style="margin-bottom: 5px;margin-top: 5px;"/>
    </div>
    <div style="margin-left: 10px;margin-bottom: 0px;">
        <table class="table table-hover">
            <thead>
            <tr>
                <th style="width: 150px;">ID</th>
                <th style="width: 150px;">年级</th>
                <th style="width: 150px;">班级</th>
                <th style="width: 150px;">学期</th>
                <th style="width: 150px;">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $key=>$value):?>
                <tr>
                    <td><?=$value['id']?></td>
                    <td><?=$value['grade']?></td>
                    <td><?=$value['classname']?></td>
                    <td><?=$value['term']?></td>
                    <td>
                        <a href="<?=$this->baseurl?>&m=assessment_home_page&id=<?=$value['id']?>&grade=<?=$value['grade']?>&classname=<?=$value['classname']?>">测评</a>
                        <a href="<?=$this->baseurl?>&m=assessment_analysis&id=<?=$value['id']?>&grade=<?=$value['grade']?>&classname=<?=$value['classname']?>">统计</a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#Modal_edit<?=$value['id']?>">修改</a>
                        <a href="<?=$this->baseurl?>&m=delete_assessment&id=<?=$value['id']?>">删除</a>
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

    <!-- 添加班级测评的模态框（弹出窗口） -->
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
                        添加班级测评
                    </h4>
                </div>
                <div class="modal-body" style="height: 250px;">
                        <div class="form-group">
                            <label for="name">年级</label>
                            <input type="text" class="form-control" id="name" name="grade"
                                   placeholder="请输入年级">
                        </div>
                        <div class="form-group">
                            <label for="name">班级</label>
                            <input type="text" class="form-control" id="name" name="classname"
                                   placeholder="请输入班级">
                        </div>
                        <div class="form-group">
                            <label for="name">学期</label>
                            <input type="text" class="form-control" id="name" name="term"
                                   placeholder="请输入学期">
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
    <!-- 修改班级测评的模态框（弹出窗口） -->
    <div class="modal fade" id="Modal_edit<?=$value['id']?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="post" action="<?=$this->baseurl?>&m=save_assessment_list&id=<?=$value['id']?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            修改班级测评
                        </h4>
                    </div>
                    <div class="modal-body" style="height: 250px;">
                        <div class="form-group">
                            <label for="name">年级</label>
                            <input type="text" class="form-control" id="name" name="grade"
                                   value="<?=$value['grade']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">班级</label>
                            <input type="text" class="form-control" id="name" name="classname"
                                   value="<?=$value['classname']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">学期</label>
                            <input type="text" class="form-control" id="name" name="term"
                                   value="<?=$value['term']?>">
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
