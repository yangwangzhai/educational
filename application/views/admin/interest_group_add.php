<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet"	href="static/js/kindeditor410/themes/default/default.css" />
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="static/plugin/layer-v2.1/layer.js"></script>
    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/js/common.js?1"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // 弹出选择学生
            $("#studentname").click(function(){
                var studentid=$("#studentid").val();
                var classname = ($("#classname").val());
                var classid = ($("#classid").val());
                layer.open({
                    type: 2,
                    title: '选择'+classname+'学生：',
                    fix: false,
                    shadeClose: true,
                    maxmin: true,
                    area: ['1000px', '500px'],
                    content: 'index.php?d=admin&c=interest_group&m=dialog&classid='+encodeURIComponent(classid)+'&studentid='+studentid
                });
                /*var studentid=$("#studentid").val();
                var classname = ($("#classname").val());
                var classid = ($("#classid").val());
                studentdialog = dialog_url('index.php?d=admin&c=interest_group&m=dialog&classid='+encodeURIComponent(classid)+'&studentid='+studentid,'选择'+classname+'学生：');*/
            });
        });
    </script>
</head>

<body>
<form id="form" action="<?=$this->baseurl?>&m=save" method="post">
    <div class="container-fluid">
        <div style=" margin:20px; font-size:13px;">
            <style>
                .img-thumbnail{ width:90px; height:100px; }

                .stafftable th {
                    text-align:right; vertical-align:central;
                }

                .table>thead>tr>th,
                .table>tbody>tr>th,
                .table>tfoot>tr>th,
                .table>thead>tr>td,
                .table>tbody>tr>td,
                .table>tfoot>tr>td {

                    vertical-align:middle;

                }
            </style>

            <!-- 1 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    1.<?=$this->name?>
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">

                        <tbody><tr>
                        <tr>
                            <th width="20%">小组名称<font color="red">*</font></th>
                            <td width="30%">
                                <input value="" name="value[title]" type="text"  class="form-control">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th width="20%">班级名称</th>
                            <td width="30%">
                                <input id="classname" value="" onclick="show_classname()" type="text"  class="form-control">
                                <input type="hidden" name="value[classid]" id="classid" value="">

                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th width="20%">选择学生<font color="red">*</font></th>
                            <td width="30%">
                                <div class="input-group" >
                                    <input name="" type="text" value="" id="studentname" class="form-control">
                                    <span class="input-group-addon">
                                            <a href="javascript:void(0)"><i class="glyphicon glyphicon-user"></i></a>
                                    </span>
                                </div>
                                <input id="studentid" name="value[student]" type="hidden" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>备注</th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[content]" rows="2" cols="20"  class="form-control" style="height:100px;width:600px;"></textarea>
                            </td>

                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <input type="submit" name="" id="submit" value="添加"  class="btn btn-primary">
                    <input type="submit" name="" value="取消" onclick="javascript:history.back();" class="btn btn-danger">
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>