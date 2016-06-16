<?php $this->load->view('admin/header');?>
    <div class="mainbox nomargin">
            <table width="768" border="1" cellpadding="0" cellspacing="0" class="opt">
                <tr height=50 align="center">   <!--2-->
                    <td width=130>姓&nbsp;&nbsp;名：</td>
                    <td width=181><?php echo $this->teacher['truename']?></td>
                    <td width=130>评价学期：</td>
                    <td width=181><?php echo config_item('semester')[$value['semester']]?></td>
                    <td width=130>月份：</td>
                    <td width=181><?php echo config_item('MONTH1')[$value['MONTH']]?></td>
                </tr>
            </table>
            <table width="768" border="1" cellpadding="0" cellspacing="0" class="opt">
                <tr height=50 align="center">   <!--2-->
                    <td width=60>项目</td>
                    <td width=508 colspan="3">具体内容</td>
                    <td width=150>得    分</td>
                </tr>
                <tr height=100 align="center">
                    <td width=60 >师德<br>师风<br>（20）</td>
                    <td width=508 colspan="3">
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <tr height=25 align="left"><td>1.	遵章守纪，严守规范制度；上班准时；不无故外出。</td></tr>
                            <tr height=25 align="left"><td>2.	团结协作，乐于奉献；态度认真，责任心强。</td></tr>
                            <tr height=25 align="left"><td>3.	以身作则，为人师表；着装大方，便于活动。</td></tr>
                            <tr height=25 align="left"><td>4.	热爱幼儿，面向全体；师生关系融洽，一视同仁；无体罚与变相体罚（有此现象不得分）。</td></tr>
                        </table>
                    </td>
                    <td width=50 >
                        <table width="50" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <?php foreach($morality as $v):?>
                            <tr height=25 align="center"><td><?php echo $v?></td></tr>
                            <?php endforeach;?>
                        </table>
                    </td>

                </tr>
                <tr height=100 align="center">
                    <td width=60>常规<br>管理<br>（20）</td>
                    <td width=508 colspan="3">
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <tr height=25 align="left"><td>1.	班级整体常规好（优秀得6分、良好得4分、一般得2分）。</td></tr>
                            <tr height=25 align="left"><td>2.	幼儿安全无事故（有流血、缝针或幼儿走失等事件不得分）。</td></tr>
                            <tr height=25 align="left"><td>3.	门窗水电管理和物品保管好（不开无人灯、无人水，物品无损坏、丢失发现2次扣2）。</td></tr>
                            <tr height=25 align="left"><td> 4.	一日活动组织管理、安排到位。（有违纪者扣2分）</td></tr>
                        </table>
                    </td>
                    <td width=150>
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <?php foreach($management as $v):?>
                                <tr height=25 align="center"><td><?php echo $v?></td></tr>
                            <?php endforeach;?>
                        </table>
                    </td>
                </tr>
                <tr height=100 align="center">
                    <td width=60>教育<br>教学<br>（45）</td>
                    <td width=508 colspan="3">
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <tr height=25 align="left"><td>1.	认真制定和执行各类计划及总结，遵守作息时间，(不认真无分)。</td></tr>
                            <tr height=25 align="left"><td>2.	认真组织一日活动(户外活动2次)，不串岗离岗不玩手机。(发现1次无分)</td></tr>
                            <tr height=25 align="left"><td>3.	运用普通话组织教学，注意语言规范及教师配合良好。</td></tr>
                            <tr height=25 align="left"><td>4.	教案等资料用字规范，填写详细、书写评语等使用规范字。</td></tr>
                            <tr height=25 align="left"><td>5.	活动质量高，教学环节紧凑，（幼儿无等待及“放羊式”现象）。</td></tr>
                            <tr height=25 align="left"><td>6.	家长园地更换及时；环境创设好。（缺3次无分）</td></tr>
                            <tr height=25 align="left"><td>7.	班级月抽查有提高，内容质量高。</td></tr>
                            <tr height=25 align="left"><td>8.	家长工作主动热情，（不负责任家长有意见不得分）。</td></tr>
                            <tr height=25 align="left"><td>9.  备课、教学等各类资料完成及时且质量高。</td></tr>

                        </table>
                    </td>
                    <td width=150>
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <?php foreach($teaching as $v):?>
                                <tr height=25 align="center"><td><?php echo $v?></td></tr>
                            <?php endforeach;?>
                        </table>
                    </td></td>

                </tr>
                <tr height=100 align="center">
                    <td width=60>保育<br>工作<br>（20）</td>
                    <td width=508 colspan="3">
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <tr height=25 align="left"><td>1.	出勤率高（大班90%、中班88%、小班83%）以上。</td></tr>
                            <tr height=25 align="left"><td>2.	班内幼儿卫生习惯好。</td></tr>
                            <tr height=25 align="left"><td>3.	班内卫生、消毒好。（一处重复3次无分）</td></tr>
                            <tr height=25 align="left"><td>4.	关注幼儿冷暖，照顾好幼儿饮食，及时提醒幼儿喝水。</td></tr>
                        </table>
                    </td>
                    <td width=150>
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <?php foreach($conservation as $v):?>
                                <tr height=25 align="center"><td><?php echo $v?></td></tr>
                            <?php endforeach;?>
                        </table>
                    </td>
                </tr><tr height=100 align="center">
                    <td width=60>教科<br>研究<br>（20）</td>
                    <td width=508 colspan="3">
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <tr height=25 align="left"><td>1.	认真听课评课，记录详细、评价恰当。</td></tr>
                            <tr height=25 align="left"><td>2.	按计划上好课，随堂课效果好，达良好课以上。</td></tr>
                            <tr height=25 align="left"><td>3.	认真参加教科研、学科组活动，积极参与讨论，不无故缺席。</td></tr>
                            <tr height=25 align="left"><td>4.	每月随笔至少一篇，积极主动学习书籍。</td></tr>
                        </table>
                    </td>
                    <td width=150>
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <?php foreach($research as $v):?>
                                <tr height=25 align="center"><td><?php echo $v?></td></tr>
                            <?php endforeach;?>
                        </table>
                    </td>
                </tr>
                </tr><tr height=100 align="center">
                    <td width=60>考勤<br>情况<br>（15）</td>
                    <td width=508 colspan="3">
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <tr height=25 align="left"><td>1.   全勤。一个月请假累计3天以上无分。（事假、病假）</td></tr>
                            <tr height=25 align="left"><td>2.   会议。迟到1次1分，缺勤2次无分。</td></tr>
                            <tr height=25 align="left"><td>3.   教科研。一次提醒，2次无分。</td></tr>
                        </table>
                    </td>
                    <td width=150>
                        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="opt">
                            <?php foreach($attendance as $v):?>
                                <tr height=25 align="center"><td><?php echo $v?></td></tr>
                            <?php endforeach;?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th width=150>考核结果：</th>
                    <td colspan="4"><?php echo $value['content']?></td>
                </tr>

            </table>
    </div>

<?php $this->load->view('admin/footer');?>