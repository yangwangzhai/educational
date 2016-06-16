<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="static/ql/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="static/ql/js/jquery.js"></script>

    <script type="text/javascript">
        $(function(){
            //导航切换


            $('.title').click(function(){
                var $ul = $(this).next('ul.menuson');
                $('dd').find('ul.menuson').slideUp();
                if($ul.is(':visible')){
                    $(this).next('ul.menuson').slideUp();
                }else{
                    $(this).next('ul.menuson').slideDown();
                }
            });

            $('.sub_title').click(function(){
                $(this).toggleClass("active");
                var $sul = $(this).next('ul.sonsub');
                $('.sub_title').find('ul').slideUp();
                if($sul.is(':visible')){
                    $(this).next('ul.sonsub').slideUp();
                }else{
                    $(this).next('ul.sonsub').slideDown();
                }
            });



        })
    </script>


</head>

<body style="background:#0f7700;">
<dl class="leftmenu">
    <dd>
        <div class="title">教务处</div>
        <ul class="menuson">
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">教师管理</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=admin&c=teacher&m=index" target="rightFrame">教师信息</a></li>
                <!--<li><span></span><a href="index.php?d=admin&c=attendance&m=index" target="rightFrame">教师考勤</a></li>-->
                <li><span></span><a href="index.php?d=admin&c=teacher_train&m=index" target="rightFrame">教师培训</a></li>
                <li><span></span><a href="index.php?d=admin&c=assessment" target="rightFrame">教师满意度</a></li>
            </ul>
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">课堂管理</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=admin&c=classroom_manage&m=index" target="rightFrame">课堂检查</a></li>
                <li><span></span><a href="index.php?d=admin&c=homework&m=index" target="rightFrame">作业检查</a></li>
                <li><span></span><a href="javascript:void(0)" target="rightFrame">课堂听课</a></li>
            </ul>
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">教研管理</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=admin&c=teacher&m=teach_manage" target="rightFrame">教研组信息</a></li>
                <li><span></span><a href="index.php?d=admin&c=teacher&m=teach_activity_index" target="rightFrame">教研活动</a></li>
                <li><span></span><a href="index.php?d=admin&c=teacher&m=teach_activity_resource_index" target="rightFrame">计划、总结</a></li>
            </ul>
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">成绩管理</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=admin&c=test_score&m=statistic_list&grade='初一'" target="rightFrame">初一成绩</a></li>
                <li><span></span><a href="index.php?d=admin&c=test_score&m=statistic_list&grade='初二'" target="rightFrame">初二成绩</a></li>
                <li><span></span><a href="index.php?d=admin&c=test_score&m=statistic_list&grade='初三'" target="rightFrame">初三成绩</a></li>
            </ul>
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">任课监考</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=timetable&c=task&m=index" target="rightFrame">课程表</a></li>
                <li><span></span><a href="index.php?d=admin&c=invigilate&m=index" target="rightFrame">监考表</a></li>
                <li><span></span><a href="index.php?d=admin&c=test_score&m=notice" target="rightFrame">公告栏</a></li>
            </ul>
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">试题库管理</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=examination&c=test&m=knowledge" target="rightFrame">知识点</a></li>
                <li><span></span><a href="index.php?d=examination&c=test&m=index" target="rightFrame">试题管理</a></li>
                <li><span></span><a href="index.php?d=examination&c=test&m=index" target="rightFrame">组卷</a></li>
            </ul>
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">成长树</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=admin&c=grow_tree&m=index&grade='初一'" target="rightFrame">初一</a></li>
                <li><span></span><a href="index.php?d=admin&c=grow_tree&m=index&grade='初二'" target="rightFrame">初二</a></li>
                <li><span></span><a href="index.php?d=admin&c=grow_tree&m=index&grade='初三'" target="rightFrame">初三</a></li>
            </ul>

        </ul>
    </dd>

    <dd>
        <div class="title"></span>政教处</div>
        <ul class="menuson">
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">学生管理</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=admin&c=student&m=index" target="rightFrame">学籍档案</a></li>
                <li><span></span><a href="index.php?d=admin&c=physical&m=index" target="rightFrame">体质健康</a></li>
                <li><span></span><a href="index.php?d=admin&c=student_leave&m=index" target="rightFrame">学生请假</a></li>
            </ul>
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">家长管理</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=admin&c=parents&m=index" target="rightFrame">家长信息</a></li>
                <li><span></span><a href="index.php?d=admin&c=parents&m=main" target="rightFrame">家长分组</a></li>
                <li><span></span><a href="index.php?d=admin&c=feedback&m=index" target="rightFrame">家长反馈</a></li>
            </ul>
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">班级管理</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=admin&c=classroom&m=index" target="rightFrame">班级信息</a></li>
                <li><span></span><a href="index.php?d=admin&c=interest_group&m=index" target="rightFrame">兴趣小组</a></li>
            </ul>
            <li class="sub_title"><cite></cite><a href="javascript:void(0)" target="rightFrame">政教管理</a><i></i></li>
            <ul class="sonsub">
                <li><span></span><a href="index.php?d=admin&c=reward&m=index" target="rightFrame">奖惩选项</a></li>
                <li><span></span><a href="index.php?d=admin&c=student_reward&m=index" target="rightFrame">学生奖惩</a></li>
                <li><span></span><a href="index.php?d=admin&c=resource&m=index" target="rightFrame">教学素材</a></li>
            </ul>
        </ul>
    </dd>

    <dd>
        <div class="title">后台管理</div>
        <ul class="menuson">
            <li><cite></cite><a href="index.php?d=admin&c=admin&m=index" target="rightFrame">后台信息</a><i></i></li>
            <li><cite></cite><a href="#">用户设置</a><i></i></li>
        </ul>
    </dd>
</dl>

</body>
</html>
