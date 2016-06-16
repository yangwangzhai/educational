<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?=PRODUCT_NAME?>-园长端</title>

    <!-- Bootstrap -->
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            $("#grade").bind("change",function(){
                var value=$(this).val();
                if(value==0)
                {
                    $("#class").html("<option value='0'>未选择</option>");
                }
                else
                {
                    $.ajax({
                        url:"index.php?&d=admin&c=classroom&m=ajaxclass",
                        type:"post",
                        dataType:"json",
                        data:{grade:value},
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
            $("#submit").bind("click",function(){
                var grade=$("#grade").val();
                var classid=$("#class").val();
                location.href="<?=$this->baseurl?>&m=export&grade="+grade+"&classid="+classid;
            });
        });
    </script>
</head>
<body>
<div class="container-fluid">
    <!-- 1 -->
    <div class="panel panel-default">
        <div class="panel-heading text-left">
            <h3 style="margin-top: 0;margin-bottom: 0">家长导出</h3>
        </div>
        <div class="panel-body text-left">

            <span style="font-weight: bold;">选择年级：</span>
            <select class="form-control" name="value[grade]" id="grade" style="display: inline;width: auto">
                <?=getSelect($grade)?>
            </select>
            <span style="font-weight: bold;">选择班级：</span>
            <select class="form-control" name="value[class]" id="class" style="display: inline;width: auto">
                <option value="0">未选择</option>
            </select>
        </div>
        <div class="panel-footer text-right">
            <input type="submit" name="" id="submit" value="导出"  class="btn btn-success">
            <input type="submit" name="" value="取消" onclick="parent.$.fancybox.close();" class="btn btn-primary">
        </div>
    </div>
</div>
</body>
</html>


