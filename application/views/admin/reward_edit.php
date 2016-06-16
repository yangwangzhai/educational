<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form id="form" action="<?=$this->baseurl?>&m=save" method="post">
    <input type="hidden" name="id" value="<?=$id?>">
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
                    1.奖励处罚
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">

                        <tbody><tr>

                            <th width="20%">名称<font color="red">*</font></th>
                            <td width="30%">
                                <input value="<?=$value['name']?>" name="value[name]" type="text"  class="form-control">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>

                        <tr>
                            <th>奖罚类型<font color="red">*</font></th>
                            <td>
                                <select name="value[reward_type]" class="form-control"><?=getSelect($reward_type,$value['reward_type'])?></select>
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>奖励单位</th>
                            <td>
                                <input type="text" name="value[unit]" value="<?=$value['unit']?>" class="form-control">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>奖罚级别<font color="red">*</font></th>
                            <td>
                                <input name="value[grade]" type="text" value="<?=$value['grade']?>" class="form-control">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>备注</th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[content]" rows="2" cols="20"  class="form-control" style="height:100px;width:600px;"><?=$value['content']?></textarea>

                            </td>

                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <input type="submit" name="" id="submit" value="更新"  class="btn btn-primary">
                    <input type="submit" name="" value="取消" onclick="javascript:history.back();" class="btn btn-danger">
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>