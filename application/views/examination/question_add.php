<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>添加试题</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>
<script type="application/javascript">
    $(document).ready(function(){
        $("#selSubject").on("change",function(){
            var subjectid=$("#selSubject").val();
            $.ajax({
                url: "index.php?d=examination&c=test&m=get_knowledge_catogery_questionType",   //后台处理程序
                type: "post",         //数据发送方式
                dataType:"json",    //接受数据格式
                data:{subjectid:subjectid},  //要传递的数据
                success:function(data){
                    //知识点
                    if(data['catogery']){
                        $("#selknowledge").children().remove();
                        $("#selknowledge").append("<option value='0'>顶级分类</option>");
                        $.each(data['catogery'],function(key,val){
                            var space='';
                            for(var i=0;i<parseInt(val['level']);i++){
                                space +="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            }
                            $("#selknowledge").append("<option value="+val['id']+">"+space+val['knowledge_point']+"</option>");
                        });
                    }else{
                        $("#selknowledge").append("<option value='0'>顶级分类</option>");
                    }
                    //题型
                    if(data['question_type']){
                        $("#selQuestionType").children().remove();
                        $.each(data['question_type'],function(key,val){
                            $("#selQuestionType").append("<option value="+val['id']+">"+val['question_type']+"</option>");
                        });
                    }else{
                        $("#selQuestionType").append("<option value=''>未选择</option>");
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown)
                {
                    //alert(errorThrown);
                }
            });
        });

        $("#selQuestionType").on("change",function(){
            var questionType=$("#selQuestionType").find("option:selected").text();
            if(questionType=="单选题"){
                $(".answerTr").hide();
                $("#answerRadio").show();
            }else if(questionType=="多选题"){
                $(".answerTr").hide();
                $("#answerCheckbox").show()
            }else if(questionType=="填空题"){
                $(".answerTr").hide();
                $("#answerTiankong").show()

            }else if(questionType=="判断题"){
                $(".answerTr").hide();
                $("#answerPanduan").show()
            }else {
                $(".answerTr").hide();
                $("#answerJisuan").show()
            }
        })

    })
</script>

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
                    添加试题
                </div>
                <div class="panel-body">
                    <table class="table table-condensed  stafftable">
                        <tbody>
                        <tr>
                            <th>科目</th>
                            <td>
                                <select name="value[subjectid]" class="form-control" id="selSubject">
                                    <option>未选择</option>
                                    <?php foreach($subject as $value) : ?>
                                        <option value="<?php echo $value['id'];?>">
                                            <?php echo $value['subject'];?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <th>知识点</th>
                            <td>
                                <select name="value[knowledge_pointid]" class="form-control" id="selknowledge">
                                    <option value="">未选择</option>
                                </select>
                            </td>
                            <th>题型</th>
                            <td>
                                <select name="value[question_typeid]" class="form-control" id="selQuestionType">
                                    <option value="">未选择</option>
                                </select>
                            </td>
                            <th>难度</th>
                            <td>
                                <select name="value[difficulty_degreeid]" class="form-control">
                                    <?php foreach($difficulty_degree as $value) : ?>
                                        <option value="<?php echo $value['id'];?>">
                                            <?php echo $value['difficulty_degree'];?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>题干</th>
                            <td colspan="16">
                                <!-- 加载编辑器的容器 -->
                                <script id="content" name="value[content]" type="text/plain" style="height:300px;width:1000px"></script>
                            </td>
                        </tr>
                        <!--试题为单选题时答案的样式-->
                        <tr class="answerTr" id="answerRadio">
                            <th>答案</th>
                            <td>
                                <label style="padding-left: 10px;"><input type="radio" name="value[answer]" value="A" checked="checked" >&nbsp;A</label>
                                <label style="padding-left: 10px;"><input type="radio" name="value[answer]" value="B" >&nbsp;B</label>
                                <label style="padding-left: 10px;"><input type="radio" name="value[answer]" value="C" >&nbsp;C</label>
                                <label style="padding-left: 10px;"><input type="radio" name="value[answer]" value="D" >&nbsp;D</label>
                            </td>
                        </tr>
                        <!--试题为多选题时答案的样式-->
                        <tr class="answerTr" id="answerCheckbox" style="display: none;">
                            <th>答案</th>
                            <td>
                                <label style="padding-left: 10px;"><input type="checkbox" name="value[answer]" value="A" checked="" autocomplete="off">&nbsp;A</label>
                                <label style="padding-left: 10px;"><input type="checkbox" name="value[answer]" value="B" autocomplete="off">&nbsp;B</label>
                                <label style="padding-left: 10px;"><input type="checkbox" name="value[answer]" value="C" autocomplete="off">&nbsp;C</label>
                                <label style="padding-left: 10px;"><input type="checkbox" name="value[answer]" value="D" autocomplete="off">&nbsp;D</label>
                            </td>
                        </tr>
                        <!--试题为填空题时答案的样式-->
                        <tr class="answerTr" id="answerTiankong" style="display: none;">
                            <th>答案</th>
                            <td>
                                <input name="value[answer]"   value="" class="form-control" />
                            </td>
                        </tr>
                        <!--试题为判定题时答案的样式-->
                        <tr class="answerTr" id="answerPanduan" style="display: none;">
                            <th>答案</th>
                            <td>
                                <label style="padding-left: 10px;"><input type="radio" name="value[answer]" value="true" checked="" autocomplete="off">&nbsp;对</label>
                                <label style="padding-left: 10px;"><input type="radio" name="value[answer]" value="false" autocomplete="off">&nbsp;错</label>
                            </td>
                        </tr>
                        <!--试题为问答题、计算题、证明题、作图题等时答案的样式-->
                        <tr class="answerTr" id="answerJisuan" style="display: none;">
                            <th>答案</th>
                            <td colspan="16">
                                <!-- 加载编辑器的容器 -->
                                <script id="answer" name="value[answer]" type="text/plain" style="height:500px;width:1000px"></script>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <input type="submit" name="" id="submit" value="添加"  class="btn btn-primary">
                    <input type="submit" name="" value="取消" onclick="javascript:history.back();" class="btn btn-danger">
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