<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-教师端</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet"	href="static/js/kindeditor410/themes/default/default.css" />
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <link href="static/admin_img/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/js/common.js?1"></script>

</head>
<body>
<form action="<?=$this->baseurl?>&m=save" method="post" enctype="multipart/form-data">
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
                    1.成长记录
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">

                        <tbody>
                        <tr>
                            <th width="20%">学生姓名 <font color="red">*</font></th>
                            <td width="30%">
                                <input type="text" class="form-control"
                                       value="<?php echo $value['studentname']?>" readonly />
                                <input type="hidden" name="value[studentid]"  value="<?php echo $value['studentid']?>">
                            </td>
                            <th></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>发布人</th>
                            <td>
                                <input type="text" class="form-control"
                                       value="<?php echo $value['truename']?>" />
                            </td>
                            <th></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>图片内容</th>
                            <td>
                                <table border="0" style="border-width:0px;width:100%;">
                                    <tbody><tr>
                                        <td>
                                            <input name="value[thumb]" class="form-control" type="text" id="thumb"
                                                   value="<?php echo $value['thumb']?>"  />
                                        </td>
                                        <td>
                                            <input type="button" value="选择.."
                                                   id="btn_thumb"/>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>文字内容</th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[title]" rows="2" cols="20"
                                          class="form-control" style="height:150px;width:80%;"><?php echo $value['title']?></textarea>

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
</body></html>
<script type="text/javascript">
    $(function() {
        KindEditor.ready(function(K) {
            var uploadbutton = K.uploadbutton({
                button : K('#btn_thumb')[0],
                fieldName : 'imgFile',
                url : './static/js/kindeditor410/php/upload_json.php?dir=file&folder=logo',
                afterUpload : function(data) {
                    if (data.error === 0) {
                        var url = K.formatUrl(data.url, 'relative');
                        K('#thumb').val(url);
                        K("#lbl_avtor").attr("src", url);
                    } else {
                        alert(data.message);
                    }
                },
                afterError : function(str) {
                    alert('自定义错误信息: ' + str);
                }
            });
            uploadbutton.fileBox.change(function(e) {
                uploadbutton.submit();
            });
            uploadbutton.fileBox.change(function(e) {
                uploadbutton.submit();
            });
        });
    });
</script>