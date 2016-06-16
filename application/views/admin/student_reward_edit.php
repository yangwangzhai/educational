<?php $this->load->view('admin/header');?>
<link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
<script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
<style>
    button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
</style>
<script>
    $(document).ready(function(){
        // 日期
        $('#pubdate').Zebra_DatePicker({
            months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            days:['日', '一', '二', '三', '四', '五', '六'],
            lang_clear_date:'清除',
            show_select_today:'今天'
        });
        //弹出选择教师
        $("#teachername").click(function(){
            teacherdialog=dialog_url('index.php?d=admin&c=teacher&m=dialog','选择教师：');
        });
        $("#studentname").click(function(){
            var classname = ($("#classname").val());
            var classid = ($("#classid").val());
            studentdialog = dialog_url('index.php?d=admin&c=student&m=dialog&classid='+encodeURIComponent(classid),'选择'+classname+'学生：');
        });
        $("#rewardname").click(function(){
            var type = ($("#type").val());
            rewarddialog = dialog_url('index.php?d=admin&c=reward&m=dialog&type='+encodeURIComponent(type),'选择奖罚名称：');
        });
        $("#type").bind("change",function(){
            var value=$(this).val();
            if(value==2)
            {
                $(".stafftable>tbody").find("tr:eq(5)").show();
                $(".stafftable>tbody").find("tr:eq(4)").show();
            }
            else
            {
                $(".stafftable>tbody").find("tr:eq(5)").hide();
                $(".stafftable>tbody").find("tr:eq(4)").hide();
            }
        });
    });

</script>
</head>
<body>
<form action="<?=$this->baseurl?>&m=save" method="post">
    <input type="hidden" value="<?=$id?>" name="id">
    <div class="container-fluid">
        <div style=" margin:20px; font-size:13px;">
            <style>
                input, button, select, textarea {
                    font-family: inherit;
                    font-size: inherit;
                    line-height: inherit;
                }
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
                    1.学生奖罚
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">

                        <tbody>
                        <tr>
                            <th width="20%">班级名称</th>
                            <td width="30%">
                                <input id="classname" onclick="show_classname()" value="<?=$value['classname']?>" type="text"  class="form-control">
                                <input type="hidden"  id="classid" value="<?=$value['classid']?>">

                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th width="20%">学生姓名<font color="red">*</font></th>
                            <td width="30%">
                                <input type="text" class="form-control" id="studentname"
                                       value="<?=$value['studentname']?>" />
                                <input type="hidden" name="value[studentid]" id="studentid"
                                       value="<?=$value['studentid']?>" />
                            </td>
                            <th ></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>奖罚类型 <font color="red">*</font></th>
                            <td>
                                <select name="value[reward_type]" id="type" class="form-control">
                                    <?=getSelect(config_item('reward_type'),$value['type'])?>
                                </select>
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>奖罚名称 <font color="red">*</font></th>
                            <td>
                                <input type="text" class="form-control" id="rewardname"
                                       value="<?=$value['rewardname']?>" />
                                <input type="hidden" name="value[rewardid]" id="rewardid"
                                       value="<?=$value['rewardid']?>" />
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr <?php if($value['type']==1) echo "style='display:none'"?>>
                            <th>指派教师</th>
                            <td>
                                <input id="teachername" value="<?=$value['truename']?>" type="text"  class="form-control">
                                <input type="hidden" name="teacherid" id="teacherid" value="<?=$value['teacherid']?>">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr <?php if($value['type']==1) echo "style='display:none'"?>>
                            <th>书面检讨</th>
                            <td>
                                <input value="<?=$value['doc']?>" type="file" name="file" class="form-control">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>日期</th>
                            <td>
                                <input name="value[pubdate]" id="pubdate" value="<?=$value['pubdate']?>"  type="text" class="form-control">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>备 注<font color="red">*</font></th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[content]" rows="2" cols="20"  class="form-control" style="height:150px;width:100%;"><?=$value['content']?></textarea>

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