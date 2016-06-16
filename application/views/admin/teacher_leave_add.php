<?php $this->load->view('admin/header');?>
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/js/My97DatePicker/WdatePicker.js"></script>
    <script>
        $(document).ready(function(){
            //弹出选择教师
            $("#teachername").click(function(){
                teacherdialog=dialog_url('index.php?d=admin&c=teacher&m=dialog','选择教师：');
            });
        });

    </script>
</head>
<body>
<form action="<?=$this->baseurl?>&m=save" method="post">
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
                    1.教师请假
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">

                        <tbody><tr>

                            <th width="20%">教师名字<font color="red">*</font></th>
                            <td width="30%">
                                <input type="text" class="form-control" id="teachername"
                                       value="" />
                                <input type="hidden" name="value[teacherid]" id="teacherid"
                                       value="" />
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>类 型 <font color="red">*</font></th>
                            <td>
                                <select name="value[leave_type]" class="form-control">
                                    <?=getSelect(config_item('leave_type'))?>
                                </select>
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>天 数<font color="red">*</font></th>
                            <td class="td_right">
                                <table border="0" style="border-width:0px;width:100%;">
                                    <tbody><tr>
                                        <td>
                                            <input name="value[daynum]" style="width: 40%; display: inline" class="form-control" type="text" id="thumb"
                                                   value="" />天

                                            <select name="value[hournum]" class="form-control" style="width: 40%; display: inline">
                                                <?=getSelect($hournums)?>
                                            </select>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th >时 间<font color="red">*</font></th>
                            <td class="td_right" colspan="3">
                                <table border="0" style="border-width:0px;width:100%;">
                                    <tbody><tr>
                                        <td>
                                            <input name="value[starttime]" readonly style="width: 40%; display: inline" class="form-control" type="text"  onFocus="WdatePicker({startDate:'%y-%M-01 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:true})" />

                                            ~<input name="value[endtime]" readonly type="text" style="width: 40%; display: inline" class="form-control"  onFocus="WdatePicker({startDate:'%y-%M-01 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:true})"/>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>理 由<font color="red">*</font></th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[content]" rows="2" cols="20"  class="form-control" style="height:150px;width:100%;"></textarea>

                            </td>

                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <input type="submit" name="" id="submit" value="添加"  class="btn btn-primary">
                    <input type="submit" name="" value="取消" onclick="javascript:history.back();" class="btn btn-danger">
                </div>
            </div>
        </div>
    </div>
</form>
</body></html>