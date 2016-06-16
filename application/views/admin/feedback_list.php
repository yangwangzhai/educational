<!DOCTYPE html>
<html>
<head>
    <title>家长反馈</title>
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
    <button type="button" class="btn btn-info" id="teach_activity_add">+家长反馈</button>
    <span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
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
            <th style="width: 130px;">ID</th>
            <th style="width: 130px;">进度</th>
            <th style="width: 130px;">反馈家长</th>
            <th style="width: 130px;">反馈对象</th>
            <th style="width: 130px;">反馈类型</th>
            <th style="width: 130px;">内容</th>
            <th style="width: 130px;">反馈时间</th>
            <th style="width: 130px;">反馈状态</th>
            <th style="width: 130px;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$r) :?>
            <tr>
                <td><?=$r['id']?></td>
                <td><a class="fancybox fancybox.iframe" href="<?=$this->baseurl?>&m=progress&id=<?=$r['id']?>">进度</a></td>
                <td><?=$r['pname']?></td>
                <td><?=$r['tname']?></td>
                <td><?=$r['feedback_type']?></td>
                <td><?=$r['content']?></td>
                <td><?=$r['feedback_date']?></td>
                <td>
                    <?php
                    switch($r['feedback_active'])
                    {
                        case 2:
                            echo "已提交/<a href='javascript:void(0)' data-id='$r[id]' class='ok'><font color='red'>待核实</font></a>";
                            break;
                        case 3:
                            echo "已核实/<a href='javascript:void(0)' data-id='$r[id]' class='rectify'><font color='red'>待整改</font></a>";
                            break;
                        case 4:
                            echo "已整改/<a href='javascript:void(0)' data-id='$r[id]' class='verify'><font color='red'>待审核</font></a>";
                            break;
                        case 5:
                            echo "已审核/<a href='javascript:void(0)' data-id='$r[id]' class='check'><font color='red'>待审阅</font></a>";
                            break;
                        case 6:
                            echo "已完成";
                            break;
                    }
                    ?>
                </td>
                <td>
                    <a href="javascript:" title="点击更改状态" class="updatestatus <?php if($r['status']==0){echo 'red';} ?>" name="<?=$r['id']?>"><?=$this->status[$r['status']]?></a>&nbsp;&nbsp;
                    <a href="<?=$this->baseurl?>&m=detail&id=<?=$r['id']?>">查看</a><br><a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>&nbsp;&nbsp;
                    <a href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a></td>
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
