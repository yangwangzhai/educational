<?php $this->load->view('admin/header');?>
    <div class="mainbox nomargin">
        <form action="<?=$this->baseurl?>&m=save" method="post">
            <input type="hidden" name="id" value="<?php echo $id?>"/>
            <input type="hidden" name="value[isread]" value="1"/>
            <input type="hidden" name="value[teacherid]" value="<?php echo $value['teacherid']?>"/>
            <input type="hidden" name="value[starttime]" value="<?php echo $value['starttime']?>"/>
            <input type="hidden" name="value[endtime]" value="<?php echo $value['endtime']?>"/>
            <table class="opt">
                <tr>
                    <th>回复内容</th>
                    <td><textarea id="reply" name="value[reply]"
                                  style="width: 400px; height: 200px;"><?php echo $value['reply']?></textarea></td>
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

<?php $this->load->view('admin/footer');?>