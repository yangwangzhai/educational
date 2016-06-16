<?php $this->load->view('admin/header');?>
<link href="static/admin_img/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="static/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
<form action="<?=$this->baseurl?>&m=save" method="post">
    <input type="hidden" name="id" value="<?=$id?>">
    <div class="container-fluid">
        <div style=" margin:20px; font-size:13px;">
            <style>
                input, button, select, textarea {
                    font-family: inherit;
                    font-size: inherit;
                    line-height: inherit;
                }
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
                    <?=$this->name?>
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">

                        <tbody>
                        <tr>
                            <th width="20%">学生姓名<font color="red">*</font></th>
                            <td width="30%">
                                <input  readonly value="<?php echo $value['studentname']?>"  type="text"  class="form-control">
                                <input type="hidden" name="value[studentid]" value="<?=$value['studentid']?>">
                            </td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>类 型 <font color="red">*</font></th>
                            <td>
                                <select name="value[leave_type]" class="form-control">
                                    <?=getSelect(config_item('student_leave_type'),$value['leave_type'])?>
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
                                                   value="<?php echo $value['daynum']?>" />天

                                            <select name="value[section]" class="form-control" style="width: 40%; display: inline">
                                                <?=getSelect(config_item('section'),$value['section'])?>
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
                                            <input name="value[starttime]" readonly value="<?php echo $value['starttime']?>" style="width: 40%; display: inline" class="form-control" type="text"  onFocus="WdatePicker({startDate:'%y-%M-01 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:true})" />

                                            ~<input name="value[endtime]" readonly value="<?php echo $value['endtime']?>" type="text" style="width: 40%; display: inline" class="form-control"  onFocus="WdatePicker({startDate:'%y-%M-01 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:true})"/>
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