<?php $this->load->view('admin/header');?>
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

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
                        <th width="20%"><a class="btn btn-success" id="base" href="<?=$this->baseurl?>&m=export_save&type=base" target="_blank">基本资料导出</a></th>
                        <td width="50%">
                            <strong>导出学生基础资料。</strong>

                        </td>
                    </tr>
                    <tr>
                        <th width="20%"><a id="detail" class="btn btn-primary" href="<?=$this->baseurl?>&m=export_save&type=detail" target="_blank">详细资料导出</a></th>
                        <td width="50%">
                            <strong>导出全国学前教育管理信息系统(机构级采集系统)要求的上报资料格式。。</strong>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <span style="font-weight: bold;">选择年级：</span>
            <select class="form-control" name="value[grade]" id="grade" style="display: inline;width: auto">
                <?=getSelect($grade)?>
            </select>
            <span style="font-weight: bold;">选择班级：</span>
            <select class="form-control" name="value[class]" id="class" style="display: inline;width: auto">
                <option value="0">未选择</option>
            </select>
        </div>
                        </td>
                    </tr>

                    </tbody></table>
        </div>


    </div>
        </div>
<script type="application/javascript">
        $(document).ready(function(){
            $("#grade").bind("change",function(){
                var grade=$(this).val();
                if(grade==0)
                {
                    $("#class").html("<option value='0'>未选择</option>");
                    $("#base").attr('href',"<?=$this->baseurl?>&m=export_save&type=base");
                    $("#detail").attr('href',"<?=$this->baseurl?>&m=export_save&type=detail");
                }
                else
                {
                    $("#base").attr('href',"<?=$this->baseurl?>&m=export_save&type=base&grade="+grade);
                    $("#detail").attr('href',"<?=$this->baseurl?>&m=export_save&type=detail&grade="+grade);
                    $.ajax({
                        url:"index.php?&d=admin&c=class_list&m=ajaxclass",
                        type:"post",
                        dataType:"json",
                        data:{grade:grade},
                        success:function(data){
                            if(data!='false')
                            {
                                $("#class").html("<option value='0'>未选择</option>");
                                $.each(data,function(key,value){
                                    $("#class").append("<option value="+key+">"+value+"</option>")
                                });
                            }
                        },
                        error:function(XMLHttpRequest, textStatus, errorThrown)
                        {
                            alert(errorThrown);
                        }
                    });
                }
            });
            $("#class").bind('change',function(){
                    var grade=$("#grade").val();
                    var classid=$(this).val();
                    if(classid!=0)
                    {
                        $("#base").attr('href',"<?=$this->baseurl?>&m=export_save&type=base&grade="+grade+"&classid="+classid);
                        $("#detail").attr('href',"<?=$this->baseurl?>&m=export_save&type=detail&grade="+grade+"&classid="+classid);
                    }
                    else
                    {
                        $("#base").attr('href',"<?=$this->baseurl?>&m=export_save&type=base&grade="+grade);
                        $("#detail").attr('href',"<?=$this->baseurl?>&m=export_save&type=detail&grade="+grade);

                    }
            });
        });
    </script>
<?php $this->load->view('admin/footer');?>