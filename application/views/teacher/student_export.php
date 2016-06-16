<?php $this->load->view('admin/header');?>
    <link href="static/admin_img/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <div class="container-fluid">

        <!-- 1 -->
        <div class="panel panel-default">
            <div class="panel-heading">
                导出资料
            </div>

            <div class="panel-body">

                <table class="table table-condensed ">

                    <tbody>
                    <tr>
                        <th width="20%"><a  class="btn btn-success" href="<?=$this->baseurl?>&m=export_save&type=base" target="_blank">基本资料导出</a></th>
                        <td width="50%">
                            <strong>导出幼儿基础资料。</strong>

                        </td>
                    </tr>


                    <tr>
                        <th width="20%"><a  class="btn btn-primary" href="<?=$this->baseurl?>&m=export_save&type=detail" target="_blank">详细资料导出</a></th>
                        <td width="50%">
                            <strong>导出全国学前教育管理信息系统(机构级采集系统)要求的上报资料格式。。</strong>

                        </td>

                    </tr>

                    </tbody></table>
        </div>


    </div>
        </div>

<?php $this->load->view('admin/footer');?>