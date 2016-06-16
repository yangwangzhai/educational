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
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <style>
        button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            // 入园年龄
            $('#pubdate').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            // 日期
            $('#birthday').Zebra_DatePicker({
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

                            <tbody><tr>

                                <th width="20%">班级名称<font color="red">*</font></th>
                                <td width="30%">
                                    <input  value="<?=$value['classname']?>" readonly type="text"  class="form-control">
                                    <input type="hidden" name="value[classid]"  value="<?=$value['classid']?>">

                                </td>
                                <th rowspan="2" width="20%">幼儿照片</th>
                                <td rowspan="2" width="30%">
                                    <input name="value[thumb]"  id="thumb" type="hidden" class="txt" value="static/images/nopic.jpg" >
                                    <span id=""><a target="_blank" href="static/images/nopic.jpg"><img id="lbl_avtor" class="img-thumbnail" src="static/images/nopic.jpg"></a></span>
                                    <input  type="button" value="上传照片" id="btn_thumb"/>
                                </td>
                            </tr>


                            <tr>
                                <th>幼儿姓名<font color="red">*</font></th>
                                <td>
                                    <input name="value[name]" type="text"  class="form-control">

                                </td>

                            </tr>
                            <tr>
                                <th>出生日期</th>
                                <td>
                                    <input type="text" name="value[birthday]" id="birthday"  value="<?php echo $value['birthday']?>" class="form-control">
                                </td>


                                <th>性 别</th>
                                <td>
                                    <table id="" border="0" style="border-width:0px;width:150px;">
                                        <tbody><tr>
                                            <?php foreach(config_item('gender') as $key=>$val):?>
                                            <td><input id="a<?php echo $key?>" type="radio" name="value[gender]" value="<?php echo $key?>"><label for="a<?php echo $key?>"><?php echo $val?></label></td>
                                            <?php endforeach;?>

                                        </tr>
                                        </tbody>
                                    </table>
                                </td>

                            </tr>
                            <tr>


                                <th>民 族</th>
                                <td>
                                    <input name="value[nation]" type="text" class="form-control">
                                </td>

                                <th>籍 贯</th>
                                <td>
                                    <input name="value[place]" type="text"  class="form-control">
                                </td>

                            </tr>

                            <tr>



                                <th>入园日期</th>
                                <td>
                                    <input  type="text" name="value[pubdate]" id="pubdate"  value="<?=$value['pubdate']?>" class="form-control">
                                </td>

                                <th>学 籍 号</th>
                                <td>

                                    <input name="value[number]" type="text" class="form-control">

                                </td>

                            </tr>

                            <tr>
                                <th>家庭住址</th>
                                <td>
                                    <input name="value[address]" type="text" id="tel" class="form-control">

                                </td>

                                <th>住宅电话</th>
                                <td>
                                    <input name="value[tel]" type="text" class="form-control">

                                </td>


                            </tr>

                            <tr>

                                <th>有无疾病史</th>
                                <td>
                                    <input name="value[allergic]" type="text" class="form-control">
                                </td>
                                <th>择园原因</th>
                                <td>
                                    <select name="value[reason]" class="form-control">
                                        <?=getSelect(config_item('reason'))?></select>

                                </td>

                            </tr>
                            </tbody></table>
                    </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    2.其他信息
                </div>
                <div class="panel-body">
                    <table class="table table-condensed  stafftable">

                        <tbody><tr>
                            <th>英文名</th>
                            <td>
                                <input name="value[engname]" type="text" class="form-control">
                            </td>

                            <th width="20%">是否独生子女</th>
                            <td width="30%">

                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <td><input id="b1" type="radio" name=value[child]"  value="1"><label for="b1">是</label></td>
                                        <td><input id="b2" type="radio" name=value[child]"  value="2"><label for="b2">不是</label></td>
                                    </tr>
                                    </tbody></table>

                            </td>

                        </tr>
                        <tr>
                            <th>身份证件类型</th>
                            <td>
                                <select name="value[idcardtype]" class="form-control">
                                    <?=getSelect(config_item('idcardtype'))?></select>

                            </td>
                            <th width="20%">是否进城务工人员随迁子女</th>
                            <td width="30%">

                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <td><input id="c1" type="radio" name=value[workers]"  value="1"><label for="c1">是</label></td>
                                        <td><input id="c2" type="radio" name=value[workers]"  value="2"><label for="c2">不是</label></td>
                                    </tr>
                                    </tbody></table>

                            </td>

                        </tr>
                        <tr>
                            <th>身份证件号码</th>
                            <td>
                                <input type="text" name="value[idcard]" value="" class="form-control" />
                            </td>


                            <th>是否留守儿童</th>
                            <td width="30%">

                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <td><input id="d1" type="radio" name=value[stay]"  value="1"><label for="d1">是</label></td>
                                        <td><input id="d2" type="radio" name=value[stay]"  value="2"><label for="d2">不是</label></td>
                                    </tr>
                                    </tbody></table>

                            </td>

                        </tr>

                        <tr>

                            <th>接受资助</th>
                            <td width="30%">

                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <td><input id="e1" type="radio" name=value[support]"  value="1"><label for="e1">是</label></td>
                                        <td><input id="e2" type="radio" name=value[support]"  value="2"><label for="e2">不是</label></td>
                                    </tr>
                                    </tbody></table>

                            </td>


                            <th>是否低保</th>
                            <td width="30%">

                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <td><input id="f1" type="radio" name=value[allowances]"  value="1"><label for="f1">是</label></td>
                                        <td><input id="f2" type="radio" name=value[allowances]"  value="2"><label for="f2">不是</label></td>
                                    </tr>
                                    </tbody></table>

                            </td>
                        </tr>
                        <tr>
                            <th>户口性质</th>
                            <td>
                                <select name="value[account]" class="form-control">
                                    <?=getSelect(config_item('account'))?></select>
                            </td>

                            <th>出生地</th>
                            <td>
                                <input type="text" name="value[bir_address]" value="" class="form-control">
                            </td>

                        </tr>
                        <tr>
                            <th>户口所在地</th>
                            <td>
                                <input type="text" name="value[account_address]" value="" class="form-control"/>
                            </td>

                            <th>是否残疾幼儿</th>
                            <td width="30%">

                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <td><input id="g1" type="radio" name=value[disabled]"  value="1"><label for="g1">是</label></td>
                                        <td><input id="g2" type="radio" name=value[disabled]"  value="2"><label for="g2">不是</label></td>
                                    </tr>
                                    </tbody></table>

                            </td>
                        </tr>
                        <tr>
                            <th>是否寄宿生</th>
                            <td width="30%">

                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <td><input id="h1" type="radio" name=value[boarding]"  value="1"><label for="h1">是</label></td>
                                        <td><input id="h2" type="radio" name=value[boarding]"  value="2"><label for="h2">不是</label></td>
                                    </tr>
                                    </tbody></table>

                            </td>


                            <th>残疾幼儿类别</th>
                            <td>
                                <select name="value[disabled_type]" class="form-control">
                                    <?=getSelect(config_item('disabled_type'))?></select>

                            </td>

                        </tr>

                        <tr>
                            <th>是否孤儿</th>
                            <td>
                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <td><input id="i1" type="radio" name=value[orphans]"  value="1"><label for="i1">是</label></td>
                                        <td><input id="i2" type="radio" name=value[orphans]"  value="2"><label for="i2">不是</label></td>
                                    </tr>
                                    </tbody></table>

                            </td>


                            <th></th>
                            <td>

                            </td>

                        </tr>
                        <tr>

                            <th>备 注</th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[content]" rows="2" cols="20"  class="form-control" style="height:100px;width:600px;"></textarea>

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