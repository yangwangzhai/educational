<?php $this->load->view('admin/header');?>
    <link rel="stylesheet" type="text/css" href="static/admin_img/parentstyle.css">
    <script type="text/javascript" src="static/js/jquery-1.7.2.min.js"></script>
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function in_array(search,array){
            for(var i in array){
                if(array[i]==search){
                    return true;
                }
            }
            return false;
        }
        function GetSelecteds() {

            var j=0;
            var sel = [];
            $(".select-list dd").each(function () {
                if($(this).hasClass("selected"))
                {
                    /*result += $(this).text()+"-";*/
                    sel[j]=$(this).children().attr("data-val");
                    j++;
                }
            });
            location.href="index.php?d=admin&c=parents&m=main&data="+sel;

        }
        function SetSelecteds() {
            <?php foreach($volunteer as $key=>$item):?>
            var arr<?php echo $key?>=[]
                <?php foreach($item as $kk=>$v):?>
                    arr<?php echo $key?>[<?php echo $kk?>]='<?php echo $v['id']?>'
                <?php endforeach;?>
            <?php endforeach;?>
            var ar=[];
            <?php foreach($selected as $k=>$v):?>
            ar[<?php echo $k?>]='<?php echo $v?>'
                <?php endforeach;?>
            $(".select-list dd").each(function () {
                var aa=$(this).children().attr("data-val");
                if(in_array(aa,ar))
                {
                    $(this).addClass("selected");
                    var copyThis = $(this).clone();
                    if(in_array(aa,arr1))
                    {
                        $(".select-result dl").append(copyThis.attr("id", "selectA"));
                    }
                    if(in_array(aa,arr2))
                    {
                        $(".select-result dl").append(copyThis.attr("id", "selectB"));
                    }
                    if(in_array(aa,arr3))
                    {
                        $(".select-result dl").append(copyThis.attr("id", "selectC"));
                    }
                }

            });

            if ($(".select-result dd").length > 1) {
                $(".select-no").hide();
            } else {
                $(".select-no").show();
            }
        }
        $(document).ready(function(){
            SetSelecteds();
            $("#select1 dd").click(function () {
                if ($(this).hasClass("select-all")) {
                    $(this).addClass("selected").siblings().removeClass("selected");
                    /*$("#selectA").remove();*/
                    $("#selectA a").each(function () {
                        $("#selectA").remove();
                    });
                    GetSelecteds();
                } else {
                    $(this).addClass("selected");
                    $("#select1 dd").each(function () {
                        if ($(this).hasClass("select-all")) {
                            $(this).removeClass("selected");
                        }
                    });
                    GetSelecteds();
                    var copyThisA = $(this).clone();

                    if ($("#selectA").length > 0) {
                        var arr = [];
                        var i=0;
                        $("#selectA a").each(function () {

                            arr[i]=$(this).text();
                            i++;
                        });
                        if(in_array(copyThisA.text(),arr)==false)
                        {
                            $(".select-result dl").append(copyThisA.attr("id", "selectA"));
                        }
                    } else {
                        $(".select-result dl").append(copyThisA.attr("id", "selectA"));
                    }
                }
            });

            $("#select2 dd").click(function () {
                if ($(this).hasClass("select-all")) {
                    $(this).addClass("selected").siblings().removeClass("selected");
                    $("#selectB a").each(function () {
                        $("#selectB").remove();
                    });
                    GetSelecteds();
                } else {
                    $(this).addClass("selected");
                    $("#select2 dd").each(function () {
                        if ($(this).hasClass("select-all")) {
                            $(this).removeClass("selected");
                        }
                    });
                    GetSelecteds();
                    var copyThisB = $(this).clone();

                    if ($("#selectB").length > 0) {
                        var arr = [];
                        var i=0;
                        $("#selectB a").each(function () {

                            arr[i]=$(this).text();
                            i++;
                        });
                        if(in_array(copyThisB.text(),arr)==false)
                        {
                            $(".select-result dl").append(copyThisB.attr("id", "selectB"));
                        }
                    } else {
                        $(".select-result dl").append(copyThisB.attr("id", "selectB"));
                    }
                }
            });

            $("#select3 dd").click(function () {
                if ($(this).hasClass("select-all")) {
                    $(this).addClass("selected").siblings().removeClass("selected");
                    $("#selectC a").each(function () {
                        $("#selectC").remove();
                    });
                    GetSelecteds();
                } else {
                    $(this).addClass("selected");
                    $("#select3 dd").each(function () {
                        if ($(this).hasClass("select-all")) {
                            $(this).removeClass("selected");
                        }
                    });
                    GetSelecteds();
                    var copyThisC = $(this).clone();

                    if ($("#selectC").length > 0) {
                        var arr = [];
                        var i=0;
                        $("#selectC a").each(function () {

                            arr[i]=$(this).text();
                            i++;
                        });
                        if(in_array(copyThisC.text(),arr)==false)
                        {
                            $(".select-result dl").append(copyThisC.attr("id", "selectC"));
                        }
                    } else {
                        $(".select-result dl").append(copyThisC.attr("id", "selectC"));
                    }
                }
            });

            $("#selectA").live("click", function () {
                var copyThisA = $(this).clone();
                $(this).remove();
                if ($("#selectA").length > 0) {
                    $("#select1 dd").each(function () {
                        if(copyThisA.text()==$(this).text())
                        {
                            $(this).removeClass("selected");
                        }
                    });
                } else {
                    $("#select1 .select-all").addClass("selected").siblings().removeClass("selected");
                }
                GetSelecteds();
            });

            $("#selectB").live("click", function () {
                var copyThisB = $(this).clone();
                $(this).remove();
                if ($("#selectB").length > 0) {
                    $("#select2 dd").each(function () {
                        if(copyThisB.text()==$(this).text())
                        {
                            $(this).removeClass("selected");
                        }
                    });
                } else {
                    $("#select2 .select-all").addClass("selected").siblings().removeClass("selected");
                }
                GetSelecteds();
            });

            $("#selectC").live("click", function () {
                var copyThisC = $(this).clone();
                $(this).remove();
                if ($("#selectC").length > 0) {
                    $("#select3 dd").each(function () {
                        if(copyThisC.text()==$(this).text())
                        {
                            $(this).removeClass("selected");
                        }
                    });
                } else {
                    $("#select3 .select-all").addClass("selected").siblings().removeClass("selected");
                }
                GetSelecteds();
            });

            $(".select dd").live("click", function () {
                if ($(".select-result dd").length > 1) {
                    $(".select-no").hide();
                } else {
                    $(".select-no").show();
                }
            });
        });
    </script>

    <ul class="select">
    <?php foreach($volunteer as $key=>$item):?>
        <li class="select-list">
            <dl id="select<?php echo $key?>">
        <dt><?php echo config_item('volunteer_type')[$key]?>：</dt>
        <dd class="select-all"><a href="javascript:void(0);" data-val="all<?php echo $key?>">不限</a></dd>
        <?php foreach($item as $val):?>
                <dd><a href="javascript:void(0);" data-val="<?php echo $val['id']?>"><?php echo $val['title']?></a></dd>
        <?php endforeach;?>
            </dl>
        </li>
    <?php endforeach;?>
        <li class="select-result">
            <dl>
                <dt>已选条件：</dt>
                <dd class="select-no">暂时没有选择过滤条件</dd>
            </dl>
        </li>
    </ul>

    <div style="margin-left: 10px;margin-bottom: 0px;">
        <table class="table table-hover">
            <thead>
            <tr>
                <th style="width: 130px;">序号</th>
                <th style="width: 130px;">家长姓名</th>
                <th style="width: 130px;">学生姓名</th>
                <th style="width: 130px;">班级</th>
                <th style="width: 130px;">联系电话</th>
                <th style="width: 130px;">义工内容</th>
                <th style="width: 130px;">备注</th>
                <th style="width: 130px;">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $key=>$r) :?>
                <tr>
                    <td><?=$key+1?></td>
                    <td><?=$r['username']?></td>
                    <td><?=$r['studentname']?></td>
                    <td><?=$r['nickname']?></td>
                    <td><?=$r['tel']?></td>
                    <td><?=$r['volunteer']?></td>
                    <td><?=$r['content']?></td>
                    <td>
                        <a href="<?=$this->baseurl?>&m=edit&id=<?=$r['id']?>">修改</a>&nbsp;&nbsp;
                        <a href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
                    </td>
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

                $.get("<?=$this->baseurl?>&m=update_status", { id: tid, status: mystatus },function(data){

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
<?php $this->load->view('admin/footer');?>