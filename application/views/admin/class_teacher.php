<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

</head>
<body class="laydate_body">

<div class="container-fluid">
    <div style=" margin:20px; font-size:13px;">
        <style>
            .tablecourse th {
                text-align:left; vertical-align:central;
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
            <div class="panel-heading">
                <?=$class['alias']?>(<?=$class['nickname']?>)教师列表
            </div>

            <div class="panel-body">

                <div class="pull-left">
                   班主任：
                </div>
                <table class="table table-condensed tablecourse">

                    <tbody>

                    <tr>
                        <?php foreach($manage_teacher as $k=>$item):?>
                            <?php if($k%3==0 AND $k>0) echo '<tr>'?>
                            <th>
                                <?=$item['truename']?>(<?=$item['course']?>)
                            </th>
                            <td>

                            </td>
                        <?php endforeach;?>
                    </tr>

                    </tbody></table>

                <div class="pull-left">
                    任教老师：
                </div>
                <table class="table table-condensed tablecourse">

                    <tbody>

                    <tr>
                        <?php foreach($teach_teacher as $k=>$item):?>
                            <?php if($k%3==0 AND $k>0) echo '<tr>'?>
                            <th>
                                <?=$item['truename']?>(<?=$item['course']?>)
                            </th>
                            <td>

                            </td>
                        <?php endforeach;?>
                    </tr>

                    </tbody></table>
            </div>

            <div class="panel panel-default">
                <div class="panel-body text-center">


                    <input type="button" name="" value="关闭" onclick="parent.$.fancybox.close();" class="btn btn-danger">
                </div>
            </div>
        </div>
    </div></div></body></html>