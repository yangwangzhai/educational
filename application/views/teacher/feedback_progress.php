<?php $this->load->view('admin/header');?>
    <style type="text/css">

        /* 退款详情相关
        -------------------------------------------*/
        .ncm-flow-layout,
        .ncm-flow-item dl { font-size: 0; *word-spacing:-1px/*IE6、7*/; }
        .ncm-flow-container,
        .ncm-flow-item,
        .ncm-flow-item dt,
        .ncm-flow-item dd { font-size: 12px; vertical-align: top; letter-spacing: normal; word-spacing: normal; display: inline-block; *display: inline/*IE7*/; *zoom: 1/*IE7*/;}
        .ncm-flow-layout { width: 978px; border: solid 1px #DDD; margin-left: 10px;}
        /*.ncm-flow-container { width: 657px; padding: 0 10px; border-right: solid 1px #DDD;}*/

        /* 流程步骤 */
        .ncm-flow-step { font-size: 0; *word-spacing:-1pxIE6、7; margin-top: 30px;}
        .ncm-flow-step dl { font-size: 12px; line-height: 20px; background: url(static/admin_img/member_pics.png) no-repeat; vertical-align: top; letter-spacing: normal; word-spacing: normal; display: inline-block; *display: inlineIE7; height: 36px; margin: 50px 0 60px -1px; position: relative; z-index: -1; *zoom: 1IE7;}
        .ncm-flow-step dl.step-first { background-position: -240px -170px !important; width: 36px !important;}
        .ncm-flow-step dl dt { font-weight: 600; color: #999; text-align: center; width: 120px; position: absolute; z-index: 1; top: -30px; right: -42px;}
        .ncm-flow-step dl.current dt { color: #FD6760;}
        .ncm-flow-step dl dd.bg { background: url(static/admin_img/member_pics.png) no-repeat; display: none; height: 36px; position: absolute; z-index: 1; top: 0; right: 0;}
        .ncm-flow-step dl.step-first dd.bg { background-position: -240px -210px !important; width: 36px !important;}
        .ncm-flow-step dl.current dd { display: block;}

        /* 投诉 */
        #ncmComplainFlow .ncm-flow-step dl { background-position: -360px -130px; width: 140px;}
        #ncmComplainFlow .ncm-flow-step dl.step-first { margin-left: 40px;}
        #ncmComplainFlow .ncm-flow-step dl dd.bg {  background-position: -355px -250px; width: 145px;}



        /* 账户信息设置
       -------------------------------------------*/

    </style>


    <div class="ncm-flow-layout" id="ncmComplainFlow">
        <div class="ncm-flow-container">
            <!--<div class="title">
                <h3>家长反馈处理</h3>
            </div>-->
            <div class="ncm-flow-step">
                <dl id="state_new" class="step-first current">
                    <dt>新反馈</dt>
                    <dd class="bg"></dd>
                </dl>
                <dl id="state_appeal" class="current">
                    <dt>待核实</dt>
                    <dd class="bg"> </dd>
                </dl>
                <dl id="state_talk" <?php if($value['feedback_active']>2):?> class="current"<?php endif;?>>
                    <dt>待整改</dt>
                    <dd class="bg"> </dd>
                </dl>
                <dl id="state_handle" <?php if($value['feedback_active']>3):?> class="current"<?php endif;?>>
                    <dt>待审核</dt>
                    <dd class="bg"> </dd>
                </dl>
                <dl <?php if($value['feedback_active']>4):?> class="current"<?php endif;?>>
                    <dt>待审阅</dt>
                    <dd class="bg"> </dd>
                </dl>
                <dl id="state_finish" <?php if($value['feedback_active']>5):?> class="current"<?php endif;?>>
                    <dt>已完成</dt>
                    <dd class="bg"> </dd>
                </dl>
            </div>

        </div>

    </div>

<?php $this->load->view('admin/footer');?>