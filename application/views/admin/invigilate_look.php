<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <title>无标题文档</title>
    <style>
        .table-bordered>tbody>tr>th{width: 10px;vertical-align: middle;cursor: pointer;}
        .table-bordered>tbody>tr>td{width: 10px;vertical-align: middle;cursor: pointer;}
    </style>
</head>
<body>
<div style="margin:0 auto;">
    <form method="post" action="index.php?d=admin&c=invigilate&m=invigilate_rule_save&id=2&flag=1">
        <div>
            <table class="table table-bordered" border="1">
                <div class="page-header" style="margin: 0 auto;">
                    <h1>
                        2016春季学期初中期考考试监考员安排表<small>2016-06-13</small>
                    </h1>
                </div>
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th style="text-align: center;border-right-width: 3px;" colspan="10">七年级</th>
                    <th style="text-align: center;border-right-width: 3px;" colspan="9">八年级</th>
                    <th style="text-align: center;border-right-width: 3px;" colspan="10">九年级</th>
                </tr>
                </thead>
                <tbody data-times=0>
                <tr class="classname">
                    <td></td>
                    <td></td>
                    <td align="center" ><strong>1班</strong></td>
                    <td align="center"><strong>2班</strong></td>
                    <td align="center"><strong>3班</strong></td>
                    <td align="center"><strong>4班</strong></td>
                    <td align="center"><strong>5班</strong></td>
                    <td align="center"><strong>6班</strong></td>
                    <td align="center"><strong>7班</strong></td>
                    <td align="center"><strong>8班</strong></td>
                    <td align="center"><strong>9班</strong></td>
                    <td align="center" style="border-right-width: 3px;"><strong>六辅</strong></td>

                    <td align="center" ><strong>1班</strong></td>
                    <td align="center"><strong>2班</strong></td>
                    <td align="center"><strong>3班</strong></td>
                    <td align="center"><strong>4班</strong></td>
                    <td align="center"><strong>5班</strong></td>
                    <td align="center"><strong>6班</strong></td>
                    <td align="center"><strong>7班</strong></td>
                    <td align="center"><strong>8班</strong></td>
                    <td align="center" style="border-right-width: 3px;"><strong>二辅</strong></td>

                    <td align="center"><strong>1班</strong></td>
                    <td align="center"><strong>2班</strong></td>
                    <td align="center"><strong>3班</strong></td>
                    <td align="center"><strong>4班</strong></td>
                    <td align="center"><strong>5班</strong></td>
                    <td align="center"><strong>6班</strong></td>
                    <td align="center"><strong>7班</strong></td>
                    <td align="center"><strong>8班</strong></td>
                    <td align="center"><strong>9班</strong></td>
                    <td align="center" style="border-right-width: 3px;"><strong>五辅</strong></td>
                </tr>
                <?php foreach($list as $list_key=>$list_value):?>
                    <tr>
                    <th width="10" rowspan="<?=$date_rowspan_num[$list_key]?>"><?= $list_value['date']?></th>
                    <td rowspan="<?=$morning_section_rowspan_num[$list_key]?>" style="vertical-align: middle;">上午</td>
                    <?php for($i=0;$i<2;$i++){?>
                        <?php if(!empty($list_value['morning'][7][$i])||!empty($list_value['morning'][8][$i])||!empty($list_value['morning'][9][$i])){?>
                            <?php if($i==1){echo "<tr>";}?>
                            <td colspan="10" align="center" valign="middle" style="border-right-width: 3px;"><strong><?= $list_value['morning'][7][$i][0]['course']?></strong></td>
                            <td colspan="9" align="center" valign="middle"  style="border-right-width: 3px;"><strong><?= $list_value['morning'][8][$i][0]['course']?></strong></td>
                            <td colspan="10" align="center" valign="middle" style="border-right-width: 3px;"><strong><?= $list_value['morning'][9][$i][0]['course']?></strong></td>
                            </tr>
                            <tr>
                                <?php if(!empty($list_value['morning'][7][$i])){?>
                                    <?php foreach($list_value['morning'][7][$i] as $content_key=>$content_value):?>
                                        <td <?php if($content_key==count($list_value['morning'][7][$i])-1){echo "style='border-right-width: 3px'";}?>><?= $content_value['teacher']?></td>
                                    <?php endforeach?>
                                <?php }else{?>
                                    <?php for($j=0;$j<$classes_num[7];$j++){?>
                                        <td <?php if($j==$classes_num[7]-1){echo "style='border-right-width: 3px'";}?>></td>
                                    <?php }?>
                                <?php }?>

                                <?php if(!empty($list_value['morning'][8][$i])){?>
                                    <?php foreach($list_value['morning'][8][$i] as $content_key=>$content_value):?>
                                        <td <?php if($content_key==count($list_value['morning'][8][$i])-1){echo "style='border-right-width: 3px'";}?>><?= $content_value['teacher']?></td>
                                    <?php endforeach?>
                                <?php }else{?>
                                    <?php for($j=0;$j<$classes_num[8];$j++){?>
                                        <td <?php if($j==$classes_num[8]-1){echo "style='border-right-width: 3px'";}?>></td>
                                    <?php }?>
                                <?php }?>

                                <?php if(!empty($list_value['morning'][9][$i])){?>
                                    <?php foreach($list_value['morning'][9][$i] as $content_key=>$content_value):?>
                                        <td <?php if($content_key==count($list_value['morning'][9][$i])-1){echo "style='border-right-width: 3px'";}?>><?= $content_value['teacher']?></td>
                                    <?php endforeach?>
                                <?php }else{?>
                                    <?php for($j=0;$j<$classes_num[9];$j++){?>
                                        <td <?php if($j==$classes_num[9]-1){echo "style='border-right-width: 3px'";}?>></td>
                                    <?php }?>
                                <?php }?>

                            </tr>
                        <?php }?>
                    <?php }?>

                    <tr>
                    <td rowspan="<?=$afternoon_section_rowspan_num[$list_key]?>" style="vertical-align: middle;">下午</td>
                    <?php for($i=0;$i<2;$i++){?>
                        <?php if(!empty($list_value['afternoon'][7][$i])||!empty($list_value['afternoon'][8][$i])||!empty($list_value['afternoon'][9][$i])){?>
                            <?php if($i==1){echo "<tr>";}?>
                            <td colspan="10" align="center" valign="middle" style="border-right-width: 3px;"><strong><?= $list_value['afternoon'][7][$i][0]['course']?></strong></td>
                            <td colspan="9" align="center" valign="middle"  style="border-right-width: 3px;"><strong><?= $list_value['afternoon'][8][$i][0]['course']?></strong></td>
                            <td colspan="10" align="center" valign="middle" style="border-right-width: 3px;"><strong><?= $list_value['afternoon'][9][$i][0]['course']?></strong></td>
                            </tr>
                            <tr>
                                <?php foreach($list_value['afternoon'][7][$i] as $content_key=>$content_value):?>
                                    <td <?php if($content_key==count($list_value['afternoon'][7][$i])-1){echo "style='border-right-width: 3px'";}?>><?= $content_value['teacher']?></td>
                                <?php endforeach?>
                                <?php foreach($list_value['afternoon'][8][$i] as $content_key=>$content_value):?>
                                    <td <?php if($content_key==count($list_value['afternoon'][8][$i])-1){echo "style='border-right-width: 3px'";}?>><?= $content_value['teacher']?></td>
                                <?php endforeach?>
                                <?php foreach($list_value['afternoon'][9][$i] as $content_key=>$content_value):?>
                                    <td <?php if($content_key==count($list_value['afternoon'][9][$i])-1){echo "style='border-right-width: 3px'";}?>><?= $content_value['teacher']?></td>
                                <?php endforeach?>
                            </tr>
                        <?php }?>
                    <?php }?>
                <?php endforeach ?>
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
