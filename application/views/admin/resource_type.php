
<!DOCTYPE html >
<html>
<head>
    <link href="/Content/TLNew/zgyey.css" rel="stylesheet" type="text/css" />
    <script  type="text/javascript" src="/Content/TLNew/TL-Core.js"></script>
    <script  type="text/javascript" src="/Content/TLNew/TL-More.js"></script>
    <link href="../../ContentNew/css/style.css?v=102" rel="stylesheet" type="text/css" />
    <script src="/Scripts/jquery-1.4.4.min.js" type="text/javascript"></script>
    <style>
        .assortK
        {
            text-align: left;
        }
    </style>
    <script language="javascript" type="text/javascript">


        window.document.domain = "zgyey.com";

        //注意input的id和tr的id要一样
        function addRowByID(currentRowID, dept) {
            var ie6 = 0;
            var undef,
                ie,
                v = 3,
                div = document.createElement('div'),
                all = div.getElementsByTagName('i');
            while (
                div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
                    all[0]
                );
            v > 4 ? ie = v : ie = undef;

            if (ie == 6 || ie == 7) {
                ie6 = 1;
            } else {
                ie6 = 0;
            }

            var trnewcount = 1;
            var tableObj = document.getElementById("clist");
            for (var i = 0; i < tableObj.rows.length; i++) {

                var currentid = tableObj.rows[i].id;
                if (currentid != "" && currentid != null) {
                    var index = currentid.toString().indexOf("_n");

                    if (index > 0) {
                        trnewcount = trnewcount + 1;
                    }
                }
            }

            //根目录情况下
            if (currentRowID == 0) {

                if (ie6 == 1) {
                    $("#clist").append("<tr id=\"o0_n" + trnewcount + "\" name=\"o0_n" + trnewcount + "\"> <td align=\"center\" class=\"td_r\" style=\"text-align:right;  \"><p style=\"text-align:left;width:320px; height:30px;\"><input type=\"hidden\" name=\"categoryid\" value=\"o0_n" + trnewcount + "\" /><input type=\"text\" name=\"name\" style=\"width:490px;\"  class=\"input_a1\"/></p></td><td width=\"170\"  align=\"center\"><a href=\"javascript:void(0);\" class=\"classify\" onclick=\"addRowByID('o0_n" + trnewcount + "',430)\">添加子分类</a></td><td ><a href=\"javascript:void(0);\" onclick=\"up('o0_n" + trnewcount + "');\" class=\"up\"></a></td><td  align=\"center\"><a href=\"javascript:void(0);\" onclick=\"down('o0_n" + trnewcount + "');\" class=\"down\"></a></td><td  align=\"center\"><a href=\"javascript:void(0);\" onclick=\"RemoveRow('o0_n" + trnewcount + "')\" class=\"del\"></a></td></tr>");
                } else {
                    $("#clist").append("<tr id=\"o0_n" + trnewcount + "\" name=\"o0_n" + trnewcount + "\"> <td align=\"center\" class=\"td_r\" style=\"text-align:right;  \"><input type=\"hidden\" name=\"categoryid\" value=\"o0_n" + trnewcount + "\" /><input type=\"text\" name=\"name\"  class=\"input_a1\"  style=\"width:490px;\"   /></td><td width=\"170\"  align=\"center\"><a href=\"javascript:void(0);\" class=\"classify\" onclick=\"addRowByID('o0_n" + trnewcount + "',430)\">添加子分类</a></td><td ><a href=\"javascript:void(0);\" onclick=\"up('o0_n" + trnewcount + "');\" class=\"up\"></a></td><td  align=\"center\"><a href=\"javascript:void(0);\" onclick=\"down('o0_n" + trnewcount + "');\" class=\"down\"></a></td><td  align=\"center\"><a href=\"javascript:void(0);\" onclick=\"RemoveRow('o0_n" + trnewcount + "')\" class=\"del\"></a></td></tr>");
                }

                if (isFirefox = navigator.userAgent.indexOf("Firefox") > 0) {
                    location.hash = "#o0_n" + trnewcount;
                } else {
                    document.getElementById("o0_n" + trnewcount).scrollIntoView();
                }
            }
            else {

//            var txtnamewidth = 160;
//            var nbsp = "";
//            if (dept == 2) {
//                txtnamewidth = 135;
//                nbsp = "";

//            }
//            else if (dept == 3) {
//                txtnamewidth = 118;
//                nbsp = "";
//            }


                var categoryid = currentRowID.toString().substring(currentRowID.toString().lastIndexOf("_") + 1);

                //dept = parseInt(dept) -30;
                var addtd = "<a href=\"javascript:void(0);\" class=\"classify\" onclick=\"addRowByID('" + categoryid + "_n" + trnewcount + "','" + (dept - 30) + "')\">添加子分类</a>";
                if (dept < 310) {
                    addtd = "";
                }


                var rowhtml;
                var tableObj1 = document.getElementById("clist");
                for (var i = 0; i < tableObj1.rows.length; i++) {
                    var rowid = tableObj1.rows[i].id.toString();
                    var rowparentid = rowid.substring(0, rowid.indexOf("_"));
                    if (rowparentid == categoryid) {
                        rowhtml = rowid;
                    }
                }
                if (rowhtml == "" || rowhtml == null)
                { rowhtml = currentRowID; }
                //上面已经找到了该目录下的名称ID


                //如果是上一级，找到他的子集，最后一个元素
                var parenthtml;
                var parentid = rowhtml.substring(rowhtml.indexOf("_") + 1);
                if (dept == 2) {
                    for (var i = 0; i < tableObj1.rows.length; i++) {
                        var rowid = tableObj1.rows[i].id.toString();
                        var rowparentid = rowid.substring(0, rowid.indexOf("_"));
                        if (rowparentid == parentid) {
                            parenthtml = rowid;
                        }
                    }
                }
                if (parenthtml != "" && parenthtml != null)
                { rowhtml = parenthtml; }


                //如果包含子类的话，那么寻找子类的下一个目的
                //临时的子标题的存在的话，添加的时候要访在子标题的后面
                var childid = rowhtml;
                var childhtml;
                childid = childid.substring(rowhtml.indexOf("_") + 1);
                for (var i = 0; i < tableObj1.rows.length; i++) {
                    var rowid = tableObj1.rows[i].id.toString();
                    var rowparentid = rowid.substring(0, rowid.indexOf("_"));
                    if (rowparentid == childid) {
                        childhtml = rowid;
                    }
                }

                if (childhtml != "" && childhtml != null)
                { rowhtml = childhtml; }



                if (ie6 == 1) {
                    $("#" + rowhtml).after("<tr id=\"" + categoryid + "_n" + trnewcount + "\"> <td align=\"center\" class=\"td_r\" style=\"text-align:right;  \"><p style=\"text-align:left;width:300px; height:30px;maigin:0px; padding:0px; \"><input type=\"hidden\" name=\"categoryid\" value=\"" + categoryid + "_n" + trnewcount + "\" /><input type=\"text\" name=\"name\" style=\"width:" + dept + "px;margin-right:5px;\" class=\"input_a2\"/></p></td><td  >" + addtd + "<input type=\"checkbox\" name=\"display\" value=\"" + categoryid + "_n" + trnewcount + "\"  checked=\"checked\" style=\"display:none\" /></td><td><a href=\"javascript:void(0);\" onclick=\"up('" + categoryid + "_n" + trnewcount + "');\" class=\"up\"></a></td><td align=\"center\"><a href=\"javascript:void(0);\" onclick=\"down('" + categoryid + "_n" + trnewcount + "');\" class=\"down\"></a></td><td align=\"center\"><a href=\"javascript:void(0);\" onclick=\"RemoveRow('" + categoryid + "_n" + trnewcount + "')\" class=\"del\"></a></td></tr>");
                } else {
                    $("#" + rowhtml).after("<tr id=\"" + categoryid + "_n" + trnewcount + "\"> <td align=\"center\" class=\"td_r\" style=\"text-align:right;  \"><input type=\"hidden\" name=\"categoryid\" value=\"" + categoryid + "_n" + trnewcount + "\" /><input type=\"text\" name=\"name\" style=\"width:" + dept + "px;margin-right:5px;\" class=\"input_a2\"/></td><td  >" + addtd + "<input type=\"checkbox\" name=\"display\" value=\"" + categoryid + "_n" + trnewcount + "\"  checked=\"checked\" style=\"display:none\" /></td><td><a href=\"javascript:void(0);\" onclick=\"up('" + categoryid + "_n" + trnewcount + "');\" class=\"up\"></a></td><td align=\"center\"><a href=\"javascript:void(0);\" onclick=\"down('" + categoryid + "_n" + trnewcount + "');\" class=\"down\"></a></td><td align=\"center\"><a href=\"javascript:void(0);\" onclick=\"RemoveRow('" + categoryid + "_n" + trnewcount + "')\" class=\"del\"></a></td></tr>");

                }
            }
        }

        function movelist(currentid) {

            $("#firstmove").append("<tr id=\"" + currentid + "\">" + $("#" + currentid).html() + "</tr>");
            var currentparentindex = currentid.toString().lastIndexOf("_");
            var currentparentid = currentid.toString().substring(currentparentindex + 1);
            var currentRow = $("#" + currentid);
            var tableObj = document.getElementById("clist");
            for (var i = 0; i < tableObj.rows.length; i++) {
                var rowid = tableObj.rows[i].id.toString();
                var rowparentindex = rowid.indexOf("_");
                var rowparentid = rowid.substring(0, rowparentindex);

                if (currentparentid == rowparentid) {
                    movelist(rowid);
                }

            }

        }






        function up(btn) {

            //获取一个ID列表，标识当前的按钮下以及所有子类的数值
            var mylist = btn;         //获取当前的table所有的行
            var tableObj = document.getElementById("clist");

            var booltrue = 0;
            var booltrue_1 = 0;
            var booltrue_2 = 0;
            var parentid = btn.toString().split("_")[1];



            for (var i = 1; i < tableObj.rows.length; i++) {
                var currentid = tableObj.rows[i].id; //循环的ID
                var index1 = currentid.toString().split("_")[0];
                if (index1 == parentid) {
                    booltrue = 1;
                } else {
                    booltrue = 0;
                }

                if (booltrue == 1) {
                    mylist = mylist + "," + currentid;
                    var childpid = currentid.toString().split("_")[1];
                    var boolchild = 0;
                    //是否存在子类
                    for (var j = 1; j < tableObj.rows.length; j++) {
                        var currentchildid = tableObj.rows[j].id;
                        var childid = currentchildid.toString().split("_")[0];
                        if (childid == childpid) {
                            boolchild = 1;
                        }
                    }
                    if (boolchild == 1) {
                        mylist=upset(mylist, tableObj, childpid);
                    }

                }
            }


            var beforeid; //前面一个ID
            for (var i = 1; i < tableObj.rows.length; i++) {
                var c1 = tableObj.rows[i].id; //循环的ID
                var x1 = c1.toString().split("_")[0];
                if (x1 == btn.toString().split("_")[0]) {
                    if (c1 == btn) {
                        break;
                    }
                    beforeid = tableObj.rows[parseInt(i)-1].id;
                }
            }


            //前面不是最顶部
            if (beforeid != null && beforeid != "undefined") {

                var myarray = mylist.split(",");
                for (var i = myarray.length-1; i >=0; i--) {
                    $("#" + beforeid).after($("#" + myarray[i]));
                }
            }



        }

        function upset(mylist, tableObj, parentid) {

            for (var i = 1; i < tableObj.rows.length; i++) {
                var currentid = tableObj.rows[i].id; //循环的ID
                var index1 = currentid.toString().split("_")[0];
                if (index1 == parentid) {
                    booltrue = 1;
                } else {
                    booltrue = 0;
                }

                if (booltrue == 1) {
                    mylist = mylist + "," + currentid;
                    var childpid = currentid.toString().split("_")[1];
                    var boolchild = 0;
                    //是否存在子类
                    for (var j = 1; j < tableObj.rows.length; j++) {
                        var currentchildid = tableObj.rows[j].id;
                        var childid = currentchildid.toString().split("_")[0];
                        if (childid == childpid) {
                            boolchild = 1;
                        }
                    }
                    if (boolchild == 1)
                    {
                        mylist=upset(mylist, tableObj, childpid);
                    }

                }
            }
            return mylist;
        }

        function down(btn) {

            //获取一个ID列表，标识当前的按钮下以及所有子类的数值
            var mylist = btn;         //获取当前的table所有的行
            var tableObj = document.getElementById("clist");
            var nextid; //后面一个ID
            var nx = 0;
            for (var i = 1; i < tableObj.rows.length; i++) {
                var c1 = tableObj.rows[i].id; //循环的ID
                var x1 = c1.toString().split("_")[0];
                if (x1 == btn.toString().split("_")[0]) {
                    if (nx == 1) {
                        nextid = c1;
                        break;
                    }
                    if (c1 == btn) {
                        nx = 1;
                    }
                }
            }

            up(nextid);
        }

        function RemoveRow(id) {
            var haschild;
            var tableObj = document.getElementById("clist");
            for (var i = 0; i < tableObj.rows.length; i++) {
                var currentid = tableObj.rows[i].id;
                var index1 = currentid.toString().indexOf("_");
                var index2 = id.toString().lastIndexOf("_");
                if (currentid.toString().substring(0, index1) == id.toString().substring(index2 + 1)) {
                    haschild = true;
                    break;
                }
            }
            if (haschild) {
                alert("此分类下有子分类,不能删除!");
                return false;
            }
            else {
                var currentRow = $('#' + id);
                currentRow.remove();
            }
        }



        function GetThelpDocCategoryListAjax() {

            jQuery.ajax({
                url: "/PersonalDocNew/GetThelpDocCategoryListAjax",
                type: "POST",
                success: function (data) {
                    $("#clist").html(data);
                },
                error: function ErrorCallback(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown + ":" + textStatus);
                }
            });
        }

        $(document).ready(function () {
            GetThelpDocCategoryListAjax();
        });


    </script>

