<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>教师列表</title>
    <link rel="stylesheet" type="text/css" href="static/cloud/css/cloud-admin.css" >
    <link href="static/cloud/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>
<body>

<div style="margin-left: 0px;margin-top: 20px;">
    <button type="button" class="btn btn-info" onclick="location.href='<?=$this->baseurl?>&m=knowledge_add'">+知识点</button>
    <span style="float: right">
		<form action="<?=$this->baseurl?>&m=knowledge" method="post">
            科目<select name="subjectid" id="subject">
                <?php foreach($subject as $s): ?>
                    <option value="<?=$s['id']?>"<?php if($s['id']==$subject_select){echo "selected=selected";}?>><?= $s['subject']?></option>
                <?php endforeach ?>
            </select>&nbsp&nbsp
            <input type="text" name="keywords" value="">
            <input type="submit" name="submit" value=" 搜索 " class="btn-success">
        </form>
	</span>
    <hr style="margin-bottom: 5px;margin-top: 5px;"/>
</div>
<!-- PAGE -->
<section id="page">
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div id="content" class="col-lg-12">
                    <!-- PAGE MAIN CONTENT -->
                    <div class="row">
                        <!-- MESSENGER -->
                        <div class="col-md-12">
                            <div class="box border blue" id="messenger">
                                <div class="box-title">
                                    <h4><i class="fa fa-bell"></i><?=$subject_name?>知识点</h4>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                        <a href="javascript:;" class="remove">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body ">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th style="width: 200px;">分类名称</th>
                                            <th style="width: 100px;">所属科目</th>
                                            <th style="width: 100px;">题目数量</th>
                                            <th style="width: 100px;">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($list as $key=>$value):?>
                                            <tr>
                                                <td>
                                                    <?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $value['level'])?>
                                                    <img src="static/examination/knowledege/images/menu_minus.gif">
                                                    <?=$value['knowledge_point']?>
                                                </td>
                                                <td><?=$value['subjectid']?></td>
                                                <td><?=$value['subjectid']?></td>
                                                <td>
                                                    <a href="<?=$this->baseurl?>&m=knowledge_edit&id=<?=$value['id']?>&subject_select=<?=$subject_select?>&p_id=<?=$value['p_id']?>&knowledge_point=<?=$value['knowledge_point']?>" class="font-red" title="">编辑</a>
                                                    <a href="<?=$this->baseurl?>&m=knowledge_delete&id=<?=$value['id']?>" class="font-red" onclick="return confirm('确定要删除吗？');">删除</a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /MESSENGER -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<!--/PAGE -->

<!-- JAVASCRIPTS -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- JQUERY -->
<script src="static/cloud/js/jquery/jquery-2.0.3.min.js"></script>
<!-- BOOTSTRAP -->
<script src="static/cloud/bootstrap-dist/js/bootstrap.min.js"></script>
<!-- COOKIE -->
<script type="text/javascript" src="static/cloud/js/jQuery-Cookie/jquery.cookie.min.js"></script>
<!-- CUSTOM SCRIPT -->
<script src="static/cloud/js/script.js"></script>
<script>
    jQuery(document).ready(function() {
        App.setPage("notifications");  //Set current page
        App.init(); //Initialise plugins and elements
    });
</script>
<!-- /JAVASCRIPTS -->
</body>
</html>