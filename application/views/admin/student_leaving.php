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
</head>
<body>
<div class="container-fluid">



        <!-- 1 -->
        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <h3 style="margin-top: 0;margin-bottom: 0">用户离校</h3>
            </div>
            <div class="panel-body text-left">

                <span style="font-weight: bold;">离校原因：</span>
                       <select class="form-control" name="value[leaving]" style="display: inline;width: auto">
                                <?=getSelect(config_item('leaving'))?>
                       </select>
            </div>
            <div class="panel-footer text-right">
                <input type="submit" name="" id="submit" value="离校"  class="btn btn-danger">
                <input type="submit" name="" value="取消" onclick="parent.$.fancybox.close();" class="btn btn-primary">
            </div>
        </div>
</div>

</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $('#submit').bind("click",function(){
            var leaving=$("select[name='value[leaving]']").val();
            var type=false;
            if(leaving==6)
            {
                if(!confirm('删除将不可恢复，您确定要删除吗？'))
                {
                    return false;
                }
                else
                {
                    type=true;
                }
            }
            $.ajax({
                url: "<?=$this->baseurl?>&m=leaving_save",
                type: "POST",
                dataType:"json",    //接受数据格式
                data:{id:<?=$id?>,leaving:leaving,type:type},
                success: function (data) {
                    if (data > 0) {

                        alert("离校成功！");
                        parent.$.fancybox.close();
                        parent.window.location.reload();
                    }
                    else {
                        alert("离校失败!");
                        parent.$.fancybox.close();
                        parent.window.location.reload();
                    }
                },
                error: function ErrorCallback(XMLHttpRequest, textStatus, errorThrown) {
                    //alert(errorThrown + ":" + textStatus);
                }
            });
        });
    });
</script>


