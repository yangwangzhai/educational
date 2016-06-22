<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>试题库</title>
    <link rel="stylesheet" type="text/css" href="static/cloud/css/cloud-admin.css" >
    <link rel="stylesheet" type="text/css" href="static/examination/css/exam.css" >
    <link href="static/cloud/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="static/examination/knowledege/css/styles.css" type="text/css" />
    <script type="text/javascript" src="static/examination/knowledege/js/jquery-1.8.2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="static/examination/knowledege/css/min/ytkgb.css">
    <style type="text/css">
        .h2{font-size:10px;}
        h3{margin-top: 0px;}
    </style>
    <style type="text/css">
        body, h1, h2, h3, h4, h5, h6, p, form, ul, li, td, th, table, dl, dt, dd {
            margin: 0px;
            padding: 0px;
            list-style: none;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".knowledge").on("click",function(){
                $(".knowledge").removeClass("select_knowledge");
                $(this).addClass("select_knowledge");
                var knowledge_pointid=$(this).attr("data-id");
                var question_typeid=$(".this").attr("questionType");
                var difficultyDegreeid=$(".diff").attr("difficultyDegree");
                var subjectid=$("#subject").val();

                location.href="index.php?d=examination&c=Test&m=index&knowledge_point_id="+knowledge_pointid+"&question_typeid="+question_typeid+"&difficultyDegreeid="+difficultyDegreeid+"&subjectid="+subjectid;
            })
            $(".question_type").on("click",function(){
                $(".question_type").removeClass("this");
                $(this).addClass("this");
                var question_typeid=$(this).attr("questionType");
                var knowledge_pointid=$(".select_knowledge").attr("data-id");
                var difficultyDegreeid=$(".diff").attr("difficultyDegree");
                var subjectid=$("#subject").val();

                location.href="index.php?d=examination&c=Test&m=index&knowledge_point_id="+knowledge_pointid+"&question_typeid="+question_typeid+"&difficultyDegreeid="+difficultyDegreeid+"&subjectid="+subjectid;
            })
            $(".difficultyDegree").on("click",function(){
                $(".difficultyDegree").removeClass("diff");
                $(this).addClass("diff");
                var question_typeid=$(".this").attr("questionType");
                var knowledge_pointid=$(".select_knowledge").attr("data-id");
                var difficultyDegreeid=$(this).attr("difficultyDegree");
                var subjectid=$("#subject").val();

                location.href="index.php?d=examination&c=Test&m=index&knowledge_point_id="+knowledge_pointid+"&question_typeid="+question_typeid+"&difficultyDegreeid="+difficultyDegreeid+"&subjectid="+subjectid;
            })
        });
    </script>
</head>
<body>

