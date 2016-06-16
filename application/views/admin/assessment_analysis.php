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

</head>
<body>

<h3 class="text-center"><?=$grade?>年级<?=$classname?>学生对教师满意度调查统计结果</h3>
<form method="post" action="<?=$this->baseurl?>&m=save_assessment">
    <table class="table table-bordered">
        <tbody>
        <tr>
            <td rowspan="2"><?=$classname?></td>
            <td rowspan="2" style="width: 80px;">调查内容</td>
            <?php foreach($teacher as $key=>$value): ?>
                <td colspan="3" style="text-align: center;border-right-width: 3px;"><?= $value['teacher']?>(<?= $value['course']?>)</td>
            <?php endforeach?>
        </tr>
        <tr>
            <?php foreach($teacher as $key=>$value): ?>
                <td>满意</td>
                <td>基本满意</td>
                <td style="border-right-width: 3px;">不满意</td>
            <?php endforeach?>
        </tr>
        <tr>
            <td rowspan="2">师德表现</td>
            <td>关爱学生</td>
            <?php foreach($list['love_student'] as $key=>$value): ?>
                <td><?=$value['best']?></td>
                <td><?=$value['well']?></td>
                <td style="border-right-width: 3px;"><?=$value['bad']?></td>
            <?php endforeach?>
        </tr>
        <tr>
            <td>工作态度</td>
            <?php foreach($list['work_attidute'] as $key=>$value): ?>
                <td ><?=$value['best']?></td>
                <td ><?=$value['well']?></td>
                <td style="border-right-width: 3px;"><?=$value['bad']?></td>
            <?php endforeach?>
        </tr>
        <tr>
            <td rowspan="2">专业能力</td>
            <td>教学能力</td>
            <?php foreach($list['teach_ability'] as $key=>$value): ?>
                <td ><?=$value['best']?></td>
                <td ><?=$value['well']?></td>
                <td style="border-right-width: 3px;"><?=$value['bad']?></td>
            <?php endforeach?>
        </tr>
        <tr>
            <td>教学方法</td>
            <?php foreach($list['teach_way'] as $key=>$value): ?>
                <td ><?=$value['best']?></td>
                <td ><?=$value['well']?></td>
                <td style="border-right-width: 3px;"><?=$value['bad']?></td>
            <?php endforeach?>
        </tr>
        <tr>
            <td rowspan="2">教学情况</td>
            <td>课堂管理</td>
            <?php foreach($list['teach_condition'] as $key=>$value): ?>
                <td ><?=$value['best']?></td>
                <td ><?=$value['well']?></td>
                <td style="border-right-width: 3px;"><?=$value['bad']?></td>
            <?php endforeach?>
        </tr>
        <tr>
            <td>作业批改</td>
            <?php foreach($list['homework_correct'] as $key=>$value): ?>
                <td ><?=$value['best']?></td>
                <td ><?=$value['well']?></td>
                <td style="border-right-width: 3px;"><?=$value['bad']?></td>
            <?php endforeach?>
        </tr>
        <tr>
            <td colspan="2">总体评价</td>
            <?php foreach($list['general_evaluation'] as $key=>$value): ?>
                <td ><?=$value['best']?></td>
                <td ><?=$value['well']?></td>
                <td style="border-right-width: 3px;"><?=$value['bad']?></td>
            <?php endforeach?>
        </tr>
        </tbody>
    </table>

</form>
</body>
</html>


