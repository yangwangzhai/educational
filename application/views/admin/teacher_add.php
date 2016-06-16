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
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="static/js/common.js?1"></script>
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <style>
        button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
    </style>
    <script>
        $(document).ready(function(){
            // 日期
            $('#birthday').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            $('#joinin').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            // 日期
            $('#expireto').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
        });
    </script>
</head>
<body>
<form id="form" action="<?=$this->baseurl?>&m=save" method="post">
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

            <!-- 1 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    1.基本信息
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">

                        <tbody><tr>

                            <th width="20%">中文姓名<font color="red">*</font></th>
                            <td width="30%">
                                <input name="value[truename]" value="" type="text"  class="form-control">

                            </td>
                            <th rowspan="2" width="20%">教师照片</th>
                            <td rowspan="2" width="30%">
                                <input name="value[thumb]"  id="thumb" type="hidden" class="txt" value="static/images/nopic.jpg" >
                                <span id=""><a target="_blank" href="static/images/nopic.jpg"><img id="lbl_avtor" class="img-thumbnail" src="static/images/nopic.jpg"></a></span>
                                <input  type="button" value="上传照片" id="btn_thumb"/>
                            </td>
                        </tr>


                        <tr>

                            <th>教师昵称</th>
                            <td>
                                <input name="value[nickname]" type="text" value="" class="form-control">

                            </td>

                        </tr>
                        <tr>
                            <th>系统登录名 </th>
                            <td>
                                <input name="value[username]" type="text" value="" class="form-control">
                            </td>
                            </th>
                            <td>
                                &nbsp;

                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <th>员工部门 </th>
                            <td>
                                <select name="value[dept]" class="form-control">
                                    <?=getSelect(config_item('dept'))?></select>
                            </td>
                            <th>任教科目 </th>
                            <td>
                                <input name="value[course]" type="text" value="" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>办公地点</th>
                            <td>
                                <input name="value[Office]" type="text" value="" class="form-control">
                            </td>
                            <th>邮 件</th>
                            <td>
                                <input name="value[email]" type="text" value="" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>办公电话<font color="red">*</font></th>
                            <td>
                                <input name="value[tel]" type="text" value="" class="form-control">
                            </td>
                            <th>传 真</th>
                            <td>
                                <input name="value[fax]" type="text" value="" class="form-control">
                            </td>

                        </tr>

                        <tr>
                            <th>年级组 </th>
                            <td>
                                <select name="value[grade_group]" class="form-control">
                                    <option value="">未选择</option>
                                    <option value="七年级">七年级</option>
                                    <option value="八年级">八年级</option>
                                    <option value="九年级">九年级</option>
                                </select>
                            </td>
                            <th>性 别</th>
                            <td>
                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <?php foreach(config_item('gender') as $key=>$val):?>
                                            <td><input id="a<?php echo $key?>" type="radio" name="value[gender]" value="<?php echo $key?>"><label for="a<?php echo $key?>"><?php echo $val?></label></td>
                                        <?php endforeach;?>
                                    </tr>
                                    </tbody></table>

                            </td>
                        </tr>

                        <tr>
                            <th>是否中层领导</th>
                            <td>
                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <td><input id="a1" type="radio" name="value[middle_leader]" value="1"><label for="a1">是</label></td>
                                        <td><input id="a0" type="radio" name="value[middle_leader]" value="0"><label for="a0">否</label></td>
                                    </tr>
                                    </tbody></table>
                            </td>
                            <th>备课组长 </th>
                            <td>
                                <table id="" border="0" style="border-width:0px;width:200px;">
                                    <tbody><tr>
                                        <td><input id="a1" type="radio" name="value[prepare_supervisor]" value="1"><label for="a1">是</label></td>
                                        <td><input id="a0" type="radio" name="value[prepare_supervisor]" value="0"><label for="a0">否</label></td>
                                    </tr>
                                    </tbody></table>
                            </td>
                        </tr>
                        <tr>
                            <th>年级组长</th>
                            <td>
                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <td><input id="a1" type="radio" name="value[grade_supervisor]" value="1"><label for="a1">是</label></td>
                                        <td><input id="a0" type="radio" name="value[grade_supervisor]" value="0"><label for="a0">否</label></td>
                                    </tr>
                                    </tbody></table>

                            </td>

                            <th>教研组长</th>
                            <td>
                                <table id="" border="0" style="border-width:0px;width:200px;">
                                    <tbody><tr>
                                        <td><input id="a1" type="radio" name="value[teach_supervisor]" value="1"><label for="a1">是</label></td>
                                        <td><input id="a0" type="radio" name="value[teach_supervisor]" value="0"><label for="a0">否</label></td>
                                    </tr>
                                    </tbody></table>

                            </td>
                        </tr>
                        <tr>

                            <th>主管班级(班主任)</th>
                            <td class="td_right" colspan="3">
                                <?php foreach($class_list as $key=>$classname):
                                    if(($key)%8==0){echo '<br />';}?>
                                    <input name="manage[]" type="checkbox" id="checkbox" value="<?=$key?>"
                                    <?=in_array($key, $manageid_array)?'checked="checked"':''?>
                                    /><?=$classname?>&nbsp;&nbsp;&nbsp;
                                <?php endforeach;?>

                            </td>

                        </tr>
                        <tr>

                            <th>任教班级</th>
                            <td class="td_right" colspan="3">
                                <?php foreach($class_list as $key=>$classname):
                                    if(($key)%8==0){echo '<br />';}?>
                                    <input name="class[]" type="checkbox" id="checkbox" value="<?=$key?>"
                                    <?=in_array($key, $classid_array)?'checked="checked"':''?>
                                    /><?=$classname?>&nbsp;&nbsp;&nbsp;
                                <?php endforeach;?>
                            </td>

                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    2.档案信息
                </div>
                <div class="panel-body">
                    <table class="table table-condensed  stafftable">

                        <tbody><tr>
                            <th width="20%">员工状态</th>
                            <td width="30%">

                                <table id="" border="0" style="border-width:0px;width:320px;">
                                    <tbody><tr>
                                        <?php foreach(config_item('staffstatus') as $k=>$v):?>
                                            <td><input id="c<?=$k?>" type="radio" name=value[staffstatus]"  value="<?php echo $k?>"><label for="c<?=$k?>"><?=$v?></label></td>
                                        <?php endforeach;?>
                                    </tr>
                                    </tbody></table>

                            </td>

                            <th width="20%">上级领导</th>
                            <td width="30%">

                                <input name="value[supermgr]" type="text" value="" class="form-control">

                            </td>

                        </tr>
                        <tr>

                            <th>国籍</th>
                            <td>
                                <input name="value[country]" type="text"   value="中国" class="form-control">
                            </td>



                            <th>民族</th>
                            <td>
                                <input name="value[nation]" type="text"   value="" class="form-control">
                            </td>

                        </tr>
                        <tr>
                            <th>出生年月</th>
                            <td class="td_right">
                                <input name="value[birthday]" type="text" id="birthday"  value="<?php echo $value['birthday']?>" class="form-control">
                            </td>


                            <th>私人手机</th>
                            <td>
                                <input name="value[privatemobile]" type="text" value="" class="form-control">
                            </td>

                        </tr>

                        <tr>

                            <th>职 务</th>
                            <td>
                                <input name="value[stafftitle]" type="text" value="" class="form-control">
                            </td>


                            <th>学 历</th>
                            <td>
                                <select name="value[degrees]" class="form-control">
                                    <?=getSelect(config_item('degrees'))?></select>
                            </td>
                        </tr>
                        <tr>
                            <th>专业</th>
                            <td>
                                <input type="text" name="value[majorin]" value="" class="form-control"/>
                            </td>

                            <th>毕业院校</th>
                            <td>
                                <input type="text" name="value[graduate]" value="" class="form-control">
                            </td>

                        </tr>
                        <tr>
                            <th>身高</th>
                            <td>
                                <input type="text" name="value[height]" value="" class="form-control"/>
                            </td>

                            <th>婚姻</th>
                            <td>
                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <?php foreach(config_item('marry') as $k=>$v):?>
                                            <td><input id="d<?=$k?>" type="radio" name=value[marry]"  value="<?php echo $k?>"><label for="d<?=$k?>"><?=$v?></label></td>
                                        <?php endforeach;?>
                                    </tr>
                                    </tbody></table>

                            </td>
                        </tr>
                        <tr>
                            <th>入职日期</th>
                            <td>
                                <input type="text" name="value[joinin]"
                                       id="joinin"   value="<?=$value['joinin']?>" class="form-control" >

                            </td>


                            <th>合同到期</th>
                            <td>
                                <input type="text" name="value[expireto]" id="expireto"
                                       value="<?=$value['expireto']?>" class="form-control" >

                            </td>

                        </tr>

                        <tr>
                            <th>证件类型</th>
                            <td>
                                <select name="value[idcardtype]" class="form-control">
                                    <?=getSelect(config_item('idcardtype'))?></select>

                            </td>


                            <th>证件号</th>
                            <td>
                                <input type="text" name="value[idcard]" value="" class="form-control" />
                            </td>

                        </tr>
                        <tr>

                            <th>个性签名</th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[sign]" rows="2" cols="20"  class="form-control" style="height:80px;"></textarea>

                            </td>

                        </tr>
                        <tr>

                            <th>地 址</th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[address]" rows="2" cols="20"  class="form-control" style="height:80px;"></textarea>

                            </td>

                        </tr>
                        </tbody></table>

                </div>

            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    3.账户相关信息
                </div>
                <div id="collapseThree" class="panel-collapse collapse in">
                    <div class="panel-body">

                        <table class="table table-condensed  stafftable">

                            <tbody><tr>


                                <th width="20%">社保种类</th>
                                <td width="30%">


                                    <table id="" border="0" style="border-width:0px;width:250px;">
                                        <tbody><tr>
                                            <?php foreach(config_item('shebaotype') as $k=>$v):?>
                                                <td><input id="e<?=$k?>" type="radio" name=value[shebaotype]"  value="<?php echo $k?>"><label for="e<?=$k?>"><?=$v?></label></td>
                                            <?php endforeach;?>
                                        </tr>
                                        </tbody></table>
                                </td>
                                <th width="20%">社保号</th>
                                <td width="30%">
                                    <input name="value[shebaono]" type="text" value="" class="form-control">
                                </td>

                            </tr>
                            <tr>

                                <th>医保号</th>
                                <td>
                                    <input name="value[yibaono]" type="text" value="" class="form-control">
                                </td>


                                <th>公积金号</th>
                                <td>
                                    <input name="value[gjjno]" type="text" value="" class="form-control">
                                </td>


                            </tr>

                            <tr>
                                <th>工资开户行</th>
                                <td>

                                    <input name="value[bankname]" type="text" value="" class="form-control">

                                </td>

                                <th>工资卡号</th>
                                <td>

                                    <input name="value[bankcardno]" type="text" value="" class="form-control">
                                </td>

                            </tr>


                            <tr>

                                <th>政治面貌</th>
                                <td>
                                    <select name="value[politics]" class="form-control">
                                        <?=getSelect(config_item('politics'))?></select>
                                </td>

                                <th>QQ</th>
                                <td>

                                    <input name="value[QQ]" type="text" value="" class="form-control"/>


                                </td>

                            </tr>

                            <tr>
                                <th>私人邮件</th>
                                <td>

                                    <input name="value[privateemail]" type="text" value="" class="form-control">
                                </td>


                                <th>微信</th>
                                <td>
                                    <input name="value[weixin]" type="text" value="" class="form-control">

                                </td>

                            </tr>


                            <tr>

                                <th>紧急联系人</th>
                                <td>

                                    <input name="value[urgentcontactpeople]" type="text" value="" class="form-control">
                                </td>


                                <th>紧急联系电话</th>
                                <td>
                                    <input name="value[urgentcontacttel]" type="text" value="" class="form-control">

                                </td>

                            </tr>

                            <tr>
                                <th>备注</th>
                                <td colspan="3">
                                    <textarea name="value[content]" rows="2" cols="20" class="form-control" style="height:80px;"></textarea>
                                </td>
                            </tr>


                            </tbody></table>
                    </div>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <div class="pull-left">


                    </div>

                    <input type="submit" name="" value="添加"  class="btn btn-primary">
                    <input type="submit" name="" value="取消" onclick="javascript:history.back();" class="btn btn-danger">
                    <div class="pull-right">

                    </div>

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