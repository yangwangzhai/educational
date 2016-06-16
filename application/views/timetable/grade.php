<?php $this->load->view('teacher/header');?>
<?php
    $grade_middle=config_item('grade_middle');  //初中 七年级 八年级 九年级
    $grade=config_item('grade');                //一年级 到 九年级
    $term_array=config_item('term_array');
?>
    <style>
        .table{margin-top: 0px;}
        .table tr{ display:block; /*将tr设置为块体元素*/  margin:20px 0;  /*设置tr间距为 px*/}
        .table .td1{width: 90px;height:25px;font-size: 15px; }
        .table .td1 input{width: 60px;height:25px;}
        .table .td2{width: 90px;height:25px;font-size: 15px; }
        .table .td2 input{width: 60px;height:25px;font-size: 15px; }
        .table .td3{width: 170px;height:25px;font-size: 15px; }
        .table .td3 input{width: 150px;height:25px;font-size: 15px; }
        .table .td4 input{width: 600px;height:25px;font-size: 15px; }
    </style>

	<div>
		<form action="index.php?d=admin&c=grade&m=save" method="post">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                <tr>
                    <td style="width: 80px;"><font style="color: #0066FF;font-size: medium;">已选学期:</font></td>
                    <td style="width: 100px;">
                        <?= $grade_term?>
                    </td>
                    <td style="width: 80px;"><font style="color: #0066FF;font-size: medium;">学校类型:</font></td>
                    <td style="width: 80px;">
                        <?PHP
                            if($grade_num==6){
                                echo "小学";
                            }else{
                                echo "初中";
                            }
                        ?>
                    </td>
                </tr>
				<tr>
					<td class="td1">年级</td>
					<td class="td2">班级数</td>
                    <td class="td2">上课节数</td>
					<td class="td3">主科设置</td>
                    <td class="td3">副科设置</td>
				</tr>
				<?php if(empty($list)){ ?>
                        <?php if($grade_num==6){?>
                        <?php for($i=0;$i<$grade_num;$i++){ ?>
                        <tr>
                            <td class="td1"><input name="value[<?=$i?>][grade]" type="text" value="<?= $grade[$i+1]?>" /></td>
                            <td class="td2"><input name="value[<?=$i?>][class_count]" type="text" value="" /></td>
                            <td class="td2"><input name="value[<?=$i?>][classes_day]" type="text" value="" /></td>
                            <td class="td3"><input name="value[<?=$i?>][major]" type="text" value="" /></td>
                            <td class="td4"><input name="value[<?=$i?>][minor]" type="text"  value="" /></td>
                        </tr>
                            <input type="hidden" name="value[<?=$i?>][id]" value="<?=$list[$i]['id']?>">
				        <?php }?>
                <?php }else{ ?>
                        <?php for($i=0;$i<$grade_num;$i++){?>
                            <tr>
                                <td class="td1"><input name="value[<?=$i?>][grade]" type="text" value="<?= $grade_middle[$i+1]?>" /></td>
                                <td class="td2"><input name="value[<?=$i?>][class_count]" type="text" value="" /></td>
                                <td class="td2"><input name="value[<?=$i?>][classes_day]" type="text" value="" /></td>
                                <td class="td3"><input name="value[<?=$i?>][major]" type="text" value="" /></td>
                                <td class="td4"><input name="value[<?=$i?>][minor]" type="text"  value="" /></td>
                            </tr>
                        <?php }?>
                    <?php } }elseif(count($list)==3){ ?>
                    <?php for($i=0;$i<count($list);$i++){ ?>
                    <tr>
                        <td class="td1"><input name="value[<?=$i?>][grade]" type="text" value="<?= $grade_middle[$i+1]?>" /></td>
                        <td class="td2"><input name="value[<?=$i?>][class_count]" type="text" value="<?=$list[$i]['class_count']?>" /></td>
                        <td class="td2"><input name="value[<?=$i?>][classes_day]" type="text" value="<?=$list[$i]['classes_day']?>" /></td>
                        <td class="td3"><input name="value[<?=$i?>][major]" type="text" value="<?=$list[$i]['major']?>" /></td>
                        <td class="td4"><input name="value[<?=$i?>][minor]" type="text"  value="<?=$list[$i]['minor']?>" /></td>
                    </tr>
                        <input type="hidden" name="value[<?=$i?>][id]" value="<?=$list[$i]['id']?>">
                <?php } }else{?>
                    <?php for($i=0;$i<count($list);$i++){ ?>
                        <tr>
                            <td class="td1"><input name="value[<?=$i?>][grade]" type="text" value="<?= $grade[$i+1]?>" /></td>
                            <td class="td2"><input name="value[<?=$i?>][class_count]" type="text" value="<?=$list[$i]['class_count']?>" /></td>
                            <td class="td2"><input name="value[<?=$i?>][classes_day]" type="text" value="<?=$list[$i]['classes_day']?>" /></td>
                            <td class="td3"><input name="value[<?=$i?>][major]" type="text" value="<?=$list[$i]['major']?>" /></td>
                            <td class="td4"><input name="value[<?=$i?>][minor]" type="text"  value="<?=$list[$i]['minor']?>" /></td>
                        </tr>
                        <input type="hidden" name="value[<?=$i?>][id]" value="<?=$list[$i]['id']?>">
                <?php } } ?>
				<tr>
					<th>&nbsp;</th>
					<td>
                        <input type="submit" value=" 提 交 " class="btn" tabindex="3" /> &nbsp;&nbsp;&nbsp;
                    </td>
				</tr>
			</table>

		</form>

	</div>



<?php $this->load->view('teacher/footer');?>