<?php $this->load->view('teacher/header');?>
    <script type="text/javascript" src="static/js/My97DatePicker/WdatePicker.js"></script>
    <div class="mainbox nomargin">
        <form action="<?=$this->baseurl?>&m=set_save" method="post">
            <input type="hidden"  name="value[dodate]" value="<?php echo $value['dodate']?>" />
            <input type="hidden"  name="value[set_title]" value="<?php echo $value['set_title']?>" />
            <table border="0" cellpadding="0" cellspacing="0" class="opt">
                <tr>
                    <th>教&nbsp;&nbsp;&nbsp;&nbsp;师:</th>
                    <td>
                        <input type="text" class="txt"  value="<?php echo $truename?>" readonly />

                </tr>

                <tr>
                    <th>时&nbsp;&nbsp;&nbsp;&nbsp;间:</th>
                    <td><input type="text"  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"
                            name="value[begintime]"  value="<?php echo $begintime?>"   class="Wdate" style="width:200px"/>
                        &nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<input type="text"  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"
                                name="value[endtime]" value="<?php echo $endtime?>"  class="Wdate" style="width:200px"/>
                    </td>
                </tr>
                <tr>
                    <th>休&nbsp;息&nbsp;日:&nbsp;</th>
                    <td><input type="checkbox" name="value[iswork]" value="1">
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td><input type="submit" name="submit" value=" 提 交 " class="btn"
                               tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
                                                                        name="submit" value=" 取消 " class="btn"
                                                                        onclick="javascript:history.back();" /></td>
                </tr>
            </table>
        </form>

    </div>

<?php $this->load->view('teacher/footer');?>