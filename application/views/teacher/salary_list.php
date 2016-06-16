<?php $this->load->view('teacher/header');?>
    <style type="text/css">
        .styled-select {
            margin: 15px 15px;
            width: 150px;
            height: 34px;
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
        .btn-xs, .btn-group-xs>.btn {
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .bg-green {
            background-color: #00a65a !important;
        }
        .bg-red, .bg-yellow, .bg-aqua, .bg-blue, .bg-light-blue, .bg-green, .bg-navy, .bg-teal, .bg-olive, .bg-lime, .bg-orange, .bg-fuchsia, .bg-purple, .bg-maroon, .bg-black {
            color: #f9f9f9 !important;
        }
        a {
            color: #428bca;
            text-decoration: none;
        }
        a {
            background: 0 0;
        }
    </style>
    <script type="text/javascript">
        $(function($)
        {
            $(".styled-select").bind("change",function(){
                var value=$(this).val();
                location.href="<?=$this->baseurl?>&m=index&month=<?=$month?>&year="+value;
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


            // 点击更改状态
            $(".updatestatus").click(function(){
                var tid = $(this).attr("name");
                var mystatus = 0;
                if($(this).text() == "已审")
                {
                    $(this).text("未审");
                    $(this).addClass("red");
                } else {
                    mystatus = 1;
                    $(this).text("已审");
                    $(this).removeClass("red");
                }

                $.get("<?=$this->baseurl?>&m=updatestatus", { id: tid, status: mystatus },function(data){

                });
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
        });

    </script>
    <div class="mainbox">
        <table style="BORDER:#ddd 1px solid; margin-bottom: 20px"  cellSpacing=1 cellPadding=1 width="100%" border=1>
            <tr>
                <td width="100%" height="20">
                    <select name="year" class="styled-select">
                        <?php echo getSelect(config_item("YEAR"),$year)?>
                    </select>
                    <?php foreach(config_item("MONTH") as $k=>$val):?>
                        <a class="btn-flat btn-xs <?php if($month==$k)echo 'bg-green'?>" href="<?=$this->baseurl?>&m=index&month=<?=$k?>&year=<?=$year?>"><?php echo $val?></a>
                    <?php endforeach;?>
                    <input type="button" value="打印<?=$this->name?>" class="btn"
                           onclick="location.href='<?=$this->baseurl?>&m=export'"
                        />
                </td>
            </tr>
        </table>

        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0"
                   class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="10"></th>
                    <th width="100">姓名</th>
                    <th width="100">工资</th>
                    <th width="100">加班费</th>
                    <th width="80">奖金</th>
                    <th width="120">其他补贴</th>
                    <th width="120">高温津贴</th>
                    <th width="130">养老保险金</th>
                    <th width="150">医疗保险金</th>
                    <th width="150">失业保险金</th>
                    <th width="150">住房公积金</th>
                    <th width="120">无薪假期</th>
                    <th width="150">个人所得税</th>
                    <th width="120">其他调整</th>
                    <th width="120">实发薪金</th>
                    <th width="120">操作</th>
                </tr>

                <?php foreach($list as $key=>$r) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                                   class="checkbox" /></td>

                        <td><a href="<?=$this->baseurl?>&m=chart&id=<?=$r['id']?>"><?=$this->teacher['truename']?></a></td>
                        <td><?=$r['basic']?></td>
                        <td><?=$r['overtime']?></td>
                        <td><?=$r['bonus']?></td>
                        <td><?=$r['othersubsidy']?></td>
                        <td><?=($r['highsubsidy'])?></td>
                        <td><?=$r['retire']?></td>
                        <td><?=$r['medical']?></td>
                        <td><?=$r['unemployeed']?></td>
                        <td><?=$r['housing']?></td>
                        <td><?=$r['nosalary']?></td>
                        <td><?=$r['tax']?></td>
                        <td><?=$r['adjust']?></td>
                        <td><?=$r['total']?></td>
                        <td>
                            <a href="<?=$this->baseurl?>&m=chart&id=<?=$r['id']?>">查看</a>&nbsp;&nbsp;
                                </td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="17"><input type="checkbox" name="chkall" id="chkall"
                                            onclick="checkall('delete[]')" class="checkbox" /><label
                            for="chkall">全选/反选</label>&nbsp; &nbsp;</td>
                </tr>
            </table>

            <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

        </form>

    </div>


<?php $this->load->view('teacher/footer');?>