</head>
<body>
<input id="confirm_url" name="confirm_url" type="hidden" value="" />


<div class="r_pop_gl" style="margin-top:-150px" >
    <div class="title"><p class="left">文档目录管理</p>

        <a href="javascript:void(0);" onclick="addRowByID('0','0');" class="classify_zong">添加新分类</a>

        <a href="javascript:parent.winObj.close()" class="close" ></a></div>


    <div class="p_div">
        <table width="960" border="0" cellspacing="0" cellpadding="0" class="table">
            <tr>
                <th width="520">标题</th>
                <th width="130">添加子分类</th>
                <th width="100">上移</th>
                <th width="100">下移</th>
                <th width="100">删除	</th>
            </tr>
        </table>



        <div class="line">
            <form action="/PersonalDoc/ThelpDocCategoryListSava" id="form1" method="post" name="form1">            <table width="960" border="0" cellspacing="0" cellpadding="0" class="table">
                    <tbody id="clist">

                    </tbody>
                </table>
            </form>        </div>

        <div class="release_btn" style=" margin:10px auto;"><a  href="#" onclick="Save();" id="save" class="en">保存</a><a href="javascript:parent.winObj.close()">取 消</a></div>
    </div>


</div>

</body></html>





<div id="right768" style="display:none">
    <!-- right begin -->
    <div class="overflow">
        <div class="goodsButton">
            <a href="javascript:void(0);" onclick="javascript:addRowByID('0','0');" class="classify">添加新分类</a>

        </div>

        <div class="line">


        </div>

        <div class="release_btn" style=" margin:10px auto;"><a  href="#" onclick="Save();" id="save" class="en">保存</a><a href="javascript:parent.winObj.close()">取 消</a></div>


    </div>
    <!-- right end -->
    <script language="javascript" type="text/javascript">
        var jQuery = $;
        function RemoveCategoryId_do() {
            var id=document.getElementById("confirm_url").value;
            var haschild;
            var tableObj = document.getElementById("clist");
            for (var i = 0; i < tableObj.rows.length; i++) {
                var currentid = tableObj.rows[i].id;
                var index1 = currentid.toString().indexOf("_");
                var index2 = id.toString().lastIndexOf("_");
                if (currentid.toString().substring(0, index1) == id.toString().substring(index2 + 1)) {
                    haschild = true;
                    break;
                }
            }
            if (haschild) {
                showmsg("此分类下有子分类,不能删除!");
                return false;
            }
            else {
                var current = id.toString().substring(id.toString().lastIndexOf("_") + 2);

                jQuery.ajax({
                    type: "POST",
                    url: "/PersonalDocNew/AjaxRemoveTHelpCategory/",
                    contentType: "application/json; charset=utf-8",
                    data: "{categoryid: '" + current + "'}",
                    dataType: "json",
                    success: function (data) {
                        if (data > 0) {
                            showmsg("删除成功!");
                            window.location.href = "/PersonalDocNew/ThelpDocCategoryList/";
                        }
                        else if (data == (-2)) {
                            showmsg_win.close();
                            showmsg("此分类下有文档,不能删除!");
                        }
                    }
                })
            }

        }

        function RemoveCategoryId(id) {
            showmsg_confirm("确定要删除此分类吗", "RemoveCategoryId_do");
            document.getElementById("confirm_url").value = id;
        }

        var showmsg_win;
        function showmsg_confirm(msg, dofun) {
            var url = "/PersonalDocNew/ConfirmWin?msg=" + escape(msg) + "&dofun=" + dofun;
            showmsg_win = new TL.win({
                type: 7,
                title: "提示",
                url: url,
                width: 520,
                height: 300,
                skin: "blue"
            });
        }
        function showmsg(msg) {
            var url = "/PersonalDocNew/AlertWin?msg=" + escape(msg);
            showmsg_win = new TL.win({
                type: 7,
                title: "提示",
                url: url,
                width: 520,
                height: 300,
                skin: "blue"
            });
        }



        function Save() {
            var nosave = false;
            var str = "";
            $("[name='name']").each(function () {
                if ($(this).val() == "" || $(this).val() == null) {
                    nosave = true;
                }
            })
            if (nosave) {
                alert("分类名称不能为空!");
                return false;
            }

            $("#save").hide();
            //alert('正在保存,请稍等!');
            document.getElementById('form1').submit();
            //var v = $("[name='name']").length;

        }

    </script>
