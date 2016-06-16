<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-教师端</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="static/admin_img/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                    font-weight:normal;

                }

                .stafftable input {
                    border:0px;
                    border-bottom:solid 1px #808080;
                    font-weight:bold;
                    padding-bottom:2px;
                    margin:4px;

                }
            </style>

                <a href="javascript:history.back();" style="display:" class="btn btn-success">返回</a>

            <br><br>
            <!-- 1 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    1.基本信息
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">

                        <tbody>
                        <tr>
                            <th width="20%">学生姓名</th>
                            <td width="30%">
                                <input value="<?php echo $student['name']?>"  type="text">
                            </td>
                            </td>
                            <th rowspan="2" width="20%">学生照片</th>
                            <td rowspan="2" width="30%">
                                <span id=""><a target="_blank" href="<?php echo $student['thumb']?>"><img id="lbl_avtor" class="img-thumbnail" src="<?php echo $student['thumb']?>"></a></span>
                            </td>
                        </tr>
                        <tr>
                            <th>班 级</th>
                            <td>
                                <input value="<?php echo $student['nickname']?>" type="text">

                            </td>
                        </tr>
                        <tr>
                            <th>评价老师</th>
                            <td>
                                <input value="<?php echo $value['truename']?>" type="text">

                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>评价日期</th>
                            <td>
                                <input name="" value="<?php echo $value['pubdate']?>"  type="text">

                            </td>
                            <th>评价学期</th>
                            <td>
                                <input name="" value="<?=config_item('semester')[$value['semester']]?>"  type="text">

                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>基础素质</th>
                            <td class="form-inline" colspan="3">
                                <textarea name="value[jcsz]" rows="2" cols="20" style="height:80px;width:600px;"><?php echo $value['jcsz']?></textarea>

                            </td>

                        </tr>
                        <tr>
                            <th>学科学习</th>
                            <td class="form-inline" colspan="3">
                                <textarea name="value[xkxx]" rows="2" cols="20" style="height:80px;width:600px;"><?php echo $value['xkxx']?></textarea>

                            </td>

                        </tr>
                        <tr>
                            <th>综合实践活动</th>
                            <td class="form-inline" colspan="3">
                                <textarea name="value[sjhd]" rows="2" cols="20" style="height:80px;width:600px;"><?php echo $value['sjhd']?></textarea>

                            </td>

                        </tr>
                        <tr>
                            <th>出勤情况</th>
                            <td class="form-inline" colspan="3">
                                <textarea name="value[cqqk]" rows="2" cols="20" style="height:80px;width:600px;"><?php echo $value['cqqk']?></textarea>

                            </td>

                        </tr>
                        <tr>
                            <th>获奖记录</th>
                            <td class="form-inline" colspan="3">
                                <textarea name="value[hjjl]" rows="2" cols="20" style="height:80px;width:600px;"><?php echo $value['hjjl']?></textarea>

                            </td>

                        </tr>
                        <tr>
                            <th>温馨提示</th>
                            <td class="form-inline" colspan="3">
                                <textarea name="value[wxts]" rows="2" cols="20" style="height:80px;width:600px;"><?php echo $value['wxts']?></textarea>

                            </td>

                        </tr>
                        <tr>
                            <th>教师评语</th>
                            <td class="form-inline" colspan="3">
                                <textarea name="value[jspy]" rows="2" cols="20" style="height:80px;width:600px;"><?php echo $value['jspy']?></textarea>
                            </td>

                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <input type="button" name="" value="编辑" onclick="location.href='<?=$this->baseurl?>&m=edit&id=<?=$id?>'" class="btn btn-primary">
                    <input type="submit" name="" value="返回" onclick="javascript:history.back();" class="btn btn-danger">
                </div>
            </div>
        </div>

</form>
</body></html>
<?php $this->load->view('teacher/footer');?>
