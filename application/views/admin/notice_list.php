<!DOCTYPE html>
<html>
<head>
    <title>课堂检查</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <!--<link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>-->
    <!--<script>
        $(document).ready(function(){
            // 日期
            $('#joinin').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });

        })
    </script>-->
</head>
<body>
<div style="margin-left: 10px;margin-top: 20px;">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">添加公告信息</button>
    <hr style="margin-bottom: 5px;margin-top: 5px;"/>
</div>
<div style="margin-left: 10px;margin-bottom: 0px;">
    <table class="table table-hover">
        <thead>
        <tr>
            <th style="width: 130px;">ID</th>
            <th style="width: 130px;">日期</th>
            <th style="width: 130px;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$value):?>
            <tr>
                <td><?=$value['id']?></td>
                <td><?=$value['date']?></td>
                <td>                   
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#Modal_edit<?=$value['id']?>">修改</a>
                    <a href="<?=$this->baseurl?>&m=delete_classroom_check&id=<?=$value['id']?>">删除</a>
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

<!-- 添加公告信息的模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form role="form" method="post" action="<?=$this->baseurl?>&m=save_notice_list">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        添加公告信息
                    </h4>
                </div>
                <div class="modal-body" style="height: 350px;">
            
                    <div class="form-group">
                        <label for="name">日期</label>
                        <input type="text" class="form-control" id="joinin" name="value[date]"
                               placeholder="请输入日期">
                    </div>
                    <div class="form-group">
                        <label for="name">公告内容</label>
                        <textarea class="form-control" rows="10" name="value[content]" placeholder="请输入公告内容"></textarea>
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
            <form role="form" method="post" action="<?=$this->baseurl?>&m=save_notice_list&id=<?=$value['id']?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            修改公告信息
                        </h4>
                    </div>
                    <div class="modal-body" style="height: 350px;">
                        <div class="form-group">
                            <label for="name">日期</label>
                            <input type="text" class="form-control" id="name" name="value[date]"
                                   value="<?=$value['date']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">公告内容</label>
                            <textarea class="form-control" rows="10" name="value[content]" placeholder="请输入公告内容"><?=$value['content']?></textarea>
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
