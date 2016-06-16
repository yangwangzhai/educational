<!DOCTYPE html>
<html>
<head>
    <title>课堂检查</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="static/plugin/bootstrap/js/bootstrap.min.js"></script>
    <style>
        .my_table>tbody>tr>th{margin:0; padding:0;width: 150px; }
        .my_table>tbody>tr>td{margin:0; padding:0;width: 150px; }
        .my_table>tbody>tr>td>input{margin:0; padding:0; width: 150px;height:52px;border: none;}
    </style>
</head>
<body>
    <form method="post" action="<?=$this->baseurl?>&m=save_check_content">
        <div class="row">
            <div class="center-block" style="width:850px;">
                <h3 class="text-center">南宁市第二十一中学<?=$check['term']?>学期课堂抽查记录  </h3>
                <p class="text-center">&nbsp;&nbsp;检查日期：<?=$check['date']?>&nbsp;&nbsp;第<?=$check['section']?>节&nbsp;&nbsp;检查人：</p>
                <table border="1" class="my_table">
                    <thead>
                    <tr>
                        <th >班别</th>
                        <th >科目</th>
                        <th >任课教师</th>
                        <th >课堂记录情况</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $key=>$value):?>
                        <tr>
                            <td><input type="text" name="value[<?=$key?>][classname]" value="<?=$value['classname']?>"></td>
                            <td><input type="text" name="value[<?=$key?>][course]" value="<?=$value['title']?>"></td>
                            <td><input type="text" name="value[<?=$key?>][teacher]" value="<?=$value['teacher_truename']?>"></td>
                            <td style="width: 400px;"><textarea style="width: 400px;" name="value[<?=$key?>][check_content]"><?=$value['check_content']?></textarea></td>
                        </tr>
                    <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="margin-top: 10px;">
            <div class="center-block" style="width:200px;">
                <button type="submit" class="btn btn-primary">提交保存</button>
            </div>
        </div>
    </form>
</body>
</html>
