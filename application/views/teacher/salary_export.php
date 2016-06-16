<?php $this->load->view('teacher/header');?>
<form  method="post" action="<?=$this->baseurl?>&m=export_save" >

    <div>
        单击如下按钮，导出员工工资明细，以便打印。 <br /><br />

        所属年/月份：<input name="value[year]" type="number" value="<?=$year?>" id="txt_year" style="width:60px;" />年
        <input name="value[month]" type="number" value="<?=$month?>" id="txt_month" style="width:60px;" />月<br /><br />


        <div id="div1">
            <input type="submit" name="Button1" class="btn" value="导出明细" onclick="setthis();" id="Button1" />
        </div>

        <div id="div2" style="display:none">
            <input type="submit" name="Button2" class="btn" value="数据导出中..." id="Button2" disabled="disabled" />
        </div>

        <script>
            function setthis()
            {
                $("#div1").hide();
                $("#div2").show();
            }
        </script>

</form>
</body>
</html>
