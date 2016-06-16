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
<form action="<?=$this->baseurl?>&m=save" method="post">
    <input type="hidden" name="id" value="<?=$value['id']?>">
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

                <div class="pull-right">

                </div>

            </div>
        </div>
        <!-- 1 -->
        <div class="panel panel-default">
            <div class="panel-heading">
                1.班级信息
            </div>

            <div class="panel-body">

                <table class="table table-condensed  stafftable">

                    <tbody><tr>

                        <th width="20%">班级名称<font color="red">*</font></th>
                        <td width="30%">
                            <input value="<?=setClassname($value['classname']); ?>" name="value[classname]" type="text"  class="form-control">
                            如：2015级1班
                        </td>
                        <th rowspan="2" width="20%">班级LOGO</th>
                        <td rowspan="2" width="30%">
                            <input name="value[logo]"  id="thumb" type="hidden" class="txt" value="<?=$value['logo'] ?>" >
                            <span id=""><a target="_blank" href="<?=$value['logo'] ?>"><img id="lbl_avtor" class="img-thumbnail" src="<?=$value['logo'] ?>"></a></span>
                            <input  type="button" value="上传照片" id="btn_thumb"/>
                        </td>
                    </tr>


                    <tr>
                        <th>班级类型<font color="red">*</font></th>
                        <td>
                            <select name="value[grade]" class="form-control"><?=getSelect($grade, $value['grade'])?></select>
                        </td>

                    </tr>
                    <tr>
                        <th>班级别名</th>
                        <td>
                            <input type="text" name="value[alias]" value="<?=$value['alias'] ?>" class="form-control">
                            如：小一班
                        </td>


                        <th>班级昵称<font color="red">*</font></th>
                        <td>
                            <input name="value[nickname]" value="<?=$value['nickname'] ?>" type="text" class="form-control">
                            如：小蜜蜂班
                        </td>

                    </tr>
                    <tr>
                        <th>班级口号</th>
                        <td class="td_right" colspan="3">
                            <textarea name="value[slogan]" rows="2" cols="20"  class="form-control" style="height:100px;width:600px;"><?=$value['slogan'] ?></textarea>

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