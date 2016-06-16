<?php $this->load->view('admin/header');?>

    <script>
        function insert_td(){
            var label_name= $(".txt").val();
            $("#show",window.parent.document).append("<input class='middle_label_input' type='button' data-check='false' value="+label_name+">");
            return true;
        }
    </script>

    <div class="mainbox nomargin">
        <form action="<?=$this->baseurl?>&m=label_save_add" method="post">
            <table border="0" cellpadding="0" cellspacing="0" class="opt">
                    <tr>
                        <th width="60">标签名：</th>
                        <td><input style="width: 200px;" type="text" class="txt" name="value[label_name]" value=""/></td>
                    </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <input type="submit" name="submit" value=" 保 存 " onclick="insert_td()" onsubmit="return insert_td()" class="btn" tabindex="3" /> &nbsp;&nbsp;&nbsp;
                        <input type="button" name="submit" value=" 取 消 " class="btn" onclick="javascript:history.back();"/>&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            </table>
        </form>
    </div>

<?php $this->load->view('admin/footer');?>