<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-教师端</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>

    <link href="static/admin_img/bootstrap.min.css" rel="stylesheet" type="text/css" />

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
        });
    </script>
</head>
<body>
<form action="<?=$this->baseurl?>&m=save" method="post">
    <input type="hidden" name="id" value="<?php echo $id?>"/>
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

            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <div class="pull-left">
                        <a href="javascript:history.back();" style="display:" class="btn btn-success">返回</a>

                    </div>
                    <div class="pull-right">

                    </div>

                </div>
            </div>

            <!-- 1 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    1.基本信息
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">

                        <tbody>
                        <tr>
                            <th>学生姓名<font color="red">*</font></th>
                            <td>
                                <input  value="<?php echo $value['studentname']?>" readonly  type="text"  class="form-control">
                                <input type="hidden" name="value[studentid]" value="<?php echo $value['studentid']?>">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>时 间</th>
                            <td>
                                <input name="value[dodate]" id="pubdate" value="<?php echo $value['dodate']?>"  type="text" class="form-control">

                            </td>
                            <th>学 期</th>
                            <td>
                                <select name="value[semester]" class="form-control">
                                    <?=getSelect(config_item('semester'),$value['semester'])?>
                                </select>
                            </td>

                        </tr>
                        <tr>
                            <th>体 重</th>
                            <td>
                                <input name="value[weight]" value="<?php echo $value['weight']?>"  type="text" class="form-control" placeholder="kg">
                            </td>
                            <th>身 高</th>
                            <td>
                                <input name="value[height]" value="<?php echo $value['height']?>" placeholder="cm" type="text" class="form-control">

                            </td>
                        </tr>
                        <tr>
                            <th>牙 数</th>
                            <td>
                                <input name="value[teeth]" value="<?php echo $value['teeth']?>"  type="text" class="form-control">
                            </td>
                            <th>蛀牙数</th>
                            <td>
                                <input name="value[decay]" value="<?php echo $value['decay']?>"  type="text" class="form-control">

                            </td>
                        </tr>
                        <tr>
                            <th>听 力</th>
                            <td>
                                <input name="value[listening]" value="<?php echo $value['listening']?>"  type="text" class="form-control">
                            </td>
                            <th>色盲色弱</th>
                            <td>
                                <input name="value[blindness]" value="<?php echo $value['blindness']?>"  type="text" class="form-control">

                            </td>
                        </tr>
                        <tr>
                            <th>体 温</th>
                            <td>
                                <input name="value[temperature]" value="<?php echo $value['temperature']?>" placeholder="℃" type="text" class="form-control">
                            </td>
                            <th>心 律</th>
                            <td>
                                <input name="value[heart]" value="<?php echo $value['heart']?>" placeholder="bpm" type="text" class="form-control">

                            </td>
                        </tr>
                        <tr>
                            <th>备 注</th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[content]" rows="2" cols="20"  class="form-control" style="height:80px;"><?php echo $value['content']?></textarea>

                            </td>

                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <input type="submit" name="" value="更新"  class="btn btn-primary">
                    <input type="submit" name="" value="取消" onclick="javascript:history.back();" class="btn btn-danger">
                </div>
            </div>
        </div>

</form>
</body></html>
<?php $this->load->view('admin/footer');?>
