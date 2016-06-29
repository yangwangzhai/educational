<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>查看解析</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>

<body>
<form action="<?=$this->baseurl?>&m=question_save" method="post">
    <div class="container-fluid">
        <div style=" margin:20px; font-size:13px;">
            <style>
                .img-thumbnail{ width:90px; height:100px; }
                .stafftable th {
                    text-align:right; vertical-align:central;
                }
                .table>thead>tr>th,
                .table>tbody>tr>th,
                .table>tfoot>tr>th,
                .table>thead>tr>td,
                .table>tbody>tr>td,
                .table>tfoot>tr>td {
                    vertical-align:middle;
                }
            </style>
            <!-- 1 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    查看解析
                </div>
                <div class="panel-body">
                    <table class="table table-condensed  stafftable">
                        <tbody>
                        <tr>
                            <th>题干</th>
                            <td colspan="16">
                                <!-- 加载编辑器的容器 -->
                                <script id="content" name="value[content]" type="text/plain" style="height:300px;width:1000px">
                                    <?= $answer['content']?>
                                </script>
                            </td>
                        </tr>
                        <tr class="answerTr" id="answerJisuan">
                            <th>答案</th>
                            <td colspan="16">
                                <!-- 加载编辑器的容器 -->
                                <script id="answer" name="value[answer]" type="text/plain" style="height:500px;width:1000px">
                                    <?= $answer['answer']?>
                                </script>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- 配置文件 -->
<script type="text/javascript" src="static/admin/js/ueditor1_4_3-utf8-php/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="static/admin/js/ueditor1_4_3-utf8-php/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue_content = UE.getEditor('content');
</script>
<script type="text/javascript">
    var ue_anwser = UE.getEditor('answer');
</script>
</body>
</html>