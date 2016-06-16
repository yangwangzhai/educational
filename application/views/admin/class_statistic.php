<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />


</head>
<body>

    <div class="container-fluid">
        <div style=" margin:20px; font-size:13px;">

            <h3>班级综合统计</h3>
            <br> <br>

                <div class="panel panel-default">
                    <div class="panel-heading">
                            <h4>掌握本园学生班级分布情况<br></h4>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>年级</th>
                            <th>班级</th>
                            <th>学生数</th>
                            <th>主班老师</th>
                            <th>副班老师</th>
                            <th>保育人员</th>
                            <th>专科人员</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key=>$item):?>
                        <tr>
                            <td rowspan="<?=$item['num']?>"><?=$item['title']?></td>
                            <?php for($i=0;$i<$item['num'];$i++):?>
                            <td><?=$item['class'][$i]['alias']?></td>
                            <td><?=$item['class'][$i]['stu_num']?></td>
                            <td><?=$item['class'][$i]['tea_num']?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                                <tr>
                                <?php endfor;?>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
        </div>
        </div>
    </div>

</body></html>
