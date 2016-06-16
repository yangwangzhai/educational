<?php $this->load->view('admin/header');?>
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <style>
        button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
    </style>
    <script>
        var ue = UE.getEditor('editor');
        $(document).ready(function(){
            // 日期
            $('#pubdate').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
        });
    </script>
    <div class="mainbox nomargin">
        <form id="form" action="<?=$this->baseurl?>&m=save" method="post">
            <input type="hidden" name="id" value="<?php echo $id?>"/>
            <input type="hidden" name="value[content]" id="content" value='<?php echo $value['content']?>'>
            <table width="99%" border="0" cellpadding="3" cellspacing="0" class="opt">
                <tr>
                    <td width="90">食品名称<font color="red">*</font></td>
                    <td width="280"><input type="text" class="txt" name="value[title]"
                                           value="<?php echo $value['title']?>" /></td>
                    <td width="90">采购时间</td>
                    <td ><input type="text" class="txt" name="value[dodate]"
                                id="pubdate"  value="<?php echo $value['dodate']?>" /></td>
                </tr>
                <tr>
                    <td width="90">单位</td>
                    <td width="280"><input type="text" class="txt" name="value[unity]"
                                           value="<?php echo $value['unity']?>" /></td>
                    <td width="90">单价</td>
                    <td ><input type="text" class="txt" name="value[price]"
                                value="<?php echo $value['price']?>" /></td>
                </tr>
                <tr>
                    <td width="90">数量</td>
                    <td width="280"><input type="text" class="txt" name="value[num]"
                                           value="<?php echo $value['num']?>" /></td>
                    <td width="90">合计</td>
                    <td ><input type="text" class="txt" name="value[total]"
                                value="<?php echo $value['total']?>" /></td>
                </tr>
                <tr>
                    <th width="90">跟进人</th>
                    <td width="280"><input type="text" class="txt" name="value[username]"
                                           value="<?php echo $value['username']?>" /></td>
                </tr>
                <tr>
                    <td>备注</td>
                    <td colspan="3"><script id="editor" type="text/plain" style="width:850px;height:250px;"></script></td>
                </tr>

                <tr>
                    <th>&nbsp;</th>
                    <td colspan="3"><input id="sub" type="button" name="s" value=" 提 交 " class="btn"
                                           tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
                                                                                    name="canc" value=" 取消 " class="btn"
                                                                                    onclick="javascript:history.back();" /></td>
                </tr>
            </table>
        </form>

    </div>
    <script type="text/javascript">
        $(function() {
            var contentVal = $("#content").val();
            ue.addListener("ready", function () {
                ue.setContent(contentVal);
            });

            $("#sub").click(function(){
                var content = getContent();
                $("#content").val(content);

                $("#form").submit();
            });
        });

        function getContent() {
            var arr = [];
            arr.push(UE.getEditor('editor').getContent());
            return arr;
        }
    </script>
<?php $this->load->view('admin/footer');?>