<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>添加知识点</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>
<script type="application/javascript">
    $(document).ready(function(){
        $("#selSubject").on("change",function(){
            var subjectid=$("#selSubject").val();
            $.ajax({
                url: "index.php?d=examination&c=test&m=get_knowledge_catogery",   //后台处理程序
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{subjectid:subjectid},  //要传递的数据
                success:function(data){
                    if(data){
                        $("#selknowledge").children().remove();
                        $("#selknowledge").append("<option value='0'>顶级分类</option>");
                        $.each(data,function(key,val){
                            var space='';
                            for(var i=0;i<parseInt(val['level']);i++){
                                 space +="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            }
                            $("#selknowledge").append("<option value="+val['id']+">"+space+val['knowledge_point']+"</option>");
                        });
                    }else{
                        $("#selknowledge").append("<option value='0'>顶级分类</option>");
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown)
                {
                    //alert(errorThrown);
                }
            });
        });
    })
</script>
<body>
<form action="<?=$this->baseurl?>&m=knowledge_save" method="post">
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
                    添加知识点
                </div>
                <div class="panel-body">
                    <table class="table table-condensed  stafftable">
                        <tbody>
                        <tr>
                            <th width="20%">知识点<font color="red">*</font></th>
                            <td width="30%">
                                <input name="value[knowledge_point]"   value="" class="form-control" />
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>所属科目</th>
                            <td>
                                <select name="value[subjectid]" class="form-control" id="selSubject">
                                    <?php foreach($subject as $value) : ?>
                                        <option value="<?php echo $value['id'];?>">
                                            <?php echo $value['subject'];?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th>上级分类</th>
                            <td>
                                <select name="value[p_id]" class="form-control" id="selknowledge">
                                    <option value="0">顶级分类</option>
                                    <?php foreach($cates as $cate) : ?>
                                        <option value="<?php echo $cate['id'];?>">
                                            <?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$cate['level'])?>
                                            <?php echo $cate['knowledge_point'];?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <th ></th>
                            <td>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
</body>
</html>