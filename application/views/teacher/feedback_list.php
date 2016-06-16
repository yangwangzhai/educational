<?php $this->load->view('admin/header');?>
    <link rel="stylesheet" type="text/css" href="static/js/fancybox/jquery.fancybox.css" />
    <script type="text/javascript" src="static/js/fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript">
        $(function($)
        {
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

            $('.fancybox').fancybox({
                padding : 10,

                autoScale:true,
                /*width:1024,
                height:768,*/
                openEffect: 'elastic'
            });

            $(".rectify").click(function(){
                var id=$(this).attr('data-id');
                dialog= dialog_url('<?=$this->baseurl?>&m=dialog&id='+id+'&type=rectify','教师回复整改意见');
            });


        });

    </script>


    <div class="mainbox">



	<span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            <input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn">
        </form>
	</span><input type="button" value=" <?=$this->name?> " class="btn"/>
        <form action="<?=$this->baseurl?>&m=delete" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0"
                   class="datalist fixwidth" id="sortTable">
                <tr>
                    <th width="30"></th>
                    <th width="30">ID</th>
                    <th width="60">进度</th>
                    <th width="80">反馈家长</th>
                    <th width="120">反馈对象</th>
                    <th width="120">反馈类型</th>
                    <th width="60">内容</th>
                    <th width="60">反馈时间</th>
                    <th width="150">反馈状态</th>
                    <th width="100">操作</th>
                </tr>

                <?php foreach($list as $key=>$r) {?>
                    <tr class="sortTr">
                        <td><input type="checkbox" name="delete[]" value="<?=$r['id']?>"
                                   class="checkbox" /></td>
                        <td><?=$r['id']?></td>
                        <td><a class="fancybox fancybox.iframe" href="<?=$this->baseurl?>&m=progress&id=<?=$r['id']?>">进度</a></td>
                        <td><?=$r['pname']?></td>
                        <td><?=$r['tname']?></td>
                        <td><?=$r['feedback_type']?></td>
                        <td><?=$r['content']?></td>
                        <td><?=$r['feedback_date']?></td>
                        <td>
                            <?php
                                switch($r['feedback_active'])
                                {
                                    case 2:
                                        echo "已提交/<font color='red'>待核实</font>";
                                        break;
                                    case 3:
                                        echo "已核实/<a href='javascript:void(0)' data-id='$r[id]' class='rectify'><font color='red'>待整改</font></a>";
                                        break;
                                    case 4:
                                        echo "已整改/<font color='red'>待审核</a>";
                                        break;
                                    case 5:
                                        echo "已审核/<font color='red'>待审阅</font>";
                                        break;
                                    case 6:
                                        echo "已完成";
                                        break;
                                }
                            ?>
                        </td>
                        <td>
                            <a href="<?=$this->baseurl?>&m=detail&id=<?=$r['id']?>">查看</a></td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="12"><input type="checkbox" name="chkall" id="chkall"
                                            onclick="checkall('delete[]')" class="checkbox" /><label
                            for="chkall">全选/反选</label>&nbsp; &nbsp;</td>
                </tr>
            </table>

            <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

        </form>

    </div>


<?php $this->load->view('admin/footer');?>