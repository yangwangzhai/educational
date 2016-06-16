<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="static/js/common.js?1"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            $("#submit").bind("click",function(){
                var arr=[];
                var arrname=[];
                var i=0;
                $("input[name='delete']:checkbox:checked").each(function(){
                    arr[i]=$(this).val();
                    arrname[i]=$(this).attr('data-title');
                    i++;
                });
                if(arr.length==0)
                {
                    alert('你未选择任何教师');
                    return false;
                }
                $.ajax({
                    url: "<?=$this->baseurl?>&m=teacher_save",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{train_id:<?=$train_id?>,arr:arr},  //要传递的数据
                    success:function(data){
                        if(data==1)
                        {
                            parent.document.getElementById('teachername').value = arrname;
                            parent.dialog.remove();
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        alert(errorThrown);
                    }
                });
            });
        });
    </script>
</head>
<body class="laydate_body">

    <div class="container-fluid">
        <div style=" margin:20px; font-size:13px;">
            <style>
                .tablecourse th {
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
                <div class="panel-heading">
                   选择教师
                </div>

                <div class="panel-body">


                    <table class="table table-condensed tablecourse">

                        <tbody>

                        <tr>
                        <?php foreach($list as $k=>$item):?>
                            <?php if($k%3==0 AND $k>0) echo '<tr>'?>
                            <th>
                                <?=$item['truename']?>
                            </th>
                            <td>
                                <input name="delete" data-title="<?=$item['truename']?>" <?=$item['train']?> type="checkbox" value="<?=$item['id']?>" >
                            </td>
                        <?php endforeach;?>
                        </tr>
                        <tr>
                            <th></th>
                            <td><input style="width: 10%;display: inline" type="checkbox" name="chkall" id="chkall"
                                       onclick="checkall('delete')" class="checkbox" /><label
                                    for="chkall">全选/反选</label></td>
                            <th></th>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody></table>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body text-center">

                        <input type="submit" id="submit" value="提交"  class="btn btn-primary">
                        <input type="button" name="" value="关闭" onclick="parent.dialog.remove();" class="btn btn-danger">
                    </div>
                </div>
            </div>
        </div></div></body></html>