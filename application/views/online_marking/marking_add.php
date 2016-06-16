<?php $this->load->view('admin/header');?>
    <style>
        .table{margin-top: 0px;}
        .table .td1{width: 70px;height:28px;font-size: 15px; }
        .table .td2{width: 160px;height:28px; }
        .table .td2 input{height:25px;width:160px;font-size: 13px; }
        .table .tr{ display:block; /*将tr设置为块体元素*/  margin:5px 0;  /*设置tr间距为 px*/}
    </style>
    <script>
        //弹出选择班级
        $(document).ready(function(){

            $("#classname").click(function(){
                dialog = dialog_url('index.php?d=admin&c=classroom&m=dialog','选择班级：',400,300);
            });

            // 弹出选择学生
            $("#studentname").click(function(){
                var classname = ($("#classname").val());
                var classid = ($("#classid").val());
                studentdialog = dialog_url('index.php?d=admin&c=student&m=dialog&classid='+encodeURIComponent(classid),'选择'+classname+'学生：',400,300);
            });
        });

        function task_save(){
            var id=$("#task_id").val();
            var classname=$("#classname").val();
            var testname=$("#studentname").val();
            //var titlenumber=$("#titlenumber").val();
            var thumb=$("#thumb").val();
            $.ajax({
                url: "<?=$this->baseurl?>&m=save",   //后台处理程序
                type: "post",         //数据发送方式
                //dataType:"json",    //接受数据格式
                //data:{id:id,classname:classname,testname:testname,titlenumber:titlenumber,thumb:thumb},  //要传递的数据
                data:{id:id,classname:classname,testname:testname,thumb:thumb},  //要传递的数据
                success:function(data){
                    parent.location.href="<?=$this->baseurl?>&m=index";
                },
                error:function(XMLHttpRequest, textStatus, errorThrown)
                {
                    //alert(errorThrown);
                }
            });
        }
    </script>
<?php if(isset($list)){?>
    <div>
        <input type="hidden" name="id" id="task_id" value="<?= $list['id'];?>">
        <table cellspacing="0" cellpadding="5px" class="table">
            <tr class="tr">
                <td class="td1" >班级</td>
                <td class="td2" ><input name="value[classname]" id="classname" value="<?= $list['classname']?>"/></td>
                <td class="td1" >学生姓名</td>
                <td class="td2" ><input name="value[testname]"  value="<?= $list['testname']?>"/></td>
            </tr>
            <!--<tr class="tr">
                <td class="td1" >主观题数</td>
                <td class="td2" ><input name="value[titlenumber]" id="titlenumber" value="<?/*= $list['titlenumber']*/?>"/></td>
            </tr>-->
            <tr class="tr">
                <td class="td1" >导入试卷</td>
                <td style="width: 430px;height: 28px;font-size: 13px; ">
                    <input name="thumb" class="txt" type="text" id="thumb" value="<?= $list['thumb']?>" style="width: 370px;height: 28px;"/>
                    <input type="button" value="选择.." onclick="upfile('thumb')" class="btn"/>
                </td>
            </tr>
            <tr class="tr" align="center">
                <td><input type="submit" name="submit" value=" 提 交 " onclick="task_save()"  class="btn" tabindex="3" /> &nbsp;&nbsp;&nbsp;
                    <input type="button" name="submit" value=" 取消 " class="btn" onclick="javascript:history.back();" /></td>
            </tr>
        </table>
    </div>
<?php }else{?>
    <div>
        <input type="hidden" name="id" id="task_id" value="">
        <input type="hidden"  id="task_copy" value="">
        <table cellspacing="0" cellpadding="5px" class="table">
            <tr class="tr">
                <td class="td1" >班级</td>
                <td class="td2" >
                    <input name="value[classname]" id="classname" value=""/>
                    <input type="hidden" name="" id="classid" value="">
                </td>
                <td class="td1" >学生姓名</td>
                <td class="td2" >
                    <input name="value[testname]" id="studentname" value=""/>
                    <input type="hidden" name="value[studentid]" id="studentid" value="">
                </td>
            </tr>
            <!--<tr class="tr">
                <td class="td1" >主观题数</td>
                <td class="td2" ><input name="value[titlenumber]" id="titlenumber" value=""/></td>
            </tr>-->
            <tr class="tr">
                <td class="td1" >导入试卷</td>
                <td style="width: 430px;height: 28px;font-size: 13px; ">
                    <input name="thumb" class="txt" type="text" id="thumb" style="width: 370px;height: 28px;"/>
                    <input type="button" value="选择.." onclick="upfile('thumb')" class="btn"/>
                </td>
            </tr>
            <tr class="tr" align="center">
                <td><input type="submit" name="submit" value=" 提 交 " onclick="task_save()"  class="btn" tabindex="3" /> &nbsp;&nbsp;&nbsp;
                    <input type="button" name="submit" value=" 取消 " class="btn" onclick="javascript:history.back();" /></td>
            </tr>
        </table>
    </div>
<?php }?>
<?php $this->load->view('admin/footer');?>