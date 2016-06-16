<!DOCTYPE html>
<html  lang="zh-cn">
<head id="ctl00_Head1">
    <title><?=PRODUCT_NAME?>-教师端</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="static/admin_img/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form name="aspnetForm" method="post" action="" id="aspnetForm">


    <div class="container-fluid">

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
                font-weight:normal;

            }

            .stafftable input {
                border:0px;
                border-bottom:solid 1px #808080;
                font-weight:bold;
                padding-bottom:2px;
                margin:4px;

            }
        </style>
            <div class="panel panel-default">
                <div class="panel-heading">
                    1.基本信息
                </div>

                <div class="panel-body">

                    <table class="table table-condensed  stafftable"   >

                        <tr>

                            <th width="20%" >中文姓名</th>
                            <td  width="30%">
                                <input name="" type="text" value="<?php echo $value['truename']?>"  />

                            </td>


                            <th rowspan="2" width="20%">员工照片</th>
                            <td rowspan="2" width="30%" >
                                <span><a target=_blank href=<?php echo $value['thumb']?>><img id=avtor  class='img-thumbnail' src=<?php echo $value['thumb']?>></a></span>

                            </td>
                        </tr>


                        <tr>

                            <th  >教师昵称</th>
                            <td >
                                <input  type="text" value="<?php echo $value['nickname']?>" id="staffcode" />

                            </td>

                        </tr>

                        <tr>
                            <th >系统登录名 </th>
                            <td  >
                                <input  type="text" value="<?php echo $value['username']?>" id="username" />
                            </td>
                            <th>
                            </th>
                            <td>
                                &nbsp;

                            </td>
                            <td>

                            </td>

                        </tr>

                        <tr>
                            <th>员工部门</th>
                            <td  >
                                <input name="" type="text" value="<?php echo config_item('dept')[$value['dept']]?>" />
                            </td>

                            <th>任教科目</th>
                            <td >
                                <input name="" type="text" value="<?php echo $value['course']?>"  />
                            </td>

                        </tr>
                        <tr>
                            <th  >管理班级</th>
                            <td  >

                                <input name="" type="text" value="<?=setClassname($value['manage_class'])?>" />

                            </td>

                            <th  >任教班级</th>
                            <td  >

                                <input name="" type="text" value="<?=setClassname($value['teach_class'])?>" />

                            </td>

                        </tr>
                        <tr>
                            <th>办公地点</th>
                            <td>
                                <input name="value[Office]" type="text" value="<?=$value['Office']?>">
                            </td>
                            <th>邮 件</th>
                            <td>
                                <input name="value[email]" type="text" value="<?=$value['email']?>">
                            </td>
                        </tr>
                        <tr>
                            <th  >办公电话</th>
                            <td  >
                                <input  type="text" value="<?=$value['tel']?>" />

                            </td>
                            <th>传 真</th>
                            <td>
                                <input name="value[fax]" type="text" value="<?=$value['fax']?>">
                            </td>

                        </tr>

                        <tr>

                            <th  >性 别</th>
                            <td  >
                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tr>
                                        <?php foreach(config_item('gender') as $key=>$val):?>
                                            <td><input id="a<?php echo $key?>" type="radio" name="value[gender]" value="<?php echo $key?>" <?php if($value['gender']==$key) echo 'checked'?>><label for="a<?php echo $key?>"><?php echo $val?></label></td>
                                        <?php endforeach;?>
                                    </tr>
                                </table>

                            </td>

                            <th  >用户状态 </th>
                            <td>

                                <table border="0" style="border-width:0px;width:200px;">
                                    <tbody><tr>
                                        <?php foreach(config_item('status') as $key=>$val):?>
                                            <td><input id="b<?php echo $key?>" type="radio" name="value[status]" value="<?php echo $key?>" <?php if($value['status']==$key) echo 'checked'?>><label for="b<?php echo $key?>"><?php echo $val?></label></td>
                                        <?php endforeach;?>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>

                        </tr>
                    </table>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    2.档案信息
                </div>

                <div class="panel-body">


                    <table class="table table-condensed  stafftable"   >


                        <tr>
                            <th     width="20%">员工状态</th>
                            <td   width="30%">

                                <table id="" border="0" style="border-width:0px;width:320px;">
                                    <tbody><tr>
                                        <?php foreach(config_item('staffstatus') as $k=>$v):?>
                                            <td><input id="c<?=$k?>" type="radio" name=value[staffstatus]"  value="<?php echo $k?>" <?PHP if($value['staffstatus']==$k) echo "checked"?>><label for="c<?=$k?>"><?=$v?></label></td>
                                        <?php endforeach;?>
                                    </tr>
                                    </tbody></table>

                            </td>


                            <th   width="20%">上级领导</th>
                            <td   width="30%">

                                <input name="" type="text" value="<?php echo $value['supermgr']?>">
                            </td>

                        </tr>
                        <tr>

                            <th >国籍</th>
                            <td>

                                <input name="" type="text"   value="<?php echo $value['country']?>">
                            </td>
                            <th  >民族</th>
                            <td>
                            <input name="" type="text"   value="<?php echo $value['nation']?>">
                            </td>

                        </tr>
                        <tr>
                            <th  >出生年月</th>
                            <td class="td_right"  >
                                <input name="" type="text" id="birthday"  value="<?php echo $value['birthday']?>">
                            </td>


                            <th  >私人手机</th>
                            <td  >
                                <input name="" type="text" value="<?=$value['privatemobile']?>" >

                            </td>

                        </tr>

                        <tr>
                            <th   >职 务</th>
                            <td  >
                                <input name="" type="text" value="<?=$value['stafftitle']?>">
                            </td>

                            <th  >学 历</th>
                            <td >
                                <input  type="text" value="<?php echo config_item('degrees')[$value['degrees']]?>" />

                            </td>
                        </tr>
                        <tr>
                            <th >专业</th>
                            <td  >
                                <input type="text" value="<?=$value['majorin']?>"  />
                            </td>


                            <th>毕业院校</th>
                            <td  >
                                <input  type="text" value="<?=$value['graduate']?>" />
                            </td>
                        </tr>

                        <tr>
                            <th>身高</th>
                            <td>
                                <input type="text" name="value[height]" value="<?php echo $value['height']?>"/>
                            </td>

                            <th>婚姻</th>
                            <td>
                                <table id="" border="0" style="border-width:0px;width:150px;">
                                    <tbody><tr>
                                        <?php foreach(config_item('marry') as $k=>$v):?>
                                            <td><input id="d<?=$k?>" type="radio" name=value[marry]"  value="<?php echo $k?>" <?PHP if($value['marry']==$k) echo "checked"?>><label for="d<?=$k?>"><?=$v?></label></td>
                                        <?php endforeach;?>
                                    </tr>
                                    </tbody></table>

                            </td>
                        </tr>


                        <tr>
                            <th  >入职日期</th>
                            <td >
                                <input type="text" name="value[joinin]"
                                       id="joinin"   value="<?php echo $value['joinin']?>" >
                            </td>

                            <th  >合同到期</th>
                            <td >
                                <input type="text" name="value[expireto]" id="expireto"
                                       value="<?php echo $value['expireto']?>" >

                            </td>

                        </tr>

                        <tr>
                            <th  >证件类型</th>
                            <td  >
                                <input  type="text" value="<?=config_item('idcardtype')[$value['idcardtype']]?>"  />

                            </td>


                            <th  >证件号</th>
                            <td >

                                <input type="text" name="value[idcard]" value="<?php echo $value['idcard']?>" />                            </td>

                        </tr>
                        <tr>
                            <th>个性签名</th>
                            <td  colspan="3" class="form-inline">
                                <input  type="text" value="<?=$value['sign']?>"  />
                            </td>

                        </tr>
                        <tr>
                            <th  >现地址</th>
                            <td colspan=3  class="form-inline">


                                <input  type="text" value="<?=$value['address']?>" />
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    3.账户相关信息
                </div>
                <div id="collapseThree" class="panel-collapse collapse in">
                    <div class="panel-body">



                        <table class="table table-condensed  stafftable"   >

                            <tr>


                                <th   width="20%">社保种类</th>
                                <td  width="30%">


                                    <table id="" border="0" style="border-width:0px;width:250px;">
                                        <tr>
                                            <?php foreach(config_item('shebaotype') as $k=>$v):?>
                                            <td><input id="e<?=$k?>" type="radio"  <?PHP if($value['shebaotype']==$k)echo "checked"?> /><label for="e<?=$k?>"><?=$v?></label></td>
                                            <?php endforeach;?>
                                        </tr>
                                    </table>


                                </td>
                                <th   width="20%">社保号</th>
                                <td   width="30%">
                                    <input name="" type="text" value="<?=$value['shebaono']?>"  />
                                </td>

                            </tr>
                            <tr>
                                <th  >医保号</th>
                                <td  >
                                    <input name="" type="text" value="<?=$value['yibaono']?>"  />
                                </td>


                                <th  >公积金号</th>
                                <td >
                                    <input name="" type="text" value="<?=$value['gjjno']?>"  />
                                </td>
                            </tr>

                            <tr>
                                <th  >工资开户行</th>
                                <td>

                                    <input name="" type="text" value="<?=$value['bankname']?>"  />

                                </td>


                                <th  >工资卡号</th>
                                <td  >

                                    <input name="" type="text" value="<?=$value['bankcardno']?>" id="ctl00_ContentPlaceHolder1_bankcardno" />
                                </td>

                            </tr>
                            <tr>
                                <th  >政治面貌</th>
                                <td  >

                                    <input name="" type="text" value="<?php echo config_item('politics')[$value['politics']]?>" id="ctl00_ContentPlaceHolder1_ddl_politics" />
                                </td>


                                <th  >QQ</th>
                                <td  >

                                    <input name="" type="text" value="<?=$value['QQ']?>"  />
                                </td>
                            </tr>
                            <tr>
                                <th  >私人邮件</th>
                                <td  >

                                    <input name="" type="text" value="<?=$value['privateemail']?>"  />
                                </td>


                                <th   >微信</th>
                                <td  >
                                    <input name="" type="text"  value="<?=$value['weixin']?>" />

                                </td>
                            </tr>
                            <tr>
                                <th  >紧急联系人</th>
                                <td  >

                                    <input name="" type="text" value="<?=$value['urgentcontactpeople']?>" />
                                </td>


                                <th   >紧急联系电话</th>
                                <td  >
                                    <input name="" type="text" value="<?=$value['urgentcontacttel']?>"  />

                                </td>
                            </tr>

                            <tr>
                                <th  >备注</th>
                                <td   colspan=3>
          <textarea name="" rows="2" cols="20" id="" style="height:80px;width:600px;"><?=$value['content']?>
