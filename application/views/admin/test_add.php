<?php $this->load->view('admin/header');?>
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <style>
        .table{margin-top: 0px;}
        .table .td1{width: 70px;height:28px;font-size: 15px; }
        .table .td2{width: 160px;height:28px; }
        .table .td2 input{height:25px;width:160px;font-size: 13px; }
        .table .tr{ display:block; /*将tr设置为块体元素*/  margin:5px 0;  /*设置tr间距为 px*/}
    </style>
    <script>
        $(document).ready(function(){
            // 日期
            $('#begintime01').Zebra_DatePicker({
                months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days: ['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date: '清除',
                show_select_today: '今天'
            });
        });

        function task_save(){
            $("#load").append("<div style='float: left;'> <img src='static/timetable/images/dong.gif'></div>");
            $("#load").append("<div style='margin-left: 40px;padding-top: 5px;'>成绩导入中……</div>");

            var id=$("#test_id").val();
            var test_name=$("#test_name").val();
            var grade=$("#grade").val();
            var date=$("#begintime01").val();
            var thumb=$("#thumb").val();
            $.ajax({
                url: "<?=$this->baseurl?>&m=test_save",   //后台处理程序
                type: "post",         //数据发送方式
                //dataType:"json",    //接受数据格式
                data:{id:id,test_name:test_name,grade:grade,date:date,thumb:thumb},  //要传递的数据
                success:function(data){
                    //alert(data);
                    parent.location.href="<?=$this->baseurl?>&m=statistic_list&grade="+grade;
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
        <input type="hidden" name="id" id="test_id" value="<?= $list['id'];?>">
        <table cellspacing="0" cellpadding="5px" class="table">
            <tr class="tr">
                <td class="td1" >考试名称</td>
                <td class="td2" ><input name="value[task_name]" id="test_name" value="<?= $list['test_name']?>"/></td>
                <td class="td1" >考试年级</td>
                <td class="td2" ><input name="value[task_term]" id="grade" value="<?= $list['grade']?>"/></td>
            </tr>
            <tr class="tr">
                <td class="td1" >考试日期</td>
                <td class="td2" ><input class="text-word"  type="text" name="begintime" id="begintime01" value="<?=$list['date']?>"></td>
                <td class="td1" >导入成绩</td>
                <td class="td2" >
                    <input name="thumb" class="txt" type="text" id="thumb" value="<?=$list['thumb']?>"/>
                </td>
                <td><input type="button" value="选择.." onclick="upfile('thumb')" class="btn" /></td>
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
                <td class="td1" >考试名称</td>
                <td class="td2" ><input name="value[task_name]" id="test_name" value=""/></td>
                <td class="td1" >考试年级</td>
                <td class="td2" ><input name="value[task_term]" id="grade" value=""/></td>
            </tr>
            <tr class="tr">
                <td class="td1" >考试日期</td>
                <td class="td2" ><input class="text-word"  type="text" name="begintime" id="begintime01" value="<?=$begintime?>"></td>
                <td class="td1" >导入成绩</td>
                <td class="td2" >
                    <input name="thumb" class="txt" type="text" id="thumb"/>
                </td>
                <td><input type="button" value="选择.." onclick="upfile('thumb')" class="btn" /></td>
            </tr>
            <tr class="tr" align="center">
                <td><input type="submit" name="submit" value=" 提 交 " onclick="task_save()"  class="btn" tabindex="3" /> &nbsp;&nbsp;&nbsp;
                    <input type="button" name="submit" value=" 取消 " class="btn" onclick="javascript:history.back();" /></td>
            </tr>
        </table>
    </div>
<?php }?>
    <div id="load" style="margin-left: 200px;">
    </div>
<?php $this->load->view('admin/footer');?>