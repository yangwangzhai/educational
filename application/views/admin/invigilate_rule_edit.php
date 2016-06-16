<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <script type="text/javascript" src="static/js/My97DatePicker/WdatePicker.js"></script>

    <script type="application/javascript">
        $(document).ready(function(e) {
            $('.add_flag').on('click',function(){
                var obj_clone=$('.clone_template').clone(true);
                var obj=$(this).parent().parent().parent();
                obj.after(obj_clone);
                var data_times=obj.attr('data-times');
                var new_data_times=parseInt(data_times)+1;
                var new_obj=obj.next();
                new_obj.show();
                new_obj.removeClass('clone_template');
                $(this).css('display','none');
                new_obj.attr('data-times',new_data_times);

                new_obj.find('input').attr('name','value['+new_data_times+'][date]');
                new_obj.find('input').attr('id','joinin'+new_data_times);

                for(var i=0;i<6;i++){
                    if(i<3){
                        var temp_num=i+7;
                        var obj_div_0=new_obj.find('div').eq(i);
                        obj_div_0.attr('data-name','value['+new_data_times+']['+temp_num+'][morning]');
                        obj_div_0.attr('data-num',new_data_times);
                        obj_div_0.find('select').attr('name','value['+new_data_times+']['+temp_num+'][morning][0][course]');
                        obj_div_0.find('input').eq(0).attr('name','value['+new_data_times+']['+temp_num+'][morning][0][time1]');
                        obj_div_0.find('input').eq(1).attr('name','value['+new_data_times+']['+temp_num+'][morning][0][time2]');
                    }else{
                        var temp_num=i%3+7;
                        var obj_div_0=new_obj.find('div').eq(i);
                        obj_div_0.attr('data-name','value['+new_data_times+']['+temp_num+'][afternoon]');
                        obj_div_0.attr('data-num',new_data_times);
                        obj_div_0.find('select').attr('name','value['+new_data_times+']['+temp_num+'][afternoon][0][course]');
                        obj_div_0.find('input').eq(0).attr('name','value['+new_data_times+']['+temp_num+'][afternoon][0][time1]');
                        obj_div_0.find('input').eq(1).attr('name','value['+new_data_times+']['+temp_num+'][afternoon][0][time2]');
                    }

                }

                $('#joinin'+new_data_times).Zebra_DatePicker({
                    months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                    days:['日', '一', '二', '三', '四', '五', '六'],
                    lang_clear_date:'清除',
                    show_select_today:'今天'
                });

            });

            $('.add_input').on('click',function(){
                var obj_div=$(this).parent();
                var data_name=obj_div.attr('data-name');
                var data_num=obj_div.attr('data-num');
                var new_data_num=parseInt(data_num)+1;
                obj_div.after(obj_div.clone(true));
                //alert(data_name);
                var new_obj_div=obj_div.next();
                new_obj_div.attr('data-num',new_data_num);
                new_obj_div.find('select').attr('name',data_name+'['+new_data_num+'][course]');
                new_obj_div.find('input').eq(0).attr('name',data_name+'['+new_data_num+'][time1]');
                new_obj_div.find('input').eq(1).attr('name',data_name+'['+new_data_num+'][time2]');
            });

            <?php foreach($list as $list_key=>$list_value):?>
                $('#joinin'+<?=$list_key;?>).Zebra_DatePicker({
                    months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                    days:['日', '一', '二', '三', '四', '五', '六'],
                    lang_clear_date:'清除',
                    show_select_today:'今天'
                });
            <?php endforeach?>


        })
    </script>

</head>
<body>