</textarea>
                                </td>

                            </tr>


                        </table>


                    </div>
                </div>
            </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                4.培训/教育/职业技能
            </div>
            <div id="collapseFour" class="panel-collapse collapse in">
                <div class="panel-body">
                    <table class="table table-condensed  stafftable"   >
                        <tr>
                            <th width="20%">教育/培训经历</th>
                            <td width="80%">
                                <div style="min-height:50px; margin-left:20px">
                                    <span><?php echo nl2br($history['edu'])?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%">工作/项目经验</th>
                            <td width="80%">
                                <div style="min-height:50px; margin-left:20px">
                                    <span><?php echo nl2br($history['works'])?></span>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th width="20%">职业技能</th>
                            <td width="80%">
                                <div style="min-height:50px; margin-left:20px">
                                    <span><?php echo nl2br($history['spec'])?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%">语言能力</th>
                            <td width="80%">
                                <div style="min-height:50px; margin-left:20px">
                                    <span><?php echo nl2br($history['lang'])?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%">IT技能</th>
                            <td width="80%">
                                <div style="min-height:50px; margin-left:20px">
                                    <span><?php echo nl2br($history['it'])?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%">奖惩记录 </th>
                            <td width="80%">
                                <div style="min-height:50px; margin-left:20px">
                                    <span><?php echo nl2br($history['jc'])?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%">自我/主管评价  </th>
                            <td width="80%">
                                <div style="min-height:50px; margin-left:20px">
                                    <span><?php echo nl2br($history['selfcomm'])?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th width="20%">校内培训  </th>
                            <td width="80%">
                                <div style="min-height:50px; margin-left:20px">
                                    <span><?php foreach($train as $k=>$val):?><?=$k+1?>.&nbsp;<?=$val['begintime']?>&nbsp;<?=$val['title']?><br><?php endforeach;?></span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <input type="button" name="" value="编辑" onclick="location.href='<?=$this->baseurl?>&m=edit'" class="btn btn-primary">
                    <input type="submit" name="" value="返回" onclick="javascript:history.back();" class="btn btn-danger">
                </div>
            </div>

</body>
</html>
