<!DOCTYPE html>
<html>
<head>
    <title>课堂检查</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            $('#teach_activity_add').on('click',function(){
                location.href="index.php?d=admin&c=teacher&m=teach_activity_add";
            });
        })
    </script>

</head>
<body>
<div style="margin-left: 10px;margin-top: 20px;">
    <button type="button" class="btn btn-info" id="teach_activity_add">添加教研活动</button>
    <hr style="margin-bottom: 5px;margin-top: 5px;"/>
</div>
<div style="margin-left: 10px;margin-bottom: 0px;">
    <table class="table table-hover">
        <thead>
        <tr>
            <th style="width: 130px;">ID</th>
            <th style="width: 130px;">组别</th>
            <th style="width: 130px;">主持人</th>
            <th style="width: 130px;">主题</th>
            <th style="width: 130px;">日期</th>
            <th style="width: 130px;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$value):?>
            <tr>
                <td><?=$value['id']?></td>
                <td><?=$value['group_name']?></td>
                <td><?=$value['manager']?></td>
                <td><?=$value['title']?></td>
                <td><?=$value['date']?></td>
                <td>
                    <a href="<?=$this->baseurl?>&m=teach_activity_edit&id=<?=$value['id']?>">修改</a>
                    <a href="<?=$this->baseurl?>&m=teach_activity_delete&id=<?=$value['id']?>">删除</a>
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
</body>
</html>
