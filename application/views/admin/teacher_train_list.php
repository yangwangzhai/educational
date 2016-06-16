<!DOCTYPE html>
<html>
<head>
    <title>Bootstrap 实例 - 折叠（Collapse）插件方法</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="static/cloud/css/cloud-admin.css" >
    <link href="static/cloud/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>
<body>
<div style="margin-left: 10px;margin-top: 20px;">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">+教师培训</button>
    <span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
            年级<select name="grade" id="grade">
                <option value="0">全部</option>
                <option value="2013"<?php if($grade==2013){echo "selected=selected";}?>>2013</option>
                <option value="2014"<?php if($grade==2014){echo "selected=selected";}?>>2014</option>
                <option value="2015"<?php if($grade==2015){echo "selected=selected";}?>>2015</option>
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
                                    <h4><i class="fa fa-bell"></i><?=$grade?>级</h4>
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
                                            <th style="width: 100px;">序号</th>
                                            <th style="width: 100px;">年级</th>
                                            <th style="width: 100px;">姓名</th>
                                            <th style="width: 100px;">科目</th>
                                            <th style="width: 100px;">培训类型</th>
                                            <th style="width: 100px;">主题</th>
                                            <th style="width: 100px;">时间</th>
                                            <th style="width: 100px;">地点</th>
                                            <th style="width: 100px;">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($list as $key=>$value):?>
                                            <tr style="background:<?=$color[$grade_key]?>;">
                                                <td><?=$value['id']?></td>
                                                <td><?=$value['grade']?></td>
                                                <td>
                                                    <a data-toggle="tooltip" data-placement="right" title="<?= "电话：".$value['tel']?>"
                                                       href="<?=$this->baseurl?>&m=edit&id=<?=$value['id']?>"><?=$value['teacher']?>
                                                    </a>
                                                </td>
                                                <td><?=$value['course']?></td>
                                                <td><?=$value['type']?></td>
                                                <td><?=$value['title']?></td>
                                                <td><?=$value['date']?></td>
                                                <td><?=$value['address']?></td>
                                                <td>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#Modal_edit<?=$value['id']?>">修改</a>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a href="<?=$this->baseurl?>&m=delete&id=<?=$value['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
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
<!-- 添加教师培训的模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form role="form" method="post" action="<?=$this->baseurl?>&m=save_teacher_train">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        添加教师培训
                    </h4>
                </div>
                <div class="modal-body" style="height: 500px;">
                    <div class="form-group">
                        <label for="name">年级</label>
                        <input type="text" class="form-control" id="name" name="value[grade]"
                               placeholder="请输入年级">
                    </div>
                    <div class="form-group">
                        <label for="name">姓名</label>
                        <input type="text" class="form-control" id="name" name="value[teacher]"
                               placeholder="请输入姓名">
                    </div>
                    <div class="form-group">
                        <label for="name">科目</label>
                        <input type="text" class="form-control" id="name" name="value[course]"
                               placeholder="请输入科目">
                    </div>
                    <div class="form-group">
                        <label for="name">类型</label>
                        <input type="text" class="form-control" id="name" name="value[type]"
                               placeholder="请输入类型">
                    </div>
                    <div class="form-group">
                        <label for="name">主题</label>
                        <input type="text" class="form-control" id="name" name="value[title]"
                               placeholder="请输入主题">
                    </div>
                    <div class="form-group">
                        <label for="name">日期</label>
                        <input type="text" class="form-control" id="name" name="value[date]"
                               placeholder="请输入日期">
                    </div>
                    <div class="form-group">
                        <label for="name">地点</label>
                        <input type="text" class="form-control" id="name" name="value[address]"
                               placeholder="请输入地点">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="submit" class="btn btn-primary">
                        提交保存
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal -->
</div>
<?php foreach($list as $key=>$value):?>
    <!-- 修改教师培训的模态框（Modal） -->
    <div class="modal fade" id="Modal_edit<?=$value['id']?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="post" action="<?=$this->baseurl?>&m=save_teacher_train">
                <input type="hidden" name="id" value="<?=$value['id']?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            修改教师培训
                        </h4>
                    </div>
                    <div class="modal-body" style="height: 500px;">
                        <div class="form-group">
                            <label for="name">年级</label>
                            <input type="text" class="form-control" id="name" name="value[grade]"
                                   placeholder="请输入年级" value="<?=$value['grade']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">姓名</label>
                            <input type="text" class="form-control" id="name" name="value[teacher]"
                                   placeholder="请输入姓名" value="<?=$value['teacher']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">科目</label>
                            <input type="text" class="form-control" id="name" name="value[course]"
                                   placeholder="请输入科目" value="<?=$value['course']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">类型</label>
                            <input type="text" class="form-control" id="name" name="value[type]"
                                   placeholder="请输入类型" value="<?=$value['type']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">主题</label>
                            <input type="text" class="form-control" id="name" name="value[title]"
                                   placeholder="请输入主题" value="<?=$value['title']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">日期</label>
                            <input type="text" class="form-control" id="name" name="value[date]"
                                   placeholder="请输入日期" value="<?=$value['date']?>">
                        </div>
                        <div class="form-group">
                            <label for="name">地点</label>
                            <input type="text" class="form-control" id="name" name="value[address]"
                                   placeholder="请输入地点" value="<?=$value['address']?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">关闭
                        </button>
                        <button type="submit" class="btn btn-primary">
                            提交保存
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal -->
    </div>
<?php endforeach ?>
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