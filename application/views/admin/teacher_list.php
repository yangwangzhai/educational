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

    <script type="application/javascript">
        $(document).ready(function() {
            $(".handle").on("click", function () {
                $(".handle_menu").hide();
                if ($(this).attr("display_flag") == "false") {
                    $(this).parent().next().show();
                    $(".handle").attr("display_flag", "false");
                    $(this).attr("display_flag", "true");
                } else {
                    $(this).parent().next().hide();
                    $(this).attr("display_flag", "false");
                }
            })
        })

    </script>

</head>
<body>

<div style="margin-left: 0px;margin-top: 20px;">
    <button type="button" class="btn btn-info" onclick="location.href='<?=$this->baseurl?>&m=add'">添加教师</button>
    <button type="button" class="btn btn-info" onclick="location.href='<?=$this->baseurl?>&m=synchronize'">更新数据</button>
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
                                    <h4><i class="fa fa-bell"></i><?=$grade?>级老师</h4>
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
                                            <th style="width: 100px;">编号</th>
                                            <th style="width: 100px;">姓名</th>
                                            <th style="width: 100px;">教学科目</th>
                                            <th style="width: 100px;">所教班级</th>
                                            <th style="width: 100px;">主管班级</th>
                                            <th style="width: 100px;">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($list as $key=>$value):?>
                                            <tr>
                                                <td><?=$value['id']?></td>
                                                <td>
                                                    <a data-toggle="tooltip" data-placement="right" title="<?= "电话：".$value['tel']?>"
                                                       href="<?=$this->baseurl?>&m=edit&id=<?=$value['id']?>" ><?=$value['truename']?>
                                                    </a>
                                                </td>
                                                <td><?=$value['course']?></td>
                                                <td><?=$value['teach_class']?></td>
                                                <td><?=$value['manage_class']?></td>
                                                <td>
                                                    <a href="<?=$this->baseurl?>&m=delete&id=<?=$value['id']?>" class="font-red" title="">
                                                        删除
                                                    </a>
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