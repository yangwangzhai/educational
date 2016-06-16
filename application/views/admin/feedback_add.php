<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet"	href="static/js/kindeditor410/themes/default/default.css" />
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/js/common.js?1"></script>
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#feedback_date').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            // 弹出选择u家长
            $("#username").click(function(){
                parentsdialog=dialog_url('index.php?d=admin&c=parents&m=dialog','选择家长：');
            });
            //弹出选择教师
            $("#teachername").click(function(){
                teacherdialog=dialog_url('index.php?d=admin&c=teacher&m=dialog','选择教师：');
            });
        });
    </script>
</head>
<body>
<form action="<?=$this->baseurl?>&m=save" method="post">
<div class="container-fluid">
    <div style=" margin:20px; font-size:13px;">
        <style>
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
                1.家长反馈
            </div>

            <div class="panel-body">

                <table class="table table-condensed  stafftable">

                    <tbody><tr>
                        <th width="20%">家长姓名<font color="red">*</font></th>
                        <td width="30%">
                            <input type="text" class="form-control" id="username" value="" />
                            <input type="hidden" name="value[parentid]" id="uid" value="" />
                        </td>
                        <th width="20%">反馈类型<font color="red">*</font></th>
                        <td width="30%">
                            <select name="value[feedback_type]" class="form-control">
                                <?=getSelect(config_item('feedback_type'))?>
                            </select>
                        </td>
                        <th></th>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <th>反馈对象</th>
                        <td>
                            <input type="text" id="teachername" class="form-control" value="" />
                            <input type="hidden" name="value[teacherid]" id="teacherid"
                                   value="" />
                        </td>
                        <th>反馈时间<font color="red">*</font></th>
                        <td>
                            <input type="text" id="feedback_date" class="form-control" name="value[feedback_date]" value="<?=$feedback_date?>" />
                        </td>
                    </tr>
                    <tr>
                        <th>处理人<font color="red">*</font></th>
                        <td>
                            <input type="text" class="form-control" name="value[handle_id]" value="" />
                        </td>
                        <th>提交方式</th>
                        <td>
                            <select name="value[submit_type]" class="form-control">
                                <?=getSelect(config_item('submit_type'),4)?>
                            </select>                        </td>
                        <th></th>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <th>反馈内容</th>
                        <td class="td_right" colspan="3">
                            <textarea name="value[content]" rows="2" cols="20"  class="form-control" style="height:150px;width:80%;"></textarea>

                        </td>

                    </tr>
                    </tbody></table>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body text-center">

                <input type="submit" name="" id="submit" value="添加"  class="btn btn-primary">
                <input type="submit" name="" value="取消" onclick="parent.$.fancybox.close();" class="btn btn-danger">
            </div>
        </div>
    </div>
</div>
    </form>
</body></html>