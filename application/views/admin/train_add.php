<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet"	href="static/js/kindeditor410/themes/default/default.css" />
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <script type="text/javascript" src="static/js/common.js?1"></script>
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <script type="text/javascript" src="static/plugin/uploadify/jquery.uploadify-3.1.js"></script>
    <link rel="stylesheet" type="text/css" href="static/plugin/uploadify/uploadify.css"/>
    <style>
        button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
    </style>
    <script>
        $(document).ready(function(){
            //弹出选择教师
            $("#teachername").click(function(){
                dialog=dialog_url('index.php?d=admin&c=train&m=dialog','选择教师：');
            });
            // 出生日期
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
            $('#file_upload').uploadify({
                'auto'     : false,//关闭自动上传
                'removeTimeout' : 1,//文件队列上传完成1秒后删除
                'swf'      : 'static/plugin/uploadify/uploadify.swf',
                'uploader' : '<?=$this->baseurl?>&m=upload',
                'method'   : 'post',//方法，服务端可以用$_POST数组获取数据
                'buttonText' : '选择附件',//设置按钮文本
                'multi'    : true,//允许同时上传多张图片
                'uploadLimit' : 10,//一次最多只允许上传10张图片
                'fileTypeDesc' : 'Image Files',//只允许上传图像
                'fileTypeExts' : '*.mp3; *.jpg; *.png; *.xls;*.doc;*.flv;*.mp4;',//限制允许上传的图片后缀
                'fileSizeLimit' : '102400KB',//限制上传的图片不得超过200KB
                'onUploadSuccess' : function(file, data, response) {//每次成功上传后执行的回调函数，从服务端返回数据到前端
                    if(data!='error')
                    {
                        var table1 = $('.table');
                        var firstTr = table1.find('tbody>tr:first').children('th').first().text();
                        var row = $("<tr></tr>");
                        /*var td = $("<td></td>");*/
                        if(firstTr=='')
                        {
                            $('.table').append("<tr class='tr_title'> <th scope='col'>ID</th><th scope='col'>附件名称</th><th scope='col'>上传时间</th><th scope='col'>文件大小(kb)</th></tr>");
                        }
                        row.append(data);
                        table1.append(row);
                    }
                },
                'onQueueComplete' : function(queueData) {//上传队列全部完成后执行的回调函数
                }
                // Put your options here
            });
        });
    </script>

</head>
<body class="laydate_body">

<form action="<?=$this->baseurl?>&m=save" method="post">
    <div class="container-fluid">
        <div style=" margin:20px; font-size:13px;">
            <style>
                .tablecourse th {
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
            <a href="javascript:history.back();" class="btn btn-success">返回查询</a>
            <br> <br>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        1.课程基本信息
                    </div>

                    <div class="panel-body">


                        <table class="table table-condensed tablecourse">

                            <tbody><tr>
                                <!-- add pic -->


                                <th width="20%">培训名称<font color="red">*</font></th>
                                <td width="30%">

                                    <input name="value[title]"  type="text" value="" class="form-control">

                                </td>



                                <th width="20%">培训组织者/部门</th>
                                <td width="30%">
                                    <input name="value[organize]" type="text" class="form-control">

                                </td>
                            </tr>
                            <tr>

                                <th>培训时间从

                                </th>
                                <td>
                                    <input name="value[begintime]" type="text" value="" id="begintime" class="form-control" >
                                </td>


                                <th>培训时间到</th>
                                <td>
                                    <input name="value[endtime]" type="text" value="" id="endtime" class="form-control">
                                </td>

                            </tr>

                            <tr>
                                <!-- add pic -->
                                <th>课程时长(天)</th>
                                <td>
                                    <input name="value[during]" type="text" value=""  class="form-control">
                                </td>


                                <th>课程类别</th>
                                <td>
                                    <select name="value[train_type]" class="form-control">
                                        <?=getSelect(config_item('train_type'))?></select>

                                </td>

                            </tr>


                            <tr>

                                <th>培训地点

                                </th>
                                <td>
                                    <input name="value[place]" type="text" value=""  class="form-control">

                                </td>


                                <th>培训讲师</th>
                                <td>

                                    <input name="value[teacher]" type="text" value=""  class="form-control">
                                </td>

                            </tr>
                            </tbody></table>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            2.培训学员信息
                        </div>

                        <div class="panel-body">


                            <table class="table table-condensed tablecourse">


                                <tbody><tr>
                                    <!-- add pic -->
                                    <th width="20%">培训费用

                                    </th>
                                    <td width="30%">
                                        <input name="value[fee]" type="text" class="form-control">

                                    </td>


                                    <th width="20%">人数</th>
                                    <td width="30%">
                                        <input name="value[number]" type="text" class="form-control">

                                    </td>

                                </tr>


                                <tr>
                                    <!-- add pic -->
                                    <th>面向部门

                                    </th>
                                    <td>
                                        <input name="value[dept]" type="text"  class="form-control">

                                    </td>


                                    <th>受众</th>
                                    <td>
                                        <input name="value[faceto]" readonly id="teachername" type="text" class="form-control">

                                    </td>

                                </tr>
                                <tr>
                                    <!-- add pic -->
                                    <th>课程简介

                                    </th>
                                    <td colspan="3">
                                        <textarea name="value[content]" rows="2" cols="20"  class="form-control" style="height:60px;width:600px;"></textarea>

                                    </td>

                                </tr>


                                <tr>

                                    <th>学习目标

                                    </th>
                                    <td class="td_right" colspan="3">
                                        <textarea name="value[purpose]" rows="2" cols="20"  class="form-control" style="height:60px;width:600px;"></textarea>

                                    </td>

                                </tr>



                                <tr>

                                    <th>课件附件

                                    </th>
                                    <td width="80%" colspan="2">
                                        <input type="file" name="file_upload" id="file_upload" style="height:30px;width:400px;" />

                                    </td>
                                    <td>
                                        <a href="javascript:$('#file_upload').uploadify('settings', 'formData', {'id':'add'});$('#file_upload').uploadify('upload','*')" class="btn bg-maroon">上传</a>
                                        <a href="javascript:$('#file_upload').uploadify('cancel','*')" class="btn bg-maroon">重置上传队列</a>
                                    </td>

                                </tr>

                                </tbody></table>

                        </div>


                    </div>


                    <div>

                    </div>


                    <div class="panel panel-default">
                        <div class="panel-body text-center">

                            <input type="submit" name="" value="添加"  class="btn btn-primary">
                            <input type="submit" name="" value="取消" onclick="javascript:history.back();" class="btn btn-danger">
                        </div>
                    </div>



                </div>



        </div></div></form></body></html>