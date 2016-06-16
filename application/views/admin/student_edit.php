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
            // 弹出选择学生
            $("#studentname").click(function(){
                var classname = ($("#classname").val());
                var classid = ($("#classid").val());
                studentdialog = dialog_url('index.php?d=admin&c=student&m=dialog&classid='+encodeURIComponent(classid),'选择'+classname+'学生：');
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
                        <tbody>
                        <tr>
                            <th width="20%">班级名称<font color="red">*</font></th>
                            <td width="30%">
                                <input id="classname" value="<?=$value['classname']?>" onclick="show_classname()" type="text"  class="form-control">
                                <input type="hidden" name="value[classid]" id="classid" value="">
                            </td>
                            <th rowspan="2" width="20%">学生照片</th>
                            <td rowspan="2" width="30%">
                                <input name="value[thumb]"  id="thumb" type="hidden" class="txt" value="static/images/nopic.jpg" >
                                <span id=""><a target="_blank" href="static/images/nopic.jpg"><img id="lbl_avtor" class="img-thumbnail" src="static/images/nopic.jpg"></a></span>
                                <input  type="button" value="上传照片" id="btn_thumb"/>
                            </td>
                        </tr>
                        <tr>
                            <th>学生姓名<font color="red">*</font></th>
                            <td>
                                <input name="value[name]" value="<?=$value['name']?>" type="text"  class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>学 籍 号</th>
                            <td>
                                <input name="value[number]" value="<?=$value['number']?>" type="text" class="form-control">
                            </td>
                            <th>性 别</th>
                            <td>
                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <?php foreach(config_item('gender') as $key=>$val):?>
                                            <td><input id="a<?php echo $key?>" type="radio" name="value[gender]" value="<?php echo $key?>" <?php if($key==$value['gender']){echo "checked==checked";}?>><label for="a<?php echo $key?>"><?php echo $val?></label></td>
                                        <?php endforeach;?>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th>民 族</th>
                            <td>
                                <input name="value[nation]" value="<?=$value['nation']?>" type="text" class="form-control">
                            </td>
                            <th>籍 贯</th>
                            <td>
                                <input name="value[place]" value="<?=$value['place']?>" type="text"  class="form-control">
                            </td>

                        </tr>

                        <tr>
                            <th>出生日期</th>
                            <td>
                                <input type="text" name="value[birthday]" id="birthday"  value="<?php echo $value['birthday']?>" class="form-control">
                            </td>
                            <th>政治面貌</th>
                            <td>
                                <input name="value[political_status]" value="<?=$value['political_status']?>" type="text" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <th>家庭住址</th>
                            <td>
                                <input name="value[address]" value="<?=$value['address']?>" type="text" id="tel" class="form-control">
                            </td>
                            <th>住宅电话</th>
                            <td>
                                <input name="value[tel]" value="<?=$value['tel']?>" type="text" class="form-control">
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

                        <tbody>
                        <tr>
                            <th>身份证号码</th>
                            <td>
                                <input name="value[idcard]" value="<?=$value['idcard']?>" type="text" class="form-control">
                            </td>
                            <th>血型</th>
                            <td>
                                <input name="value[bloodtype]" value="<?=$value['bloodtype']?>" type="text" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>父亲姓名</th>
                            <td>
                                <input name="value[father]" value="<?=$value['father']?>" type="text" class="form-control">
                            </td>
                            <th>母亲姓名</th>
                            <td>
                                <input name="value[mother]" value="<?=$value['mother']?>" type="text" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>父工作单位</th>
                            <td>
                                <input name="value[f_workplace]" value="<?=$value['f_workplace']?>" type="text" class="form-control">
                            </td>
                            <th>母工作单位</th>
                            <td>
                                <input name="value[m_workplace]" value="<?=$value['m_workplace']?>" type="text" class="form-control">
                            </td>

                        </tr>
                        <tr>
                            <th>父亲电话</th>
                            <td>
                                <input name="value[f_tel]" value="<?=$value['f_tel']?>" type="text" class="form-control">
                            </td>
                            <th>母亲电话</th>
                            <td>
                                <input name="value[m_tel]" value="<?=$value['m_tel']?>" type="text" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>户口性质</th>
                            <td>
                                <select name="value[account]" class="form-control">
                                    <option value="农业" <?php if($value['account']=='农业'){echo "selected=selected";}?>>农业</option>
                                    <option value="非农" <?php if($value['account']=='非农'){echo "selected=selected";}?>>非农</option>
                                </select>
                            </td>
                            <th>出生地</th>
                            <td>
                                <input type="text" name="value[bir_address]" value="<?=$value['bir_address']?>" class="form-control">
                            </td>

                        </tr>
                        <tr>
                            <th>户口所在地</th>
                            <td>
                                <input type="text" name="value[account_address]" value="<?=$value['account_address']?>" class="form-control"/>
                            </td>
                            <th>健康状况</th>
                            <td>
                                <input type="text" name="value[heath_status]" value="<?=$value['heath_status']?>" class="form-control"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>

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