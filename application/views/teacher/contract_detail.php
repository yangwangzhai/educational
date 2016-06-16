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
            <div>
                <table class="table table-condensed  stafftable">

                    <tbody><tr>



                        <th width="20%">合同类别/名称<font color="red">*</font></th>
                        <td width="30%">
                            <input value="<?=config_item('contract_type')[$value['contract_type']]?>" type="text">
                            <br>

                            <input name="value[title]" value="<?php echo $value['title']?>" type="text">
                        </td>

                        <th width="20%">姓名<font color="red">*</font>/员工号
                        </th>
                        <td width="30%">

                                <input  type="text" value="<?php echo $this->teacher['truename']?>" >
                            <br>
                            <input name="value[uid]" value="<?php echo $value['uid']?>"  type="text">
                        </td>

                    </tr>

                    <tr>
                        <!-- add pic -->

                        <th>合同编号

                        </th>
                        <td>
                            <input name="value[contractno]" type="text" value="<?php echo $value['contractno']?>">
                        </td>

                        <th>经办人</th>
                        <td>
                            <input name="value[opusername]" type="text" value="<?php echo $value['opusername']?>">
                        </td>

                    </tr>

                    <tr>
                        <!-- add pic -->
                        <th>合同生效开始时间 </th>
                        <td>
                            <input name="value[begintime]" value="<?php echo $value['begintime']?>" type="text">

                        </td>

                        <th>合同生效截止时间</th>
                        <td>

                            <input name="value[endtime]" value="<?php echo $value['endtime']?>" type="text">
                        </td>
                    </tr>
                    <tr>
                        <!-- add pic -->
                        <th>签订时间

                        </th>
                        <td>
                            <input name="value[addtime]" type="text" id="addtime"   value="<?php echo $value['addtime']?>">

                        </td>


                        <th>合同状态</th>
                        <td>
                            <table id="" border="0">
                                <tbody><tr>
                                    <?php foreach($contract_status as $key=>$val):?>
                                        <td><input id="<?=$key?>" type="radio" name="value[contract_status]" value="<?php echo $key?>" <?php if($value['contract_status']==$key)echo 'checked'?>><label for="<?=$key?>"><?php echo $val?></label></td>
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
                    <input type="submit" name="" value="返回" onclick="javascript:history.back();" class="btn btn-danger">
                </div>
            </div>

        </div>
    </div>

</form>


