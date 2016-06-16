<?php $this->load->view('admin/header');?>
    <script type="text/javascript" src="static/js/My97DatePicker/WdatePicker.js"></script>
    <div class="mainbox nomargin">
            <input type="hidden"  name="date" value="<?php echo $value['date']?>" />
            <input type="hidden"  name="uid" value="<?php echo $value['uid']?>"  />
            <table border="0" cellpadding="0" cellspacing="0" class="opt">
                <?php foreach ($list as  $K=>$value):?>
                    <tr>
                        <th><?php echo $value['set_title']?>&nbsp;&nbsp;:&nbsp;&nbsp;</th>
                        <td><input type="text"  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"
                                   name="value<?php echo $K?>[begintime]"  value="<?php echo $value['begintime']?>"   class="Wdate" style="width:200px"/>
                            &nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<input type="text"  onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"
                                                                  name="value<?php echo $K?>[endtime]" value="<?php echo $value['endtime']?>"  class="Wdate" style="width:200px"/>
                            &nbsp;&nbsp;&nbsp;<input type="checkbox" name="value<?php echo $K?>[iswork]" value="1" <?php if($value['iswork']=='0')echo 'checked'?>>休&nbsp;息
                        </td>
                    </tr>
                <?php endforeach;?>
                <tr>
                    <th>&nbsp;</th>
                    <td><input type="button" id="submit" value=" 提 交 " class="btn"
                               tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
                                                                        name="submit" value=" 取消 " class="btn"
                                                                        onclick="javascript:parent.dialog.remove();" /></td>
                </tr>
            </table>

    </div>
    <script type="application/javascript">
        $(document).ready(function(){
            $("#submit").bind("click",function(){
                var value1={begintime:$("input[name='value1[begintime]']").val(),endtime:$("input[name='value1[endtime]']").val(),iswork:$("input[name='value1[iswork]']").is(':checked')};
                var value2={begintime:$("input[name='value2[begintime]']").val(),endtime:$("input[name='value2[endtime]']").val(),iswork:$("input[name='value2[iswork]']").is(':checked')};
                var date=$("input[name='date']").val();
                var teacherid=$("input[name='teacherid']").val();
                $.ajax({
                    url: "<?=$this->baseurl?>&m=set_month_save",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    data:{value1:value1,value2:value2,date:date,teacherid:teacherid},  //要传递的数据
                    success:function(data){
                        if(data==1)
                        {
                            //parent.dialog.remove();
                            parent.location.href='<?php echo $_SESSION ['url_forward']?>';
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        alert(errorThrown);
                    }
                });

            });
        });
    </script>
<?php $this->load->view('admin/footer');?>