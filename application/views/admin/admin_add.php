<?php $this->load->view('admin/header');?>
<link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

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
                    1.管理员
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable">

                        <tbody><tr>

                            <th width="20%">用户名<font color="red">*</font></th>
                            <td width="30%">
                                <input name="value[username]" type="text"
                                       value=""  class="form-control"/>
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>密 码</th>
                            <td>
                                <input style="display: inline" name="value[password]" type="password"
                                       class="form-control" value="" />
                            </td>
                            <td >不修改请留空</td>
                            <td>
                            </td>

                        </tr>
                        <tr>
                            <th>姓 名</th>
                            <td>
                                <input name="value[truename]" class="form-control" type="text"
                                        value="" />
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>手 机</th>
                            <td>
                                <input name="value[telephone]" class="form-control" type="text"
                                        value="" />
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>邮箱</th>
                            <td><input name="value[email]" class="form-control" type="text"
                                        value="" /></td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>备 注</th>
                            <td class="td_right" colspan="3">
                                <textarea name="value[remarks]" rows="2" cols="20"  class="form-control" style="height:150px;width:100%;"></textarea>

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