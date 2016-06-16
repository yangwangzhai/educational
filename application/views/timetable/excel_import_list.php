<?php $this->load->view('admin/header');?>
    <script type="text/javascript">
       function base_save(){
           $("#load").append("<div style='float: left;'> <img src='static/timetable/images/dong.gif'></div>");
           $("#load").append("<div style='margin-left: 40px;padding-top: 5px;'>导入中……</div>");
           var thumb=$("#thumb").val();
           $.ajax({
               url: "<?=$this->baseurl?>&m=excel_import_save",   //后台处理程序
               type: "post",         //数据发送方式
               //dataType:"json",    //接受数据格式
               data:{thumb:thumb},  //要传递的数据
               success:function(data){
                   if(data){
                       parent.location.href="<?=$this->baseurl?>&m=base_message";
                   }else{
                       alert("导入基础信息失败！");
                   }
               },
               error:function(XMLHttpRequest, textStatus, errorThrown)
               {
                   //alert(errorThrown);
               }
           });
       }
    </script>
<body>
    <div class="mainbox nomargin">
        <form action="<?=$this->baseurl?>&m=excel_import_save" method="post">
            <table width="99%" border="0" cellpadding="3" cellspacing="0" class="opt">
                <tr>
                    <th width="90">导入EXCEL</th>
                    <td >
                        <input name="thumb" class="txt" type="text" id="thumb"/>
                        <input type="button" value="选择.." onclick="upfile('thumb')" class="btn" />
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td colspan="3">
                        <input type="submit"  value="提 交" onclick="base_save()"  class="btn" /> &nbsp;&nbsp;&nbsp;
                        <input type="button" name="canc" value=" 取消 " class="btn" onclick="javascript:history.back();" /></td>
                </tr>
            </table>
        </form>
    </div>
    <div id="load" style="margin-left: 150px;">
    </div>
</body>
<?php $this->load->view('admin/footer');?>
