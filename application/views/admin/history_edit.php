<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?=PRODUCT_NAME?>-园长端</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />


</head>
<body>




    <div class="container-fluid">

        <div style=" margin:20px; font-size:13px;">

            <table>
                <tbody><tr>
                    <td valign="top">
                        <div style="margin:10px">
                            <form method="post" action="<?=$this->baseurl?>&m=history" >
                            <label>中文名或者昵称</label> <input name="keywords" type="text" id="" class="form-control" style="width:380px; display:inline-block">
                            <input type="submit" name="submit" value="查询" class="btn  btn-info  ">
                            </form>

                        </div>

                        <div>
                            <table class="table" cellspacing="0" border="0" style="width:600px;border-collapse:collapse;">
                                <tbody><tr>
                                    <th scope="col">id</th><th scope="col">中文名</th><th scope="col">昵称</th><th scope="col">用户名</th><th scope="col">部门</th><th scope="col">性别</th><th scope="col">&nbsp;</th>
                                </tr>
                                <?php foreach($list as $key=>$r) {?>
                                <tr <?php if($r['id']==$teacherid) echo 'style="color:Black;background-color:#F8D608;"'?>>
                                    <td><?=$r['id']?></td><td><?=$r['truename']?></td><td><?=$r['nickname']?></td><td><?=$r['username']?></td><td><?=config_item('dept')[$r['dept']]?></td><td><?=config_item('gender')[$r['gender']]?></td><td>
                                        <input type="button" onclick="location.href='<?=$this->baseurl?>&m=history&teacherid=<?=$r['id']?>'" name="" value="查看" class="btn btn-sm btn-flat btn-primary">

                                    </td>
                                </tr>
                                <?php }?>
                                </tbody></table>
                        </div>


                    </td>
                    <?php if($teacherid!=0):?>
                    <td valign="top">
                        <form action="<?=$this->baseurl?>&m=history_save" method="post">
                            <input type="hidden" name="id" value="<?php echo $id?>"/>
                        <div style="background-color:#f2f2f2;  width:600px; height:700px;  padding:20px; ">

                                    <h3>教育/培训/工作/经验/技能等明细
                                        <input type="submit" value="保存修改"  class="btn btn-success">
                                    </h3>


                                    <b> 教育/培训经历  </b>


                                    <textarea rows="2" cols="20" name="value[edu]" class="form-control" style="height:100px;"><?php echo strip_tags($value['edu'])?></textarea>



                                    <br><br>

                                    <b> 工作/项目经验  </b>


                                    <textarea rows="2" cols="20" name="value[works]" class="form-control" style="height:100px;"><?php echo strip_tags($value['works'])?></textarea>



                                    <br><br>

                                    <b> 职业技能  </b>


                                    <textarea rows="2" cols="20" name="value[spec]" class="form-control" style="height:100px;"><?php echo strip_tags($value['spec'])?></textarea>


                                    <br><br>

                                    <b> 语言能力  </b>


                                    <textarea rows="2" cols="20" name="value[lang]" class="form-control" style="height:100px;"><?php echo strip_tags($value['lang'])?></textarea>


                                    <br><br>

                                    <b> IT技能  </b>

                                    <textarea rows="2" cols="20" name="value[it]" class="form-control" style="height:100px;"><?php echo strip_tags($value['it'])?></textarea>

                                    <br><br>

                                    <b> 奖惩记录  </b>


                                    <textarea  rows="2" cols="20" name="value[jc]" class="form-control" style="height:100px;"><?php echo strip_tags($value['jc'])?></textarea>



                                    <br><br>

                                    <b> 自我/主管评价  </b>


                                    <textarea rows="2" cols="20" name="value[selfcomm]" class="form-control" style="height:100px;"><?php echo strip_tags($value['selfcomm'])?></textarea>
                                    <br><br>
                                    <b> 校内培训 </b>
                                    <br>
                                    <!--<textarea rows="2" readonly cols="20" class="form-control" style="height:100px;align-content: center"></textarea>-->
                            <?php foreach($train as $k=>$val):?><?=$k+1?>.&nbsp;<?=$val['begintime']?>&nbsp;<?=$val['title']?><br><?php endforeach;?>
                        </div>
                            </form>
                    </td>
                    <?php endif;?>
                </tr>
                </tbody></table>

        </div>
    </div>

</body></html>