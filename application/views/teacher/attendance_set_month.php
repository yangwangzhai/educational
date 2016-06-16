<?php $this->load->view('teacher/header');?>

<style>
    .cal{  width:60%; height:500px; margin:0 ; line-height:22px;}
    table{ }
    table td{  height:30px;width:160px;border:1px solid #CCCCCC;}
    a{color: #FFF}
</style>
<script type="text/javascript" src="static/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // 点击日历 用于修改或者添加日程
        $(".table_content").click(function(){
            var num=$(this).attr('data-num');
            if(num>0)
            {
                var date=$(this).attr('data-date');
                dialog=dialog_url("index.php?d=teacher&c=attendance&m=set_dialog&date="+date,'排班设置',768,500);
            }
        });
    });
</script>

<div class="mainbox nomargin">
    <form action="<?=$this->baseurl?>&m=set_month" method="post">
        月份&nbsp;&nbsp;<input type="text" id="d243" name="pubdate"
               onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM'})" class="Wdate"
               value="<?php echo $pubdate?>"/>&nbsp;&nbsp;
        <input type="submit" name="button" id="button" value="&nbsp;&nbsp;显示&nbsp;&nbsp;" class="btn"/>
        <input type="button" value="&nbsp;&nbsp;周&nbsp;&nbsp;" class="btn"
               onclick="location.href='<?=$this->baseurl?>&m=set'"
            />
        <hr />
    </form>
    <div class="cal">
        <table class="ctltable" border='0' cellpadding='0' cellspacing='1' style="table-layout: fixed">
            <tr style="height:50px; line-height:50px; background:#f77b01; color:#fff;">
                <th style="text-align: left"><a href='<?php echo $previous_url?>'>&lt;&lt;</a></th>
                <th colspan='5' style="text-align: center"><?php echo $truename?>&nbsp;&nbsp;&nbsp;<?php echo $year.'年'.$month.'月'?></th>
                <th style="text-align: right"><a href='<?php echo $next_url?>'>&gt;&gt;</a></th>
            </tr>
            <tr style="text-align:center; height:30px; line-height:30px; color:#333;">
                <td>日</font></td>
                <td>一</font></td>
                <td>二</font></td>
                <td>三</font></td>
                <td>四</font></td>
                <td>五</font></td>
                <td>六</font></td>
            </tr>

            <?php
            $a=1;
            static $e_num;
            if($first_day!=7){
                $e_num=$a-$first_day;
            }else{
                $e_num=1;
            }
            ?>
            <tr style="text-align:right;">
                <?php if ($first_day!=7){?>
                    <td colspan='<?= $first_day?>'> </td>
                <?php }; ?>
                <?php for($i=1;$i<=$num_days;$i++){ ?>
                <td><?= $i;?></td>
                <?php if(($i+$first_day)%7==0||$i==$num_days){?>
            </tr><tr style="text-align:center;height: 80px;">
                <?php for($j=$e_num;$j<=$num_days;$j++){?>
                <td class='table_content' data-num="<?php echo $j?>" data-date="<?php echo $year.'-'.$month.'-'.$j?>">
                    <?php
                    if($j>0) {
                        foreach ($list[$j] as $key => $value) {
                            if($value['set_title']==1)
                            {
                                if($value['iswork']=='0')
                                {
                                    echo '<font color="green">休</font></br>';
                                }
                                else
                                {
                                    echo '上午:'.$value['begintime'].'--'.$value['endtime'].'</br>';
                                }
                            }
                            elseif($value['set_title']==2)
                            {
                                if($value['iswork']=='0')
                                {
                                    echo '<font color="green">休</font>';
                                }
                                else
                                {
                                    echo '下午:'.$value['begintime'].'--'.$value['endtime'];
                                }
                            }
                        }
                    }?>
                </td>
                <?php $e_num++?>
                <?php if(($j+$first_day)%7==0){?>
            </tr><tr style="text-align:right;">
                <?php break;?>
                <?php }?>
                <?php }?>
                <?php }?>
                <?php }?>
            </tr>
        </table>
    </div>
</div>
<?php $this->load->view('teacher/footer');?>
