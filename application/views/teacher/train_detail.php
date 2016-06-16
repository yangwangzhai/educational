<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-教师端</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="static/admin_img/bootstrap.min.css" rel="stylesheet" type="text/css" />



</head>
<body class="laydate_body">

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
            <a href="javascript:history.back();" class="btn btn-success">返回查询</a>
            <br> <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    1.课程基本信息
                </div>

                <div class="panel-body">


                    <table class="table table-condensed  stafftable">

                        <tbody><tr>
                            <!-- add pic -->


                            <th width="20%">培训名称<font color="red">*</font></th>
                            <td width="30%">

                                <input name="value[title]" type="text" value="<?php echo $value['title']?>" >


                            </td>



                            <th width="20%">培训组织者/部门</th>
                            <td width="30%">
                                <input name="value[organize]" type="text" value="<?php echo $value['organize']?>">

                            </td>
                        </tr>
                        <tr>

                            <th>培训时间从

                            </th>
                            <td>
                                <input name="value[begintime]" type="text" value="<?php echo $value['begintime']?>" >
                            </td>


                            <th>培训时间到</th>
                            <td>
                                <input name="value[endtime]" type="text" value="<?php echo $value['endtime']?>">
                            </td>

                        </tr>

                        <tr>
                            <!-- add pic -->
                            <th>课程时长(天)</th>
                            <td>
                                <input name="value[during]" type="text" value="<?php echo $value['during']?>">
                            </td>


                            <th>课程类别</th>
                            <td>
                                <input  type="text" value="<?=config_item('train_type')[$value['train_type']]?>">
                            </td>

                        </tr>
                        <tr>

                            <th>培训地点

                            </th>
                            <td>
                                <input name="value[place]" type="text" value="<?php echo $value['place']?>">

                            </td>


                            <th>培训讲师</th>
                            <td>

                                <input name="value[teacher]" type="text" value="<?php echo $value['teacher']?>">
                            </td>

                        </tr>
                        </tbody></table>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        2.培训学员信息
                    </div>

                    <div class="panel-body">


                        <table class="table table-condensed  stafftable">


                            <tbody><tr>
                                <!-- add pic -->
                                <th width="20%">培训费用

                                </th>
                                <td width="30%">
                                    <input name="value[fee]" type="text" value="<?php echo $value['fee']?>" >

                                </td>


                                <th width="20%">人数</th>
                                <td width="30%">
                                    <input name="value[number]" type="text" value="<?php echo $value['number']?>">

                                </td>

                            </tr>



                            <tr>
                                <!-- add pic -->
                                <th>面向部门

                                </th>
                                <td>
                                    <input name="value[dept]" type="text" value="<?php echo $value['dept']?>">

                                </td>


                                <th>受众</th>
                                <td>

                                    <input name="value[faceto]"  type="text" value="<?php echo $value['faceto']?>">

                                </td>

                            </tr>



                            <tr>
                                <!-- add pic -->
                                <th>课程简介

                                </th>
                                <td colspan="3">
                                    <textarea name="value[content]" rows="2" cols="20"  class="form-control" style="height:60px;width:600px;"><?php echo $value['content']?></textarea>

                                </td>

                            </tr>


                            <tr>

                                <th>学习目标

                                </th>
                                <td class="td_right" colspan="3">
                                    <textarea name="value[purpose]" rows="2" cols="20"  class="form-control" style="height:60px;width:600px;"><?php echo $value['purpose']?></textarea>

                                </td>

                            </tr>


                            </tbody></table>

                    </div>


                </div>


                <div>
                    <?php if($docs):?>
                        <table cellspacing="0" class="table" border="0" style="border-width:0px;border-collapse:collapse;">
                            <tbody><tr class="tr_title">
                                <th scope="col">ID</th><th scope="col">附件名称</th><th scope="col">上传时间</th><th scope="col">文件大小(kb)</th><th scope="col">操作</th>
                            </tr>
                            <?php foreach($docs as $item):?>
                                <tr class="tr_1">
                                    <td style="width:70px;"><?php echo $item['id']?></td>
                                    <td width="250"> <a href="<?php echo $item['src']?>" target="_blank"><?php echo $item['filename']?></a></td>
                                    <td style="width:150px;"><?php echo times($item['addtime'],0)?></td>
                                    <td style="width:100px;"><?php echo $item['size']?></td>
                                    <td width="150"> <a href="<?php echo $item['src']?>" target="_blank"> 下载</a></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody></table>
                    <?php endif;?>

                </div>


                <div class="panel panel-default">
                    <div class="panel-body text-center">

                        <input type="submit" name="" value="返回" onclick="javascript:history.back();" class="btn btn-danger">
                    </div>
                </div>



            </div>



        </div></div></form></body></html>