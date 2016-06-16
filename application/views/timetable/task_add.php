<?php $this->load->view('admin/header');?>
    <style>
        .table{margin-top: 0px;}
        .table .td1{width: 70px;height:28px;font-size: 15px; }
        .table .td2{width: 160px;height:28px; }
        .table .td2 input{height:25px;width:160px;font-size: 13px; }
        .table .tr{ display:block; /*将tr设置为块体元素*/  margin:5px 0;  /*设置tr间距为 px*/}
    </style>
    <script>
        function task_save(){
            var id=$("#task_id").val();
            var copy=$("#task_copy").val();
            var task_name=$("#task_name").val();
            var task_term=$("#task_term").val();
            var days_oneweek=$("#days_oneweek").val();
            var section_oneday=$("#section_oneday").val();
            $.ajax({
                url: "<?=$this->baseurl?>&m=save",   //后台处理程序
                type: "post",         //数据发送方式
                //dataType:"json",    //接受数据格式
                data:{id:id,task_name:task_name,task_term:task_term,copy:copy,days_oneweek:days_oneweek,section_oneday:section_oneday},  //要传递的数据
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
        <input type="hidden"  id="task_copy" value="<?= $list['copy']?>">
        <table cellspacing="0" cellpadding="5px" class="table">
            <tr class="tr">
                <td class="td1" >任务名称</td>
                <td class="td2" ><input name="value[task_name]" id="task_name" value="<?= $list['task_name']?>"/></td>
                <td class="td1" >学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;期</td>
                <td class="td2" ><input name="value[task_term]" id="task_term" value="<?= $list['task_term']?>"/></td>
            </tr>
            <tr class="tr">
                <td class="td1" >一&nbsp;&nbsp;周&nbsp;&nbsp;上<br/>课&nbsp;&nbsp;天&nbsp;&nbsp;数</td>
                <td class="td2" ><input name="value[days_oneweek]" id="days_oneweek" value="<?= $list['days_oneweek']?>"/></td>
                <td class="td1" >一&nbsp;&nbsp;天&nbsp;&nbsp;上<br/>课&nbsp;&nbsp;节&nbsp;&nbsp;数</td>
                <td class="td2" ><input name="value[section_oneday]" id="section_oneday" value="<?= $list['section_oneday']?>"/></td>
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
                <td class="td1" >任务名称</td>
                <td class="td2" ><input name="value[task_name]" id="task_name" value=""/></td>
                <td class="td1" >学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;期</td>
                <td class="td2" ><input name="value[task_term]" id="task_term" value=""/></td>
            </tr>
            <tr class="tr">
                <td class="td1" >一&nbsp;&nbsp;周&nbsp;&nbsp;上<br/>课&nbsp;&nbsp;天&nbsp;&nbsp;数</td>
                <td class="td2" ><input name="value[days_oneweek]" id="days_oneweek" value=""/></td>
                <td class="td1" >一&nbsp;&nbsp;天&nbsp;&nbsp;上<br/>课&nbsp;&nbsp;节&nbsp;&nbsp;数</td>
                <td class="td2" ><input name="value[section_oneday]" id="section_oneday" value=""/></td>
            </tr>
            <tr class="tr" align="center">
                <td><input type="submit" name="submit" value=" 提 交 " onclick="task_save()"  class="btn" tabindex="3" /> &nbsp;&nbsp;&nbsp;
                    <input type="button" name="submit" value=" 取消 " class="btn" onclick="javascript:history.back();" /></td>
            </tr>
        </table>
    </div>
<?php }?>
<?php $this->load->view('admin/footer');?>