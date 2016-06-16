<!DOCTYPE html>
<html>
<head>
    <title>教师测评</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <style>
        .table-bordered>tbody>tr>td{vertical-align: middle;width: 31px;cursor: pointer;}
        .aaa{color: #0000cc;font-size: large;font-weight: 700;}
    </style>
    <script type="application/javascript">
        $(document).ready(function(){
            $('.assessment').on('click',function(){
                var label=$(this).attr('lb');
                var obj=$("td[lb="+label+"]");
                for(var i=0;i<obj.length;i++){
                    obj.eq(i).children().first().val('');
                    obj.eq(i).find('span').remove();
                }
                $(this).children().first().val(1);
                $(this).append('<span class="aaa">√</span>')
            });
        })
    </script>
</head>
<body>

    <h3 class="text-center"><?=$grade?>级<?=$classname?>班学生对教师满意度调查表</h3>
    <p style="background-color: #ce8483">寄语学生：本调查是为了了解你对任课教师的满意程度，请你以客观、公正的态度，实事求是地在下列表格里你认为恰当评价的项目中打“√”。</p>
    <form method="post" action="<?=$this->baseurl?>&m=save_assessment">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td rowspan="2" >序号</td>
                <td rowspan="2" style="width: 80px;">调查内容</td>
                <?php foreach($list as $key=>$value): ?>
                <td colspan="3" style="text-align: center;border-right-width: 3px;"><?= $value['course']?>老师</td>
                <?php endforeach?>
            </tr>
            <tr>
                <?php foreach($list as $key=>$value): ?>
                <td>满意</td>
                <td>基本满意</td>
                <td style="border-right-width: 3px;">不满意</td>
                <?php endforeach?>
            </tr>
            <tr>
                <td rowspan="2">师德表现</td>
                <td>关爱学生</td>
                <?php foreach($list as $key=>$value): ?>
                <td class="assessment" lb="love_student<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][love_student][best]" value=""></td>
                <td class="assessment" lb="love_student<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][love_student][well]" value=""></td>
                <td class="assessment" lb="love_student<?=$value['id']?>" style="border-right-width: 3px;"><input type="hidden" name="value[<?=$value['id']?>][love_student][bad]" value=""></td>
                <?php endforeach?>
            </tr>
            <tr>
                <td>工作态度</td>
                <?php foreach($list as $key=>$value): ?>
                <td class="assessment" lb="work_attidute<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][work_attidute][best]" value=""></td>
                <td class="assessment" lb="work_attidute<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][work_attidute][well]" value=""></td>
                <td style="border-right-width: 3px;" class="assessment" lb="work_attidute<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][work_attidute][bad]" value=""></td>
                <?php endforeach?>
            </tr>
            <tr>
                <td rowspan="2">专业能力</td>
                <td>教学能力</td>
                <?php foreach($list as $key=>$value): ?>
                <td class="assessment" lb="teach_ability<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][teach_ability][best]" value=""></td>
                <td class="assessment" lb="teach_ability<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][teach_ability][well]" value=""></td>
                <td style="border-right-width: 3px;" class="assessment" lb="teach_ability<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][teach_ability][bad]" value=""></td>
                <?php endforeach?>
            </tr>
            <tr>
                <td>教学方法</td>
                <?php foreach($list as $key=>$value): ?>
                <td class="assessment" lb="teach_way<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][teach_way][best]" value=""></td>
                <td class="assessment" lb="teach_way<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][teach_way][well]" value=""></td>
                <td style="border-right-width: 3px;" class="assessment" lb="teach_way<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][teach_way][bad]" value=""></td>
                <?php endforeach?>
            </tr>
            <tr>
                <td rowspan="2">教学情况</td>
                <td>课堂管理</td>
                <?php foreach($list as $key=>$value): ?>
                <td class="assessment" lb="teach_condition<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][teach_condition][best]" value=""></td>
                <td class="assessment" lb="teach_condition<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][teach_condition][well]" value=""></td>
                <td style="border-right-width: 3px;" class="assessment" lb="teach_condition<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][teach_condition][bad]" value=""></td>
                <?php endforeach?>
            </tr>
            <tr>
                <td>作业批改</td>
                <?php foreach($list as $key=>$value): ?>
                <td class="assessment" lb="homework_correct<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][homework_correct][best]" value=""></td>
                <td class="assessment" lb="homework_correct<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][homework_correct][well]" value=""></td>
                <td style="border-right-width: 3px;" class="assessment" lb="homework_correct<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][homework_correct][bad]" value=""></td>
                <?php endforeach?>

            </tr>
            <tr>
                <td colspan="2">总体评价</td>
                <?php foreach($list as $key=>$value): ?>
                <td class="assessment" lb="general_evaluation<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][general_evaluation][best]" value=""></td>
                <td class="assessment" lb="general_evaluation<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][general_evaluation][well]" value=""></td>
                <td style="border-right-width: 3px;" class="assessment" lb="general_evaluation<?=$value['id']?>"><input type="hidden" name="value[<?=$value['id']?>][general_evaluation][bad]" value=""></td>
                <?php endforeach?>
            </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="center-block" style="width:200px;">
                <button type="submit" class="btn btn-primary">提交保存</button>
            </div>
        </div>
    </form>
</body>
</html>


