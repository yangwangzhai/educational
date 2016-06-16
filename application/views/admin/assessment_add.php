<?php $this->load->view('admin/header');?>
    <script type="text/javascript" src="static/js/raty/jquery.raty.js"></script>
    <script type="text/javascript" src="static/plugin/layer-v2.1/layer.js"></script>
    <script>
        $(document).ready(function(){
            run();             //加载页面时启动定时器
            var interval;
            function run() {
                interval = setInterval(get_score, "500");
            }
            function get_score()
            {
                var sum=0;
                var r = /^-?\d+$/ ;　//正整数
                $("input[name='morality[]']").each(function(){
                    if($(this).val() !=''&&!r.test($(this).val())){
                        $(this).val("");  //正则表达式不匹配置空
                    }else if($(this).val() !='') {
                        sum += parseInt($(this).val());
                    }

                });
                $("input[name='management[]']").each(function(){
                    if($(this).val() !=''&&!r.test($(this).val())){
                        $(this).val("");  //正则表达式不匹配置空
                    }else if($(this).val() !='') {
                        sum += parseInt($(this).val());
                    }
                });
                $("input[name='teaching[]']").each(function(){
                    if($(this).val() !=''&&!r.test($(this).val())){
                        $(this).val("");  //正则表达式不匹配置空
                    }else if($(this).val() !='') {
                        sum += parseInt($(this).val());
                    }
                });
                $("input[name='conservation[]']").each(function(){
                    if($(this).val() !=''&&!r.test($(this).val())){
                        $(this).val("");  //正则表达式不匹配置空
                    }else if($(this).val() !='') {
                        sum += parseInt($(this).val());
                    }
                });
                $("input[name='research[]']").each(function(){
                    if($(this).val() !=''&&!r.test($(this).val())){
                        $(this).val("");  //正则表达式不匹配置空
                    }else if($(this).val() !='') {
                        sum += parseInt($(this).val());
                    }
                });
                $("input[name='attendance[]']").each(function(){
                    if($(this).val() !=''&&!r.test($(this).val())){
                        $(this).val("");  //正则表达式不匹配置空
                    }else if($(this).val() !='') {
                        sum += parseInt($(this).val());
                    }
                });
                if(sum>=112)
                {
                    $("#total").html('');
                    $("#total").append("<tr height=50 align='center'><td><span>总分："+parseInt(sum/1.4)+"%</span></td></tr> <tr height=50 align='center'><td ><span>优秀：<img  src='static/admin_img/smile.jpg'></span></td></tr>");
                }
                else if(sum>=84 && sum<112)
                {
                    $("#total").html('');
                    $("#total").append("<tr height=50 align='center'><td><span>总分："+parseInt(sum/1.4)+"%</span></td></tr> <tr height=50 align='center'><td ><span>良好：<img  src='static/admin_img/good.jpg'></span></td></tr>");
                }
                else
                {
                    $("#total").html('');
                    $("#total").append("<tr height=50 align='center'><td><span>总分："+parseInt(sum/1.4)+"%</span></td></tr> <tr height=50 align='center'><td ><span>差：<img  src='static/admin_img/bad.jpg'></span></td></tr>");
                }

            }
            $('.score').raty({
                number: 5,//多少个星星设置
                score: 5,//初始值是设置
                targetType: 'number',//类型选择，number是数字值，hint，是设置的数组值
                path      : 'static/js/raty/img',
                cancelOff : 'cancel-off.png',
                cancelOn  : 'cancel-on.png',
                size      : 16,
                starHalf  : 'star-half.png',
                starOff   : 'star-off.png',
                starOn    : 'star-on.png',
                /*target    : '#function-hint1',*/
                cancel    : false,
                targetKeep: true,
                precision : false,//是否包含小数
                click: function(score, evt) {
                    $(this).children().val(score);
                }
            });
            //弹出选择教师
            $("#teachername").click(function(){
                var semester=$("select[name='value[semester]']").val();
                var MONTH=$("select[name='value[MONTH]']").val();
                layer.open({
                    type: 2,
                    title: '选择教师',
                    fix: false,
                    shadeClose: true,
                    maxmin: true,
                    area: ['768px', '400px'],
                    content: '<?=$this->baseurl?>&m=teacher_dialog&semester='+encodeURIComponent(semester)+'&MONTH='+encodeURIComponent(MONTH)
                });
            });
            //提交
            $("#submit").bind("click",function(){
                var teacherid=$("#teacherid").val();
                var semester=$("select[name='value[semester]']").val();
                var MONTH=$("select[name='value[MONTH]']").val();
                var flag=true;
                $.ajax({
                    url: "<?=$this->baseurl?>&m=check_data",   //后台处理程序
                    type: "post",         //数据发送方式
                    async:false,//取消异步请求
                    /*dataType:"json",   */ //接受数据格式
                    data:{teacherid:teacherid,MONTH:MONTH,semester:semester},  //要传递的数据
                    success:function(data){
                        if(data==1)
                        {
                            alert('老师的数据已经存在，不必重复添加');
                            flag=false;
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        alert(errorThrown);
                    }
                });
                return flag;
            });
            $(".score").each(function(){
                $(this).children().val(5);
            });
        });
    </script>
    <style>
        .my_table tr td{height: 35px;line-height: 35px;text-align: left}
    </style>
    <div class="mainbox nomargin">
        <form action="<?=$this->baseurl?>&m=save" method="post">
            <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                <tr>
                    <th width="90">评价学期<font color="red">*</font></th>
                    <td><select name="value[semester]">
                            <?=getSelect(config_item('semester'))?>
                        </select>
                        月份<select name="value[MONTH]">
                            <?=getSelect(config_item('MONTH'),$month)?>
                        </select></td>
                </tr>
                <tr>
                    <th width="90">评价老师<font color="red">*</font></th>
                    <td><input type="text" class="txt" id="teachername"
                               value="" />
                        <input type="hidden" class="txt" name="value[teacherid]" id="teacherid"
                               value="" /></td>
                </tr>
            </table>
            <table width="768" border="1" cellpadding="0" cellspacing="0" class="my_table">
                <tr style="height: 50px;text-align: center;border-bottom: #0099FF thin solid;">   <!--2-->
                    <td style="width: 60px;text-align: center;border-bottom: #0099FF thin solid;">项目</td>
                    <td style="width: 508px;text-align: center;border-bottom: #0099FF thin solid;" >具体内容</td>
                    <td style="width: 50px;text-align: center;border-bottom: #0099FF thin solid;" >占分</td>
                    <td style="width: 150px;text-align: center;border-bottom: #0099FF thin solid;">评    分</td>
                </tr>

                <tr style="height: 30px;text-align: center;">
                    <td style="width: 60px;text-align: center;border-bottom: #0099FF thin solid;"  rowspan="4">师德<br/>师风（20）</td>
                    <td style="height: 30px;line-height: 30px;">1.	遵章守纪，严守规范制度；上班准时；不无故外出。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="morality[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>2.	团结协作，乐于奉献；态度认真，责任心强。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="morality[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>3.	以身作则，为人师表；着装大方，便于活动。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="morality[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td style="border-bottom: #0099FF thin solid;">4.热爱学生，面向全体；师生关系融洽，一视同仁；无体罚与变相体罚（有此现象不得分）。</td>
                    <td style="text-align: center;border-bottom: #0099FF thin solid;">5</td>
                    <td class="score" style="text-indent: 5px;border-bottom: #0099FF thin solid;"><input type="text" name="morality[]" size="1"></td>
                </tr>

                <tr align="center">
                    <td style="width: 60px;text-align: center;border-bottom: #0099FF thin solid;" rowspan="4">常规<br/>管理（20）</td>
                    <td style="text-align: left;">1.	班级整体常规好（优秀得6分、良好得4分、一般得2分）。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="management[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>2.	学生安全无事故（有流血、缝针或学生走失等事件不得分）。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="management[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>3.	门窗水电管理和物品保管好（不开无人灯、无人水，物品无损坏、丢失发现2次扣2）。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="management[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td style="border-bottom: #0099FF thin solid;">4.	一日活动组织管理、安排到位。（有违纪者扣2分）</td>
                    <td style="text-align: center;border-bottom: #0099FF thin solid;">5</td>
                    <td class="score" style="text-indent: 5px;border-bottom: #0099FF thin solid;"><input type="text" name="management[]" size="1"></td>
                </tr>

                <tr align="center">
                    <td style="width: 60px;text-align: center;border-bottom: #0099FF thin solid;" rowspan="9">教育<br/>教学（45）</td>
                    <td style="text-align: left;">1.	认真制定和执行各类计划及总结，遵守作息时间，(不认真无分)。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="teaching[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>2.	认真组织一日活动(户外活动2次)，不串岗离岗不玩手机。(发现1次无分)</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="teaching[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>3.	运用普通话组织教学，注意语言规范及教师配合良好。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="teaching[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>4.	教案等资料用字规范，填写详细、书写评语等使用规范字。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="teaching[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>5.	活动质量高，教学环节紧凑，（学生无等待及“放羊式”现象）。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="teaching[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>6.	家长园地更换及时；环境创设好。（缺3次无分）</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="teaching[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>7.	班级月抽查有提高，内容质量高。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="teaching[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>8.	家长工作主动热情，（不负责任家长有意见不得分）。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="teaching[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td style="border-bottom: #0099FF thin solid;">9.  备课、教学等各类资料完成及时且质量高。</td>
                    <td style="text-align: center;border-bottom: #0099FF thin solid;">5</td>
                    <td class="score" style="text-indent: 5px;border-bottom: #0099FF thin solid;"><input type="text" name="teaching[]" size="1"></td>
                </tr>

                <tr align="center">
                    <td style="width: 60px;text-align: center;border-bottom: #0099FF thin solid;" rowspan="4">保育<br/>工作（20）</td>
                    <td style="text-align: left;">1.	出勤率高（大班90%、中班88%、小班83%）以上。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="conservation[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>2.	班内学生卫生习惯好。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="conservation[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>3.	班内卫生、消毒好。（一处重复3次无分）</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="conservation[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td style="border-bottom: #0099FF thin solid;">4.关注学生冷暖，照顾好学生饮食，及时提醒学生喝水。</td>
                    <td style="text-align: center;border-bottom: #0099FF thin solid;">5</td>
                    <td class="score" style="text-indent: 5px;border-bottom: #0099FF thin solid;"><input type="text" name="conservation[]" size="1"></td>
                </tr>

                <tr align="center">
                    <td style="width: 60px;text-align: center;border-bottom: #0099FF thin solid;" rowspan="4">教科<br/>研究（20）</td>
                    <td style="text-align: left;">1.	认真听课评课，记录详细、评价恰当。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="research[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>2.	按计划上好课，随堂课效果好，达良好课以上。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="research[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>3.	认真参加教科研、学科组活动，积极参与讨论，不无故缺席。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="research[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td style="border-bottom: #0099FF thin solid;">4.	每月随笔至少一篇，积极主动学习书籍。</td>
                    <td style="text-align: center;border-bottom: #0099FF thin solid;">5</td>
                    <td class="score" style="text-indent: 5px;border-bottom: #0099FF thin solid;"><input type="text" name="research[]" size="1"></td>
                </tr>

                <tr align="center">
                    <td style="width: 60px;text-align: center;border-bottom: #0099FF thin solid;" rowspan="3">考勤<br/>情况（20）</td>
                    <td style="text-align: left;">1.   全勤。一个月请假累计3天以上无分。（事假、病假）</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="attendance[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td>2.   会议。迟到1次1分，缺勤2次无分。</td>
                    <td style="text-align: center;">5</td>
                    <td class="score" style="text-indent: 5px;"><input type="text" name="attendance[]" size="1"></td>
                </tr>
                <tr align="center">
                    <td style="border-bottom: #0099FF thin solid;">3.   教科研。一次提醒，2次无分。</td>
                    <td style="text-align: center;border-bottom: #0099FF thin solid;">5</td>
                    <td class="score" style="text-indent: 5px;border-bottom: #0099FF thin solid;"><input type="text" name="attendance[]" size="1"></td>
                </tr>

                <tr height=100 align="center">
                    <td style="text-align: center;width: 60px;" >考核<br>结果</td>
                    <td colspan="2" style="text-indent: 5px;"><textarea name="value[content]"
                                                                        style="width: 500px; height: 100px;"></textarea></td>
                    <td width=60>
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt" id="total">
                            <tr height=50 align="center"><td><span>总分：100%</span></td></tr>
                            <tr height=50 align="center"><td ><span>优秀：<img  src="static/admin_img/smile.jpg"></span></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td colspan="3"><input  type="submit" id="submit" value=" 提 交 " class="btn"
                                            tabindex="3" />
                        &nbsp;&nbsp;&nbsp;
                        <input type="button"
                               name="canc" value=" 取消 " class="btn"
                               onclick="javascript:history.back();" /></td>
                </tr>
            </table>
        </form>
    </div>

<?php $this->load->view('admin/footer');?>