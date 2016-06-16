<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet"	href="static/js/kindeditor410/themes/default/default.css" />
    <script type="text/javascript" src="static/js/jquery-1.11.2.min.js"></script>
    <script charset="utf-8" src="static/js/kindeditor410/kindeditor.js?2"></script>
    <script charset="utf-8" src="static/js/kindeditor410/lang/zh_CN.js"></script>
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="static/js/common.js?1"></script>
    <link rel="stylesheet" type="text/css" href="static/js/datepicker/default.css" />
    <script type="text/javascript" src="static/js/datepicker/zebra_datepicker.js"></script>
    <style>
        button { color: #666; font: 14px "Arial", "Microsoft YaHei", "微软雅黑", "SimSun", "宋体"; line-height: 20px; }
    </style>
    <script>
        $(document).ready(function(){
            // 日期
            $('#pubdate').Zebra_DatePicker({
                months:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                days:['日', '一', '二', '三', '四', '五', '六'],
                lang_clear_date:'清除',
                show_select_today:'今天'
            });
            //弹出选择教师
            $("#teachername").click(function(){
                teacherdialog=dialog_url('index.php?d=admin&c=teacher&m=dialog','选择教师：');
            });
            $("#studentname").click(function(){
                var classname = ($("#classname").val());
                var classid = ($("#classid").val());
                studentdialog = dialog_url('index.php?d=admin&c=student&m=dialog&classid='+encodeURIComponent(classid),'选择'+classname+'学生：');
            });
        });
    </script>
</head>
<body>
    <form id="form" action="<?=$this->baseurl?>&m=save" method="post">
        <div class="container-fluid">
            <div style=" margin:20px; font-size:13px;">
                <style>
                    .table>thead>tr>th,
                    .table>tbody>tr>th,
                    .table>tfoot>tr>th,
                    .table>thead>tr>td,
                    .table>tbody>tr>td,
                    .table>tfoot>tr>td {
                    vertical-align:middle;
                        text-align:center;
                    }
                    .stafftable input {
                        border:0px;
                        border-bottom:solid 1px #808080;
                        font-weight:bold;
                        padding-bottom:2px;
                        margin:4px;
                </style>
                <!-- 1 -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 style="text-align: center">南宁十三中---学生和家长评议教师表</h3> 
                        <div class="pull-center">
                            <table width="95%" class="table table-condensed  stafftable" >
                                <tbody>
                                <tr>
                                    <th>受评教师</th>
                                    <td width="30%">
                                        <input value="" id="teachername" type="text"  class="form-control">
                                        <input type="hidden" name="value[teacherid]" id="teacherid" value="">
                                    </td>
                                    <th>孩子所在班级:</th>
                                    <td width="30%">
                                        <input value="" id="classname" onclick="show_classname()" type="text"  class="form-control">
                                        <input type="hidden"  id="classid" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <th>孩子姓名:</th>
                                    <td width="30%">
                                        <input value="" id="studentname" type="text"  class="form-control">
                                        <input type="hidden" name="value[studentid]" id="studentid" value="">
                                    </td>
                                    <th>评价时间:</th>
                                    <td width="30%">
                                        <input value="<?=$pubdate?>" name="value[pubdate]" id="pubdate" type="text"  class="form-control">
                                    </td>
                                </tr>
                                </tbody>
                                </table>   

                        </div>

                    </div>
                    <div class="panel-body">
                            <table width="95%" class="table table-condensed  stafftable" >
                                <tbody>
                                <tr height=20 align="center">   <!--2-->
                                    <th width=60 rowspan="2">评价项目</th>
                                    <th width=120 rowspan="2">评 价 标 准</th>
                                    <th width=300 colspan="3">评价等级权重</th>
                                    <th width=60 colspan="2">得 分</th>
                                </tr>
                                <tr height=20 align="center">
                                    <td width=20>A</td>
                                    <td width=20>B</td>
                                    <td width=20>C</td>
                                    <td width=20></td>
                                </tr>
                                <tr>
                                    <td>师德修养 <br>10分</td>
                                    <td>爱岗敬业，工作认真。尊重家长，与家长交往、沟通时态度和气、语言亲切礼貌。尊重学生、关心、爱护每一个学生，获得学生的喜爱、信任，无体罚和变相体罚学生现象。不擅自向学生家长征订、推销学习资料或其他用品；不向学生及其家长索要钱物、不收礼吃请。</td>
                                    <td>10</td>
                                    <td>8</td>
                                    <td>5</td>
                                    <td><input name="value[morality]" type="text" style="width:36px; text-align:center; font-size:18px; font-weight:bold;" value="" maxlength="2" onChange="onNumCheck(this,'10');" onBlur="onNumCheck(this,'10');"></td>
                                </tr>
                                <tr>
                                    <td>家访情况 <br>10分</td>
                                    <td>能主动家访，或通过电话、书信等形式与家长沟通交流，及时反映学生学习活动情况。</td>
                                    <td>10</td>
                                    <td>8</td>
                                    <td>5</td>
                                    <td><input name="value[visits]" type="text" style="width:36px; text-align:center; font-size:18px; font-weight:bold;" value="" maxlength="2" onChange="onNumCheck(this,'10');" onBlur="onNumCheck(this,'10');"></td>
                                </tr>
                                <tr>
                                    <td>课堂教学 <br>30分</td>
                                    <td>教学理念先进，能积极实施新课堂教学，能根据教学设计组织教学活动，并作为参与者和组织者对课堂教学活动过程进行有效的引导，能充分体现学生的主体地位，能用多种方式调动学生参与学习的兴趣，保证课堂教学效果。</td>
                                    <td>30</td>
                                    <td>24</td>
                                    <td>15</td>
                                    <td><input name="value[chalkface]" type="text" style="width:36px; text-align:center; font-size:18px; font-weight:bold;" value="" maxlength="2" onChange="onNumCheck(this,'30');" onBlur="onNumCheck(this,'30');"></td>
                                </tr>
                                <tr>
                                    <td>作业批改 <br>情况 <br>20分</td>
                                    <td>作业适量，没有以增加作业量的方式惩罚学生的行为，作业形式多样化，有书面、口头和实践性的作业。作业与试卷批改及时、认真、规范，有激励性和指导性语言，反馈及时，且形式多样。</td>
                                    <td>20</td>
                                    <td>16</td>
                                    <td>10</td>
                                    <td><input name="value[correction]" type="text" style="width:36px; text-align:center; font-size:18px; font-weight:bold;" value="" maxlength="2" onChange="onNumCheck(this,'20');" onBlur="onNumCheck(this,'20');"></td>
                                </tr>
                                <tr>
                                    <td>学生习惯<br> 养成情况 <br>20分</td>
                                    <td>在教师的指导下，学生生活、学习习惯有无明显进步如：写字姿势是否正确，能否及时完成作业、关爱父母、尊敬老师、礼貌待人、关心社会、爱护公物、保护环境等。</td>
                                    <td>20</td>
                                    <td>16</td>
                                    <td>10</td>
                                    <td><input name="value[habitual]" type="text" style="width:36px; text-align:center; font-size:18px; font-weight:bold;" value="" maxlength="2" onChange="onNumCheck(this,'20');" onBlur="onNumCheck(this,'20');"></td>
                                </tr>
                                <tr>
                                    <td>教学效果 <br>10分</td>
                                    <td>教学效果好，学生积极主动参与学习活动；形成并基本掌握所学知识与技能；在学习活动中，学生的情感、态度与价值观得到和谐发展，教学成绩优异。</td>
                                    <td>10</td>
                                    <td>8</td>
                                    <td>5</td>
                                    <td><input name="value[effect]" type="text" style="width:36px; text-align:center; font-size:18px; font-weight:bold;" value="" maxlength="2" onChange="onNumCheck(this,'10');" onBlur="onNumCheck(this,'10');"></td>
                                </tr>
                                <tr>
                                    <td>总计</td>
                                    <td>计6项</td>
                                    <td>100</td>
                                    <td>80</td>
                                    <td>50</td>
                                    <td></td>
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
    <script type="text/javascript" charset="utf-8">
        function onNumCheck(the,num){
            if(the.value == '') the.value = 0;
            if(parseInt(the.value) > parseInt(num)) {
                alert('超出限制分数 '+num+' !');
                the.value = num;
                the.focus();
            } else {
                the.value = parseInt(the.value);
            }
        }
    </script>
    </body>
</html>