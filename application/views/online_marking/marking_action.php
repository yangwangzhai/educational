<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/online_marking/css/marking.css" rel="stylesheet" type="text/css" />
    <script src="static/timetable/js/jquery-1.11.2.min.js" type="text/javascript"></script>
</head>
<script type="application/javascript">
    function score_save(){
        var id=$("#id").val();
        var title=$("#select  option:selected").text();
        var score=$("#score").val();
        $.ajax({
            url: "<?=$this->baseurl?>&m=score_save",   //后台处理程序
            type: "post",         //数据发送方式
            //dataType:"json",    //接受数据格式
            data:{id:id,title:title,score:score},  //要传递的数据
            success:function(data){
                $("#testscore"+id,window.parent.document).text(data);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown)
            {
                //alert(errorThrown);
            }
        });
    }
</script>
<body>
    <div class="test_paper">
        <img src="<?= $list['thumb']?>">
    </div>
    <div class="title">
        <select id="select">
            <option>第一题</option>
            <option>第二题</option>
            <option>第三题</option>
            <option>第四题</option>
            <option>第五题</option>
            <option>第六题</option>
            <option>第七题</option>
            <option>第八题</option>
            <option>第九题</option>
        </select>
    </div>
    <div class="score">
        <tr class="tr">
            <th>分数:</th>
            <td>
                <input id="id" type="hidden" value="<?= $id;?>"/>
                <input id="score" name="score" type="text" value=""/>
            </td>
        </tr>
    </div>
    <div class="save">
        <input type="submit" value="提交" onclick="score_save()">
    </div>


</body>
</html>