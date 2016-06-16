<!DOCTYPE html>
<html>
<head>
    <title>学籍信息</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="static/js/fancybox/jquery.fancybox.css" />
    <script type="text/javascript" src="static/js/fancybox/jquery.fancybox.js"></script>
    <link rel="stylesheet"	href="static/js/kindeditor410/themes/default/default.css" />
    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <script type="text/javascript" src="static/js/common.js?v=1"></script>
    <style type="text/css">
        .form-control {
            display: inline;
            width: auto;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        }
    </style>
    <script type="text/javascript">
        $(function($)
        {
            $('.fancybox').fancybox({
                padding : 10,
                autoScale:true,
                /*width:768,*/
                openEffect: 'elastic'
            });
            // 数据列表 点击开始排序
            var sortFlag = 0;
            $("#sortTable th").click(function()
            {
                var tdIndex = $(this).index();
                var temp = "";
                var trContent = new Array();
                //alert($(this).text());

                // 把要排序的字符放到行的最前面，方便排序
                $("#sortTable .sortTr").each(function(i){
                    temp = "##" + $(this).find("td").eq(tdIndex).text() + "##";
                    trContent[i] = temp + '<tr class="sortTr">' + $(this).html() + "</tr>";
                });

                // 排序
                if(sortFlag==0) {
                    trContent.sort(sortNumber);
                    sortFlag = 1;
                } else {
                    trContent.sort(sortNumber);
                    trContent.reverse();
                    sortFlag = 0;
                }

                // 删除原来的html 添加排序后的
                $("#sortTable .sortTr").remove();
                $("#sortTable tr").first().after( trContent.join("").replace(/##(.*?)##/, "") );
            });


            $("#del").click(function(){
                var arr=[];
                var i=0;
                $("input[name='delete[]']:checkbox:checked").each(function(){
                    arr[i]=$(this).val();
                    i++;
                });
                if(arr.length==0)
                {
                    alert('你未选择任何表');
                    return false;
                }
                if(confirm('确定要删除吗？'))
                {
                    return true;
                }
                return false;
            });
            $("#import").click(function(){
                dialog= dialog_url("<?=$this->baseurl?>&m=import",'导入学生',468,440);
            });
            $("#sel").bind("change",function(){
                var value=$(this).val();
                location.href="<?=$this->baseurl?>&m=index&status="+value;
            });
            $("#teach_activity_add").on("click",function(){
                location.href="<?=$this->baseurl?>&m=add";
            });
            $('#student_down').on('click',function(){
                location.href="uploads/excel/import/student.xls";
            });
            $('#excel_down').on('click',function(){
                location.href="<?=$this->baseurl?>&m=export";
            });

            //根据年级，异步获取班级
            $("#selGrade").on("change",function(){
                var grade=$("#selGrade").val();
                $.ajax({
                    url: "index.php?d=timetable&c=timetable&m=get_class_message",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{grade:grade},  //要传递的数据
                    success:function(data){
                        $("#selclass").children().remove();
                        $("#selclass").append("<option value=未选择>未选择</option>");
                        $.each(data,function(key,val){
                            $("#selclass").append("<option value="+val+">"+val+"</option>");
                        });
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        //alert(errorThrown);
                    }
                });
            });

        });
    </script>
</head>
<body>
<div style="margin-left: 10px;margin-top: 20px;">
    <button type="button" class="btn btn-info" id="teach_activity_add">+学生</button>
    <button type="button" class="btn btn-info" id="student_down">下载学生表</button>
    <button type="button" class="btn btn-info" id="import">导入学生</button>
    <button type="button" class="btn btn-info" id="excel_down">Excel导出</button>
    <span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            年级<select name="grade" id="selGrade">
                <option value="0">未选择</option>
                <option value="2013"<?php if($grade==2013){echo "selected=selected";}?>>2013</option>
                <option value="2014"<?php if($grade==2014){echo "selected=selected";}?>>2014</option>
                <option value="2015"<?php if($grade==2015){echo "selected=selected";}?>>2015</option>
            </select>&nbsp&nbsp
            班级<select name="class" id="selclass">
                <?php for($i=1;$i<=$class_num;$i++){?>
                    <option value="<?=$i?>" <?php if($class==$i){echo "selected=selected";}?>><?=$i?></option>
                <?php }?>
            </select>&nbsp&nbsp
            <input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn-success">
        </form>
	</span>
    <hr style="margin-bottom: 5px;margin-top: 5px;"/>
</div>
<div style="margin-left: 10px;margin-bottom: 0px;">
    <table class="table table-hover">
        <thead>
        <tr>
            <th width="40">编号</th>
            <th width="60">姓名</th>
            <th width="60">班级</th>
            <th width="60">学籍号</th>
            <th width="60">性别</th>
            <th width="60">籍贯</th>
            <th width="60">政治面貌</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $key=>$r) :?>
            <tr>
                <td><?=$key+1?></td>
                <td>
                    <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>"><?=$r['name']?></a>
                </td>
                <td><?=$r['classname']?></td>
                <td><?=$r['number']?></td>
                <td><?=$r['gender']?></td>
                <td><?=$r['place']?></td>
                <td><?=$r['political_status']?></td>
                <td>
                    <a href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<div style="margin-left: 10px;margin-top: -15px;">
    <hr style="margin-bottom: 0px;margin-top:0px;"/>
</div>
<div style="margin-left: 10px;margin-top: 10px;">
    <tr><?php echo $pages; ?></tr>
</div>
</body>
</html>
