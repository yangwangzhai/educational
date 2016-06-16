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
    <style>
        button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            // 日期
            $('#pubdate').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            // 弹出选择学生
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

                        <tbody>
                        <tr>
                            <th width="20%">班级名称</th>
                            <td width="30%">
                                <input id="classname" onclick="show_classname()" value="" type="text"  class="form-control">
                                <input type="hidden"  id="classid" value="">

                            </td>
                            <th width="20%">学生姓名<font color="red">*</font></th>
                            <td width="30%">
                                <div class="input-group" >
                                    <input name="" type="text"  id="studentname" class="form-control">
                        <span class="input-group-addon">
                       <a href="javascript:void(0)" id="studentname"><i class="glyphicon glyphicon-user"></i>
                       </a>
                    </span>
                                </div>

                                <input type="hidden" name="value[studentid]" id="studentid" value="">

                            </td>
                        </tr>
                        <tr>
                            <th>时 间</th>
                            <td>
                                <input name="value[pubdate]" id="pubdate" value=""  type="text" class="form-control">

                            </td>
                            <th>学 期</th>
                            <td>
                                <select name="value[semester]" class="form-control">
                                    <?=getSelect(config_item('semester'))?>
                                </select>
                            </td>

                        </tr>
                        <tr>
                            <th>身 高</th>
                            <td>
                                <input name="value[height]" value="" placeholder="cm" type="text" class="form-control">

                            </td>
                            <th>体 重</th>
                            <td>
                                <input name="value[weight]" value=""  type="text" class="form-control" placeholder="kg">
                            </td>

                        </tr>
                        <tr>
                            <th>胸 围</th>
                            <td>
                                <input name="value[circumference]" value=""  type="text" class="form-control" placeholder="cm">
                            </td>
                            <th>肺活量</th>
                            <td>
                                <input name="value[pulmonary]" value=""  type="text" class="form-control" placeholder="ml">

                            </td>
                        </tr>
                        <tr>
                            <th>血 压</th>
                            <td>
                                <input name="value[blood]" value=""  type="text" class="form-control" placeholder="mmhg">
                            </td>
                            <th>握 力</th>
                            <td>
                                <input name="value[force]" value=""  type="text" class="form-control" placeholder="kg">

                            </td>
                        </tr>
                        <tr>
                            <th>脉 搏</th>
                            <td>
                                <input name="value[arterial]" value=""  type="text" class="form-control" placeholder="次/min">
                            </td>
                            <th>50米跑</th>
                            <td>
                                <input name="value[run]" value=""  type="text" class="form-control" placeholder="s">

                            </td>
                        </tr>
                        <tr>
                            <th>立定跳远</th>
                            <td>
                                <input name="value[jump]" value=""  type="text" class="form-control" placeholder="cm">
                            </td>
                            <th>仰卧起坐</th>
                            <td>
                                <input name="value[situps]" value=""  type="text" class="form-control" placeholder="次/分">

                            </td>
                        </tr>
                        <tr>
                            <th>视 力</th>
                            <td>
                                <input name="value[vision]" value=""  type="text" class="form-control">
                            </td>
                            <th>听 力</th>
                            <td>
                                <input name="value[situps]" value=""  type="text" class="form-control">

                            </td>
                        </tr>
                        <tr>
                            <th>色盲色弱</th>
                            <td>
                                <input name="value[blindness]" value=""  type="text" class="form-control">
                            </td>
                            <th>龋 齿</th>
                            <td>
                                <input name="value[caries]" value=""  type="text" class="form-control">

                            </td>
                        </tr>
                        <tr>
                            <th>疫苗接种情况</th>
                            <td>
                                <input name="value[vaccination]" value="" type="text" class="form-control">
                            </td>
                            <th>有无心脏疾病史</th>
                            <td>
                                <select name="value[heart]" class="form-control">
                                   <?=getSelect($heart)?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>健身与保健建议</th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[content]" rows="2" cols="20"  class="form-control" style="height:80px;"></textarea>

                            </td>

                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <input type="submit" name="" value="添加"  class="btn btn-primary">
                    <input type="submit" name="" value="取消" onclick="javascript:history.back();" class="btn btn-danger">
                </div>
            </div>
        </div>

</form>
</body></html>
<?php $this->load->view('admin/footer');?>