<div style="margin-left: 0px;margin-top: 20px;">
    <button type="button" class="btn btn-info" onclick="location.href='<?=$this->baseurl?>&m=question_add'">+试题</button>
    <span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
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
                                    <h4><i class="fa fa-bell"></i><?=$subject_name?>试题库</h4>
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
                                        <div class="left">
                                            <div class="lefttop">
                                                <h3><span class="label label-danger"><?=$subject_name?>知识点</span></h3>
                                            </div>
                                            <div>
                                                <input type="hidden" class="<?php if(empty($knowledge_point_id)){echo "select_knowledge";}?>" data-id="">
                                                <div class="leftbottom2" style="display: block;">
                                                    <?php if(!empty($one)){?>
                                                    <ul id="root">
                                                        <?php foreach($one as $one_key=>$one_value){?>
                                                        <li>
                                                            <span class="<?php if($one_value['id']==$parent_node[0]){echo "ren";}else{echo "add";}?>" style="vertical-align: middle;display: inline-block; cursor: pointer;"></span>
                                                            <label bgid="8462">
                                                                <input type="checkbox" value="8462">
                                                                <a href="javascript:void(0)" class="knowledge <?php if($knowledge_point_id==$one_value['id']){echo "select_knowledge";}?>" data-id="<?=$one_value['id']?>" style="<?php if($knowledge_point_id==$one_value['id']){echo "color:rgb(244, 60, 94)";}?>"><?=$one_value['knowledge_point']?></a>
                                                            </label>
                                                            <?php if(!empty($two[$one_value['id']])){?>
                                                            <ul class=" two " style="<?php if($one_value['id']==$parent_node[0]){echo "display:block";}else{echo "display:none";}?>">
                                                                <?php foreach($two[$one_value['id']] as $two_key=>$two_value){?>
                                                                <li>
                                                                    <span class="<?php if(!empty($three[$two_value['id']])&&($two_value['id']==$parent_node[1])){echo "ren";}else{if(!empty($three[$two_value['id']])&&($two_value['id']!=$parent_node[1])){echo "add";}else{echo "dis_none";}}?>" style="vertical-align: middle; display: inline-block; cursor: pointer;"></span>
                                                                    <label bgid="8463">
                                                                        <input type="checkbox" value="8463">
                                                                        <a href="javascript:void(0)" class="knowledge <?php if($knowledge_point_id==$two_value['id']){echo "select_knowledge";}?>" data-id="<?=$two_value['id']?>" style="<?php if($knowledge_point_id==$two_value['id']){echo "color:rgb(244, 60, 94)";}?>"><?=$two_value['knowledge_point']?></a>
                                                                    </label>
                                                                    <?php if(!empty($three[$two_value['id']])){?>
                                                                    <ul class="two" style="<?php if($two_value['id']==$parent_node[1]){echo "display:block";}else{echo "display:none";}?>">
                                                                        <?php foreach($three[$two_value['id']] as $three_key=>$three_value){?>
                                                                        <li>
                                                                            <span class="<?php if(!empty($four[$three_value['id']])&&($three_value['id']==$parent_node[2])){echo "ren";}else{if(!empty($four[$three_value['id']])&&($three_value['id']!=$parent_node[2])){echo "add";}else{echo "dis_none";}}?>
                                                                            " style="vertical-align: middle; display: inline-block; cursor: pointer;"></span>
                                                                            <label bgid="8464">
                                                                                <input type="checkbox" value="8464">
                                                                                <a href="javascript:void(0)" class="knowledge <?php if($knowledge_point_id==$three_value['id']){echo "select_knowledge";}?>" data-id="<?=$three_value['id']?>" style="<?php if($knowledge_point_id==$three_value['id']){echo "color:rgb(244, 60, 94)";}?>"><?=$three_value['knowledge_point']?></a>
                                                                            </label>
                                                                            <?php if(!empty($four[$three_value['id']])){?>
                                                                            <ul class="two" style="<?php if($three_value['id']==$parent_node[2]){echo "display:block";}else{echo "display:none";}?>">
                                                                                <?php foreach($four[$three_value['id']] as $four_key=>$four_value){?>
                                                                                <li>
                                                                                    <span class="<?php if(!empty($five[$four_value['id']])&&($four_value['id']==$parent_node[3])){echo "ren";}else{if(!empty($five[$four_value['id']])&&($four_value['id']!=$parent_node[3])){echo "add";}else{echo "dis_none";}}?>
                                                                                    " style="vertical-align: middle; display: inline-block; cursor: pointer;"></span>
                                                                                    <label bgid="14268">
                                                                                        <input type="checkbox" value="14268">
                                                                                        <a href="javascript:void(0)" class="knowledge <?php if($knowledge_point_id==$four_value['id']){echo "select_knowledge";}?>" data-id="<?=$four_value['id']?>" style="<?php if($knowledge_point_id==$four_value['id']){echo "color:rgb(244, 60, 94)";}?>"><?=$four_value['knowledge_point']?></a>
                                                                                    </label>
                                                                                    <?php if(!empty($five[$four_value['id']])){?>
                                                                                    <ul class="two" style="<?php if($four_value['id']==$parent_node[3]){echo "display:block";}else{echo "display:none";}?>">
                                                                                        <?php foreach($five[$four_value['id']] as $five_key=>$five_value){?>
                                                                                        <li>
                                                                                            <span class="dis_none" style="vertical-align: middle; display: inline-block; cursor: pointer;"></span>
                                                                                            <label bgid="15268">
                                                                                                <input type="checkbox" value="15268">
                                                                                                <a href="javascript:void(0)" class="knowledge <?php if($knowledge_point_id==$five_value['id']){echo "select_knowledge";}?>" data-id="<?=$five_value['id']?>" style="<?php if($knowledge_point_id==$five_value['id']){echo "color:rgb(244, 60, 94)";}?>"><?=$five_value['knowledge_point']?></a>
                                                                                            </label>
                                                                                        </li>
                                                                                        <?php }?>
                                                                                    </ul>
                                                                                    <?php }?>
                                                                                </li>
                                                                                <?php }?>
                                                                            </ul>
                                                                        <?php }?>
                                                                        </li>
                                                                    <?php }?>
                                                                    </ul>
                                                                <?php }?>
                                                                </li>
                                                            <?php }?>
                                                            </ul>
                                                            <?php }?>
                                                        </li>
                                                        <?php }?>
                                                    </ul>
                                                    <?php }?>
                                                    <div style="clear:both;"></div>
                                                    <script src="static/examination/knowledege/js/roottree.js"></script>
                                                </div>
                                                <div style="clear:both;"></div>
                                            </div>
                                        </div>
                                        <div class="test_right">
                                            <div class="choiceSearch">
                                                <div class="choice">
                                                    <div class="choiceItem choiceItem3 guideStep">
                                                        <dl>
                                                            <dt title="题型">题型</dt>
                                                            <dd>
                                                                <a title="全部" href="javascript:void(0)" class="question_type <?php if(empty($question_typeid)){echo "this";}?>" questionType="">全部</a>
                                                                <?php foreach($question_type as $q): ?>
                                                                    <a title="<?=$q['question_type']?>" class="question_type <?php if($question_typeid==$q['id']){echo "this";}?>"
                                                                       href="javascript:void(0)" questionType="<?=$q['id']?>"><?=$q['question_type']?>
                                                                    </a>
                                                                <?php endforeach ?>
                                                                <a title="其他" href="javascript:void(0)">其他</a>
                                                            </dd>
                                                        </dl>
                                                        <div class="guideBox" id="guideBox71">
                                                            <div id="tipbar71" class="tipbar"></div>
                                                            <div id="step71" class="tipbox">
                                                                <div class="tipword"></div>
                                                                <span onclick="hideTip7()" class="tipboxBtn" style="left:117px;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="choiceItem choiceItem3">
                                                        <dl>
                                                            <dt title="难度系数">难度系数</dt>
                                                            <dd>
                                                                <a title="全部" class="difficultyDegree <?php if(empty($difficultyDegreeid)){echo "diff";}?>"
                                                                   href="javascript:void(0)" difficultyDegree="">全部
                                                                </a>
                                                                <?php foreach($difficulty_degree as $d): ?>
                                                                    <a title="<?=$d['difficulty_degree']?>" class="difficultyDegree <?php if($difficultyDegreeid==$d['id']){echo "diff";}?>"
                                                                       href="javascript:void(0)" difficultyDegree="<?=$d['id']?>"><?=$d['difficulty_degree']?>
                                                                    </a>
                                                                <?php endforeach ?>

                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php foreach($question as $value): ?>
                                            <div class="detailsBox mb">
                                                <div class="detailsTxt detailsTxt1">
                                                    <div class="txt">
                                                        <div class="quesdiv">
                                                            <div>
                                                                <font class="reportError" sub_id="20" exam_id="954028" style="display: none;">报错</font>
                                                                <!--<img src="http://yitikuimage.oss-cn-qingdao.aliyuncs.com/201505/15/57247211922219632086517161721488771361419894104338954028">-->
                                                                <?=$value['content']?>
                                                            </div>
                                                        </div>
                                                        <div class="handle">
                                                            <ul>
                                                                <li><a href="">查看解析</a></li>
                                                                <li><a href="">收藏题目</a></li>
                                                            </ul>
                                                            <div>
                                                                <u>
                                                                    难度系数：
                                                                    <i><?=$value['difficulty_degreeid']?></i>
                                                                </u>
                                                                <u>
                                                                    浏览：
                                                                    <i>421</i>
                                                                    次
                                                                </u>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach ?>

                                        </div>
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