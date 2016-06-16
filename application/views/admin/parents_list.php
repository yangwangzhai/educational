<!DOCTYPE html>
<html>
<head>
    <title>家长信息</title>
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
            $('#parent_down').on('click',function(){
                location.href="uploads/excel/import/parent.xls";
            });
            $("#import").click(function(){
                dialog= dialog_url("<?=$this->baseurl?>&m=import",'导入家长',468,440);
            });
            $('#excel_down').on('click',function(){
                location.href="<?=$this->baseurl?>&m=export_dialog";
            });
        })
    </script>

</head>
<body>
<div style="margin-left: 10px;margin-top: 20px;">
    <button type="button" class="btn btn-info" id="teach_activity_add">+家长</button>
    <button type="button" class="btn btn-info" id="parent_down">下载家长表</button>
    <button type="button" class="btn btn-info" id="import">导入家长</button>
    <button type="button" class="btn btn-info" id="excel_down">Excel导出</button>
    <span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            关系&nbsp;&nbsp;<select name="relatives">
                <?=getSelect($relatives,$relatives_s)?>
            </select>
            配合度&nbsp;&nbsp;<select name="fit">
                <?=getSelect($fit,$fit_s)?>
            </select>
            经验&nbsp;&nbsp;<select name="experience">
                <?=getSelect($experience,$experience_s)?>
            </select>
            学历&nbsp;&nbsp;<select name="degrees">
                <?=getSelect($degrees,$degrees_s)?>
            </select>
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
            <th width="40">编号</th>
            <th width="70">家长姓名</th>
            <th width="70">学生姓名</th>
            <th width="80">班级</th>
            <th width="70">代步工具</th>
            <th width="80">户籍所在地</th>
            <th width="80">家庭环境</th>
            <th width="80">学历</th>
            <th width="60">配合度</th>
            <th width="70">参与次数</th>
            <th width="100">联系电话</th>
            <th width="80">备注</th>
            <th width="120">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$r) :?>
            <tr>
                <td><?=$key+1?></td>
                <td><?=$r['username']?></td>
                <td><?=$r['studentname']?></td>
                <td><?=$r['classname']?></td>
                <td><?=$r['transport']?></td>
                <td><?=$r['place']?></td>
                <td><?=$r['environment']?></td>
                <td><?=$r['degrees']?></td>
                <td><?=$r['fit']?></td>

                <td><?=$r['activities']?>次</td>
                <td><?=$r['tel']?></td>
                <td><?=$r['content']?></td>
                <td>
                    <a href="javascript:" title="点击更改状态" class="updatestatus <?php if($r['status']==0){echo 'red';} ?>" name="<?=$r['id']?>"><?=$this->status[$r['status']]?></a>&nbsp;&nbsp;<a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>
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
