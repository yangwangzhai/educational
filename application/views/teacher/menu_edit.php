<?php error_reporting(0);?>
<?php $this->load->view('teacher/header');?>

    <div class="mainbox nomargin">
        <form action="<?=$this->baseurl?>&m=save" method="post">
            <input type="hidden" name="id" value="<?php echo $id?>"/>
            <input type="hidden"  name="value[pubdate]" value="<?php echo $value['pubdate']?>" />
            <input type="hidden"  name="value[meal]" value="<?php echo $value['meal']?>" />
            <table border="0" cellpadding="0" cellspacing="0" class="opt">
                <tr>
                    <th>班级</th>
                    <td>
                        <input type="text" class="txt"  value="<?php echo $value['nickname']?>" readonly />
                        <input type="hidden"  name="value[classid]" value="<?php echo $value['classid']?>"  /></td>
                </tr>

                <tr><th style="color:red;font-size:14px">注意：</th>
                    <td style="color:red;font-size:14px">菜名与图片请务必成对出现</td>
                </tr>

                <tr>
                    <th>菜名</th>
                    <td><input name="value[content][]" value="<?=$value['content'][0]?>" />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb0"
                                                                                                                value="<?=$value['thumb'][0]?>" /><input type="button" value="选择.."
                                                                                                                                                         onclick="upfile('thumb0')" class="btn" /></td>
                    <td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="<?=$value['addinfo'][0]?>" /></td>
                </tr>
                <tr>
                    <th>菜名</th>
                    <td><input name="value[content][]" value="<?=$value['content'][1]?>" />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb1"
                                                                                                                value="<?=$value['thumb'][1]?>" /><input type="button" value="选择.."
                                                                                                                                                         onclick="upfile('thumb1')" class="btn" /></td>
                    <td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="<?=$value['addinfo'][1]?>" /></td>
                </tr>
                <tr>
                    <th>菜名</th>
                    <td><input name="value[content][]" value="<?=$value['content'][2]?>"  />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb2"
                                                                                                                 value="<?=$value['thumb'][2]?>" /><input type="button" value="选择.."
                                                                                                                                                          onclick="upfile('thumb2')" class="btn" /></td>
                    <td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="<?=$value['addinfo'][2]?>" /></td>
                </tr>
                <tr>
                    <th>菜名</th>
                    <td><input name="value[content][]" value="<?=$value['content'][3]?>" />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb3"
                                                                                                                value="<?=$value['thumb'][3]?>" /><input type="button" value="选择.."
                                                                                                                                                         onclick="upfile('thumb3')" class="btn" /></td>
                    <td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="<?=$value['addinfo'][3]?>" /></td>
                </tr>
                <tr>
                    <th>菜名</th>
                    <td><input name="value[content][]" value="<?=$value['content'][4]?>" />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb4"
                                                                                                                value="<?=$value['thumb'][4]?>" /><input type="button" value="选择.."
                                                                                                                                                         onclick="upfile('thumb4')" class="btn" /></td>
                    <td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="<?=$value['addinfo'][4]?>" /></td>
                </tr>
                <tr>
                    <th>菜名</th>
                    <td><input name="value[content][]" value="<?=$value['content'][5]?>" />&nbsp;&nbsp;图片<input name="value[thumb][]" class="txt" type="text" id="thumb5"
                                                                                                                value="<?=$value['thumb'][5]?>" /><input type="button" value="选择.."
                                                                                                                                                         onclick="upfile('thumb5')" class="btn" /></td>
                    <td>&nbsp;&nbsp;附加信息<input name="value[addinfo][]" size="50" value="<?=$value['addinfo'][5]?>" /></td>
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