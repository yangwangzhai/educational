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
            $('#addtime').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            // 日期
            $('#begintime').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            // 日期
            $('#endtime').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            //弹出选择教师
            $("#teachername").click(function(){
                teacherdialog=dialog_url('index.php?d=admin&c=teacher&m=dialog','选择教师：');
            });
        });
    </script>
</head>
<body class="laydate_body">
<form action="<?=$this->baseurl?>&m=save" method="post">

    <div class="container-fluid">
        <div style=" margin:20px; font-size:13px;">
            <style>
                .contracttable th {
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

            <div>
                    <table class="table table-condensed contracttable">

                        <tbody><tr>



                            <th width="20%">合同类别/名称<font color="red">*</font></th>
                            <td width="30%">
                                <select name="value[contract_type]" class="form-control">
                                    <?=getSelect(config_item('contract_type'))?>
                                </select><br>

                                <input name="value[title]" type="text" class="form-control">
                            </td>

                            <th width="20%">姓名<font color="red">*</font>/员工号
                            </th>
                            <td width="30%">
                                <div class="input-group">
                                    <input  type="text" id="teachername" class="form-control" style=" background-color:#eee ">
             <span class="input-group-addon">
                <a href="javascript:void(0)" ><i class="glyphicon glyphicon-user"></i></a>
            </span>

                                </div>
                                <br>
                                <input name="value[uid]" id="teacherid" readonly type="text"  class="form-control" style=" background-color:#eee ">
                            </td>

                        </tr>


                        <tr>
                            <!-- add pic -->

                            <th>合同编号

                            </th>
                            <td>
                                <input name="value[contractno]" type="text"  class="form-control">
                            </td>

                            <th>经办人</th>
                            <td>
                                <input name="value[opusername]" type="text" value="管理员" class="form-control">
                            </td>

                        </tr>

                        <tr>
                            <!-- add pic -->
                            <th>合同生效开始时间 </th>
                            <td>
                                <input name="value[begintime]" value="<?=$value['begintime']?>" type="text" id="begintime" class="form-control">

                            </td>

                            <th>合同生效截止时间</th>
                            <td>

                                <input name="value[endtime]" value="<?=$value['endtime']?>" type="text" id="endtime" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <!-- add pic -->
                            <th>签订时间

                            </th>
                            <td>
                                <input name="value[addtime]" type="text" id="addtime"   value="<?php echo $value['addtime']?>" class="form-control">

                            </td>


                            <th>合同状态</th>
                            <td>
                                <table id="" border="0">
                                    <tbody><tr>
                                        <?php foreach($contract_status as $key=>$val):?>
                                            <td><input id="<?=$key?>" type="radio" name="value[contract_status]" value="<?php echo $key?>"><label for="<?=$key?>"><?php echo $val?></label></td>
                                        <?php endforeach;?>
                                    </tr>
                                    </tbody></table>

                            </td>

                        </tr>

                        <!--<tr>

                            <th>上传附件  </th>
                            <td colspan="2" class="form-inline">

                                <input type="file" name="" id="ctl00_ctl00_ContentPlaceHolder1_maincontent_FileUpload1" style="height:30px;width:500px;">
                            </td>
                            <td>
                                <input type="submit" name="" value="上传" id="ctl00_ctl00_ContentPlaceHolder1_maincontent_btn_upload" class="btn bg-maroon">

                            </td>

                        </tr>-->
                        </tbody></table>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <div class="pull-left">

                    </div>

                    <input type="submit" name="" value="添加合同"  class="btn btn-primary">
                    <input type="submit" name="" value="取消" onclick="javascript:history.back();" class="btn btn-danger">
                </div>
            </div>

        </div>
    </div>

</form>


