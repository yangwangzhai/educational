<?php $this->load->view('admin/header');?>

<link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
<script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
<style>
    button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
</style>
<script>
    $(document).ready(function(){
        // 日期
        $('#pubdate').Zebra_DatePicker({
            months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            days:['日', '一', '二', '三', '四', '五', '六'],
            lang_clear_date:'清除',
            show_select_today:'今天'
        });

        $("#studentname").click(function(){
            var classname = ($("#classname").val());
            var classid = ($("#classid").val());
            studentdialog = dialog_url('index.php?d=admin&c=student&m=dialog&classid='+encodeURIComponent(classid),'选择'+classname+'学生：');
        });

    });

</script>
</head>
<body>
<form action="<?=$this->baseurl?>&m=save" method="post">
    <div class="container-fluid">
        <div style=" margin:20px; font-size:13px;">
            <style>
                input, button, select, textarea {
                    font-family: inherit;
                    font-size: inherit;
                    line-height: inherit;
                }
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
                    1.学生作业
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">
                        <input type="hidden"  name="id" value="<?=$value['id']?>">
                        <tbody>
                        <tr>
                            <th width="20%">班级名称</th>
                            <td width="30%">
                                <input id="classname" onclick="show_classname()" value="<?=$value['classname']?>" type="text"  class="form-control">
                                <input type="hidden"  id="classid" value="<?=$value['classid']?>">

                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th width="20%">学生姓名<font color="red">*</font></th>
                            <td width="30%">
                                <input type="text" class="form-control" id="studentname"
                                       value="<?=$value['studentname']?>" />
                                <input type="hidden" name="value[studentid]" id="studentid"
                                       value="<?=$value['studentid']?>" />
                            </td>
                            <th ></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>学期 <font color="red">*</font></th>
                            <td>
                                <select name="value[semester]" id="type" class="form-control">
                                    <?=getSelect($semester,$value['semester'])?>
                                </select>
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>作业科目 <font color="red">*</font></th>
                            <td>
                                <select name="value[subject]" id="type" class="form-control">
                                    <?=getSelect($subject,$value['subject'])?>
                                </select>
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>作业成绩<font color="red">*</font></th>
                            <td>
                                <input name="value[score]" value="<?=$value['score']?>" type="number" class="form-control">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>批改时间<font color="red">*</font></th>
                            <td>
                                <input name="value[pubdate]" id="pubdate" value="<?=$value['pubdate']?>"  type="text" class="form-control">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <input type="submit" name="" id="submit" value="保存"  class="btn btn-primary">
                    <input type="submit" name="" value="取消" onclick="javascript:history.back();" class="btn btn-danger">
                </div>
            </div>
        </div>
    </div>
</form>
</body></html>