<?php /*error_reporting(0) */?>
<?php $this->load->view('teacher/header');?>
<style>
    <!--
    .cal{ width:99%;margin:0 auto;height:500px;text-align:center; }

    table{
        width:1300px;height:400px;font-size:20px;color:#000;margin:0 auto;
        /*font-size:20px;color:#000;margin:0 auto;table-layout:fixed;*/
    }

    table td{
        height:30px;width:140px;border:1px solid #CCCCCC;
        /*height:30px;width:180px;border:1px solid #CCCCCC;*/
    }
    table td:hover{background:#89BBDE;color:#000;font-weight:bold;}

    table th{
        height:20px;width:140px;border:1px solid #ddd;text-decoration:none;font-size:20px;
    }
    table td a{
        text-decoration:none;font-size:30px;width:30px;height:20px;border:1px solid #FD7B24;cursor:hand;color:#FD7B24;
    }

    .rl_01{
        background:#89BBDE;height:20px;width:140px;text-align:center;color:#fff
    }
    .nl_m{
        text-decoration:none;font-size:12px;color:#ccc;
    }
    .nl_d{
        text-decoration:none;font-size:12px;color:#ccc;
    }
    h1{color:red}

    .today{
        font-weight:bold;color:red;font-size:32px;
    }
    -->
</style>
<script type="text/javascript" src="static/js/My97DatePicker/WdatePicker.js"></script>
<div class="mainbox nomargin">

    <form action="<?=$this->baseurl?>&m=detail" method="post">
        月份&nbsp;&nbsp;<input type="text" id="d243" name="pubdate" value="<?php echo $pubdate?>" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM'})" class="Wdate"/>
        <input type="submit" name="button" id="button" value="显示" class="btn"/>
        <input type="button"  value="饼图显示" class="btn" onclick="location.href='<?=$this->baseurl?>&m=chart&pubdate=<?php echo $pubdate?>'"/>
        <hr />
    </form>
    <div class="cal">
       <!-- <h2><a class='md' href=''>返回今天</a></h2>-->
        <table border='0' cellpadding='0' cellspacing='0'>
            <tr>
                <th><a href='<?php echo $previous_url?>'>&lt;&lt;</a></th>
                <th colspan='5'><?php echo $teacher['truename']?>&nbsp;&nbsp;&nbsp;<?php echo $year.'年'.$month.'月'?></th>
                <th><a href='<?php echo $next_url?>'>&gt;&gt;</a></th>
            </tr>
            <tr>
                <td>日</td><td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td>
            </tr>
                </tr>


            <tr>
                <?php
                //首先确定第一天的位置,然后其他的用循环
                if ($first_day!=7){
                    echo "<td colspan='".$first_day."'> </td>";}
                //如果第一天不是星期天则需要空出几个单元格来
                for ($i=1;$i <= $num_days;$i++){
                    echo "<td><b>".$i."</b><br>".$am_attendance[$i]."<br>".$pm_attendance[$i]."</td>";
                    //换行
                    if (($i+$first_day)%7==0) {echo "</tr><tr>";}
                }?>
            </tr>

            </table>
    </div>
</div>
<?php $this->load->view('teacher/footer');?>
