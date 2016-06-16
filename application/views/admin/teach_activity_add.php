<!DOCTYPE html>
<html>
<head>
    <title>课堂检查</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <script type="text/javascript" src="static/plugin/layer-v2.1/layer.js"></script>
    <script>
        $(document).ready(function(){
            // 日期
            $('#joinin').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            $("#member").click(function(){
                var group=$('#group').val();
                layer.open({
                    type: 2,
                    title: '选择教师',
                    fix: false,
                    shadeClose: true,
                    maxmin: true,
                    area: ['820px', '500px'],
                    content: 'index.php?d=admin&c=teacher&m=member_dialog&group='+group
                });
            });
            $("#group").on('click',function(){
                layer.open({
                    type: 2,
                    title: '选择教研组',
                    fix: false,
                    shadeClose: true,
                    maxmin: true,
                    area: ['600px', '400px'],
                    content: 'index.php?d=admin&c=teacher&m=group_dialog'
                });
            });
            $("#manager").on('click',function(){
               var group=$('#group').val();
                layer.open({
                    type: 2,
                    title: '选择主持人',
                    fix: false,
                    shadeClose: true,
                    maxmin: true,
                    area: ['600px', '400px'],
                    content: 'index.php?d=admin&c=teacher&m=manager_dialog&group='+group
                });
            });



        });
    </script>
    <style>
        .my_table td{text-align: center;}
        .my_table input{text-align: center;}
    </style>
</head>
<body>

<form method="post" action="<?=$this->baseurl?>&m=save_teach_activity">
    <input type="hidden" name="id" value="<?=$value['id']?>">
    <div class="row">
        <div class="center-block" style="width:850px;">
            <h3 class="text-center">教研活动记录表</h3>
            <table border="1" class="my_table">
                <tbody>
                    <tr>
                        <td style="margin:0; padding:0;width:80px;">时间</td>
                        <td><input  id="joinin" style="margin:0; padding:0; width: 350px;height:52px;border: none;" type="text" name="value[date]" value="<?=$value['date']?>"></td>
                        <td style="margin:0; padding:0;width:80px;">组别</td>
                        <td><input style="margin:0; padding:0; width: 350px;height:52px;border: none;" id="group" type="text" name="value[group_name]" value="<?=$value['group_name']?>"></td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;width:80px;">参加人员</td>
                        <td colspan="3"><input id="member" style="margin:0; padding:0; width: 780px;height:52px;border: none;" type="text" name="value[member]" value="<?=$value['member']?>"></td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;width:80px;">教研主题</td>
                        <td><input style="margin:0; padding:0; width: 350px;height:52px;border: none;" type="text" name="value[title]" value="<?=$value['title']?>"></td>
                        <td style="margin:0; padding:0;width:80px;">主持人</td>
                        <td><input style="margin:0; padding:0; width: 350px;height:52px;border: none;" id="manager" type="text" name="value[manager]" value="<?=$value['manager']?>"></td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;width:80px;height: 700px">内容记录</td>
                        <td colspan="3"><textarea style="margin:0; padding:0; width: 780px;height:700px;border: none;" name="value[content]"><?=$value['content']?></textarea></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="center-block" style="width:150px;">
            <button type="submit" class="btn btn-primary">提交保存</button>
        </div>
    </div>
</form>
</body>
</html>
