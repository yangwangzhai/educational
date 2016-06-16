<!DOCTYPE html>
<html>
<head>
    <title>奖罚管理</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            $('#teach_activity_add').on('click',function(){
                location.href="<?=$this->baseurl?>&m=add";
            });
        })
    </script>

</head>
<body>
<div style="margin-left: 10px;margin-top: 20px;">
    <button type="button" class="btn btn-info" id="teach_activity_add">+奖罚管理</button>
    <span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            奖罚类型<select name="type" id="type"><?=getSelect($reward_type, $type)?></select>&nbsp&nbsp
            <input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn-success">
        </form>
	</span>
    <hr style="margin-bottom: 5px;margin-top: 5px;"/>
</div>
<div style="margin-left: 10px;margin-bottom: 0px;">
    <table class="table table-hover">
        <thead>
        <tr>
            <th style="width: 130px;">奖罚名称</th>
            <th style="width: 130px;">奖罚类型</th>
            <th style="width: 130px;">奖励单位</th>
            <th style="width: 130px;">奖励级别</th>
            <th style="width: 130px;">备注</th>
            <th style="width: 130px;">添加时间</th>
            <th style="width: 130px;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$r) :?>
            <tr>
                <td><?=$r['name'] ?></td>
                <td ><?=$r['reward_type'] ?></td>
                <td ><?=$r['unit'] ?></td>
                <td ><?=$r['grade']?></td>
                <td ><?=$r['content']?></td>
                <td ><?=$r['addtime']?></td>
                <td>
                    <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
                    <a href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
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
