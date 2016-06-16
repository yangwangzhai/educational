<!DOCTYPE html>
<html>
<head>
    <title>体质健康</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="static/js/fancybox/jquery.fancybox.css" />
    <script type="text/javascript" src="static/js/fancybox/jquery.fancybox.js"></script>
    <link rel="stylesheet"	href="static/js/kindeditor410/themes/default/default.css" />
    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <script type="text/javascript" src="static/js/common.js?v=1"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            $('#teach_activity_add').on('click',function(){
                location.href="<?=$this->baseurl?>&m=add";
            });
            $('#physical_down').on('click',function(){
                location.href="uploads/excel/import/physical.xls";
            });
            $("#import").click(function(){
                dialog= dialog_url("<?=$this->baseurl?>&m=import",'导入学生体质',468,440);
            });
        })
    </script>

</head>
<body>
<div style="margin-left: 10px;margin-top: 20px;">
    <button type="button" class="btn btn-info" id="teach_activity_add">+奖罚管理</button>
    <button type="button" class="btn btn-info" id="physical_down">下载体质数据表</button>
    <button type="button" class="btn btn-info" id="import">导入学生体质</button>
    <span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            学期<select name="semester">
                <?=getSelect($semester,$semester_s)?>
            </select>
            <input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn-success">
        </form>
	</span>>
    <hr style="margin-bottom: 5px;margin-top: 5px;"/>
</div>
<div style="margin-left: 10px;margin-bottom: 0px;">
    <table class="table table-hover">
        <thead>
        <tr>
            <th width="40">编号</th>
            <th width="80">学生姓名</th>
            <th width="90">学期</th>
            <th width="80">班级</th>
            <th width="40">年龄</th>
            <th width="40">性别</th>
            <th width="40">身高</th>
            <th width="40">体重</th>
            <th width="60">视力</th>
            <th width="100">疫苗接种情况</th>
            <th width="80">有无心脏疾病史</th>
            <th width="100">健身与保健建议</th>
            <th width="110">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$r) :?>
            <tr>
                <td><?=$key+1?></td>
                <td><a href="<?=$this->baseurl?>&m=detail&id=<?=$r['id']?>"><?=$r['name']?></a></td>
                <td><?=$r['semester']?></td>
                <td ><?=$r['classname']?></td>
                <td><?=$r['age']?></td>
                <td ><?=$r['gender']?></td>
                <td><?=$r['height']?></td>
                <td><?=$r['weight']?></td>
                <td><?=$r['vision']?></td>
                <td><?=$r['vaccination']?></td>
                <td><?=$r['heart']?></td>
                <td><?=$r['content']?></td>
                <td>
                    <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>&nbsp;
                    <a href="<?=$this->baseurl?>&m=detail&id=<?=$r['id']?>">详情</a>&nbsp;
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