<div style="width:1000px;margin:0 auto;">
    <form method="post" action="<?=$this->baseurl?>&m=invigilate_rule_save&id=<?=$title['id']?>&flag=1">
        <div>
            <table class="" border="1">
                <div class="page-header" style="margin: 0 auto;">
                    <h1>
                        <?=$title['term'].$title['test_name']."监考员安排表"?><small><?=$title['date']?></small>
                    </h1>
                </div>
                <thead>
                <tr>
                    <th style="width:150px;"></th>
                    <th style="width:30px;"></th>
                    <th style="width:250px;text-align: center;">七年级</th>
                    <th style="width:250px;text-align: center;">八年级</th>
                    <th style="width:250px;text-align: center;">九年级</th>
                </tr>
                </thead>
                <?php foreach($list as $list_key=>$list_value):?>
                <tbody data-times=<?=$list_key;?>>
                <tr>
                    <td rowspan="2" style="vertical-align:middle;width:150px; font-size:20px;">
                        <input id="joinin<?=$list_key;?>" name="value[<?=$list_key;?>][date]" value="<?=$list_value['date'];?>" style="width:150px;height:200px;line-height:200px;"/>

                        <button type="button" class="add_flag btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-plus" style="color: rgb(99, 178, 161);"></span>
                        </button>
                    </td>
                    <td style="width:30px;vertical-align:middle;">上午</td>
                    <?php foreach($list_value['morning'] as $list_value_key=>$list_value_value):?>
                    <td style="vertical-align:middle;text-align:center;width:200px;">
                        <?php foreach($list_value_value as $list_value_value_key=>$list_value_value_value):?>
                        <div style="margin-bottom:5px;" data-name="value[<?=$list_key;?>][<?=$list_value_key;?>][morning]" data-num=<?=$list_key;?>>
                            <strong>
                                <select name="value[<?=$list_key;?>][<?=$list_value_key;?>][morning][<?=$list_value_value_key;?>][course]">
                                    <option value="语文" <?php if($list_value_value_value['course']=="语文"){echo "selected=selected";}?>>语文</option>
                                    <option value="数学" <?php if($list_value_value_value['course']=="数学"){echo "selected=selected";}?>>数学</option>
                                    <option value="英语" <?php if($list_value_value_value['course']=="英语"){echo "selected=selected";}?>>英语</option>
                                    <option value="物理" <?php if($list_value_value_value['course']=="物理"){echo "selected=selected";}?>>物理</option>
                                    <option value="化学" <?php if($list_value_value_value['course']=="化学"){echo "selected=selected";}?>>化学</option>
                                    <option value="政治" <?php if($list_value_value_value['course']=="政治"){echo "selected=selected";}?>>政治</option>
                                    <option value="历史" <?php if($list_value_value_value['course']=="历史"){echo "selected=selected";}?>>历史</option>
                                    <option value="地理" <?php if($list_value_value_value['course']=="地理"){echo "selected=selected";}?>>地理</option>
                                    <option value="生物" <?php if($list_value_value_value['course']=="生物"){echo "selected=selected";}?>>生物</option>
                                </select>
                                <input class="Wdate" name="value[<?=$list_key;?>][<?=$list_value_key;?>][morning][<?=$list_value_value_key;?>][time1]" value="<?=$list_value_value_value['time_begin']?>" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>-
                                <input class="Wdate" name="value[<?=$list_key;?>][<?=$list_value_key;?>][morning][<?=$list_value_value_key;?>][time2]" value="<?=$list_value_value_value['time_end']?>" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>
                            </strong>
                            <button type="button" class="add_input btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-plus" style="color: rgb(99, 178, 161);"></span>
                            </button>
                        </div>
                        <?php endforeach?>
                    </td>
                    <?php endforeach?>
                </tr>
                <tr >
                    <td style="width:30px;vertical-align:middle;">下午</td>
                    <?php foreach($list_value['afternoon'] as $list_value_key=>$list_value_value):?>
                    <td style="vertical-align:middle;text-align:center;width:200px;">
                        <?php foreach($list_value_value as $list_value_value_key=>$list_value_value_value):?>
                        <div style="margin-bottom:5px;" data-name="value[<?=$list_key;?>][<?=$list_value_key;?>][afternoon]" data-num=<?=$list_key;?>>
                            <strong>
                                <select name="value[<?=$list_key;?>][<?=$list_value_key;?>][afternoon][<?=$list_value_value_key;?>][course]">
                                    <option value="语文" <?php if($list_value_value_value['course']=="语文"){echo "selected=selected";}?>>语文</option>
                                    <option value="数学" <?php if($list_value_value_value['course']=="数学"){echo "selected=selected";}?>>数学</option>
                                    <option value="英语" <?php if($list_value_value_value['course']=="英语"){echo "selected=selected";}?>>英语</option>
                                    <option value="物理" <?php if($list_value_value_value['course']=="物理"){echo "selected=selected";}?>>物理</option>
                                    <option value="化学" <?php if($list_value_value_value['course']=="化学"){echo "selected=selected";}?>>化学</option>
                                    <option value="政治" <?php if($list_value_value_value['course']=="政治"){echo "selected=selected";}?>>政治</option>
                                    <option value="历史" <?php if($list_value_value_value['course']=="历史"){echo "selected=selected";}?>>历史</option>
                                    <option value="地理" <?php if($list_value_value_value['course']=="地理"){echo "selected=selected";}?>>地理</option>
                                    <option value="生物" <?php if($list_value_value_value['course']=="生物"){echo "selected=selected";}?>>生物</option>
                                </select>
                                <input class="Wdate" name="value[<?=$list_key;?>][<?=$list_value_key;?>][afternoon][<?=$list_value_value_key;?>][time1]" value="<?=$list_value_value_value['time_begin']?>" style="width:60px;" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>-
                                <input class="Wdate" name="value[<?=$list_key;?>][<?=$list_value_key;?>][afternoon][<?=$list_value_value_key;?>][time2]" value="<?=$list_value_value_value['time_end']?>" style="width:60px;" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>
                            </strong>
                            <button type="button" class="add_input btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-plus" style="color: rgb(99, 178, 161);"></span>
                            </button>
                        </div>
                        <?php endforeach?>
                    </td>
                    <?php endforeach?>
                </tr>
                </tbody>
                <?php endforeach ?>
                <!--克隆模板-->
                <tbody class="clone_template" style="display: none;">
                <tr>
                    <td rowspan="2" style="vertical-align:middle;width:150px; font-size:20px;">
                        <input  name="" style="width:150px;height:200px;line-height:200px;"/>

                        <button type="button" class="add_flag btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-plus" style="color: rgb(99, 178, 161);"></span>
                        </button>
                    </td>
                    <td style="width:30px;vertical-align:middle;">上午</td>
                    <td style="vertical-align:middle;text-align:center;width:200px;">
                        <div style="margin-bottom:5px;" data-name="value[0][7][morning]" data-num=0>
                            <strong>
                                <select>
                                    <option value="语文">语文</option>
                                    <option value="数学">数学</option>
                                    <option value="英语">英语</option>
                                    <option value="物理">物理</option>
                                    <option value="化学">化学</option>
                                    <option value="政治">政治</option>
                                    <option value="历史">历史</option>
                                    <option value="地理">地理</option>
                                    <option value="生物">生物</option>
                                </select>
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>-
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>
                            </strong>
                            <button type="button" class="add_input btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-plus" style="color: rgb(99, 178, 161);"></span>
                            </button>
                        </div>
                    </td>
                    <td style="vertical-align:middle;text-align:center;width:200px;">
                        <div style="margin-bottom:5px;" data-name="value[0][8][morning]" data-num=0>
                            <strong>
                                <select name="">
                                    <option value="语文">语文</option>
                                    <option value="数学">数学</option>
                                    <option value="英语">英语</option>
                                    <option value="物理">物理</option>
                                    <option value="化学">化学</option>
                                    <option value="政治">政治</option>
                                    <option value="历史">历史</option>
                                    <option value="地理">地理</option>
                                    <option value="生物">生物</option>
                                </select>
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>-
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>
                            </strong>
                            <button type="button" class="add_input btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-plus" style="color: rgb(99, 178, 161);"></span>
                            </button>
                        </div>
                    </td>
                    <td style="vertical-align:middle;text-align:center;width:200px;">
                        <div style="margin-bottom:5px;" data-name="value[0][9][morning]" data-num=0>
                            <strong>
                                <select name="">
                                    <option value="语文">语文</option>
                                    <option value="数学">数学</option>
                                    <option value="英语">英语</option>
                                    <option value="物理">物理</option>
                                    <option value="化学">化学</option>
                                    <option value="政治">政治</option>
                                    <option value="历史">历史</option>
                                    <option value="地理">地理</option>
                                    <option value="生物">生物</option>
                                </select>
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>-
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>
                            </strong>
                            <button type="button" class="add_input btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-plus" style="color: rgb(99, 178, 161);"></span>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr >
                    <td style="width:30px;vertical-align:middle;">下午</td>
                    <td style="vertical-align:middle;text-align:center;width:200px;">
                        <div style="margin-bottom:5px;" data-name="value[0][7][afternoon]" data-num=0>
                            <strong>
                                <select name="">
                                    <option value="语文">语文</option>
                                    <option value="数学">数学</option>
                                    <option value="英语">英语</option>
                                    <option value="物理">物理</option>
                                    <option value="化学">化学</option>
                                    <option value="政治">政治</option>
                                    <option value="历史">历史</option>
                                    <option value="地理">地理</option>
                                    <option value="生物">生物</option>
                                </select>
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>-
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>
                            </strong>
                            <button type="button" class="add_input btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-plus" style="color: rgb(99, 178, 161);"></span>
                            </button>
                        </div>
                    </td>
                    <td style="vertical-align:middle;text-align:center;width:200px;">
                        <div style="margin-bottom:5px;" data-name="value[0][8][afternoon]" data-num=0>
                            <strong>
                                <select name="">
                                    <option value="语文">语文</option>
                                    <option value="数学">数学</option>
                                    <option value="英语">英语</option>
                                    <option value="物理">物理</option>
                                    <option value="化学">化学</option>
                                    <option value="政治">政治</option>
                                    <option value="历史">历史</option>
                                    <option value="地理">地理</option>
                                    <option value="生物">生物</option>
                                </select>
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>-
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>
                            </strong>
                            <button type="button" class="add_input btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-plus" style="color: rgb(99, 178, 161);"></span>
                            </button>
                        </div>
                    </td>
                    <td style="vertical-align:middle;text-align:center;width:200px;">
                        <div style="margin-bottom:5px;" data-name="value[0][9][afternoon]" data-num=0>
                            <strong>
                                <select name="">
                                    <option value="语文">语文</option>
                                    <option value="数学">数学</option>
                                    <option value="英语">英语</option>
                                    <option value="物理">物理</option>
                                    <option value="化学">化学</option>
                                    <option value="政治">政治</option>
                                    <option value="历史">历史</option>
                                    <option value="地理">地理</option>
                                    <option value="生物">生物</option>
                                </select>
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>-
                                <input class="Wdate" name="" style="width:60px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'H:mm'})"/>
                            </strong>
                            <button type="button" class="add_input btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-plus" style="color: rgb(99, 178, 161);"></span>
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row" style="margin-top: 10px;">
            <div class="center-block" style="width:200px;">
                <button type="submit" class="btn btn-primary">提交保存</button>
            </div>
        </div>
    </form>
</div>



</body>
</html>
