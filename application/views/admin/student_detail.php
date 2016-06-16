<!DOCTYPE html>
<html  lang="zh-cn">
<head id="ctl00_Head1">
    <title>学生详情</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body>

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
            <a href="javascript:history.back();" style="display:" class="btn btn-success">返回</a>
        <br><br>
        <div class="panel panel-default">
            <div class="panel-heading">
                1.基本信息
            </div>

            <div class="panel-body">

                <table class="table table-condensed  stafftable"   >

                    <tr>

                        <th width="20%" >学生姓名</th>
                        <td  width="30%">
                            <input name="" type="text" value="<?php echo $value['name']?>"  />

                        </td>


                        <th rowspan="2" width="20%">学生照片</th>
                        <td rowspan="2" width="30%" >
                            <span><a target=_blank href=<?php echo $value['thumb']?>><img id=avtor  class='img-thumbnail' src=<?php echo $value['thumb']?>></a></span>

                        </td>
                    </tr>


                    <tr>

                        <th >性 别</th>
                        <td >
                            <input type="text" value="<?php echo config_item('gender')[$value['gender']]?>" />

                        </td>

                    </tr>

                    <tr>
                        <th >出生年月 </th>
                        <td>
                            <input  type="text" value="<?php echo $value['birthday']?>" />
                        </td>
                        <th>年 龄</th>
                        <td>
                            <input  type="text" value="<?php echo (date('Y-m-d',time())-$value['birthday'])?>" />
                        </td>


                    </tr>

                    <tr>
                        <th>民 族</th>
                        <td  >
                            <input name="" type="text" value="<?php echo $value['nation']?>" />
                        </td>

                        <th>籍贯</th>
                        <td >
                            <input name="" type="text" value="<?php echo $value['place']?>"  />
                        </td>

                    </tr>
                    <tr>
                        <th >家庭住址</th>
                        <td>
                            <input name="" type="text" value="<?=$value['address']?>" />

                        </td>

                        <th  >住宅电话</th>
                        <td  >
                            <input name="" type="text" value="<?=$value['tel']?>" />
                        </td>

                    </tr>
                    <?php foreach($parents as $item):?>
                        <tr>
                            <th><?php echo config_item('relatives')[$item['relatives']]?></th>
                            <td><input type="text" value="<?php echo $item['username']?>"></td>
                            <th>电 话</th>
                            <td><input type="text" value="<?php echo $item['tel']?>"></td>
                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <th>入校日期</th>
                        <td>
                            <input name="value[pubdate]" type="text" value="<?=$value['pubdate']?>">
                        </td>
                        <th>有无疾病史</th>
                        <td>
                            <input name="value[email]" type="text" value="<?=$value['allergic']?>">
                        </td>
                    </tr>
                    <tr>
                        <th  >第几届</th>
                        <td  >
                            <input  type="text" value="<?php echo config_item('grade')[$classinfo['grade']]?>" />

                        </td>
                        <th>班级名称</th>
                        <td>
                            <input name="value[fax]" type="text" value="<?php echo $classinfo['classname'].'('.$classinfo['nickname'].')'?>">
                        </td>

                    </tr>

                    <tr>

                        <th  >班主任</th>
                        <td  >
                            <table id="" border="0" style="border-width:0px;width:150px;">
                                <tr>
                                    <input  type="text" value="<?php foreach($manage_teacher as $val):?><?php echo $val?>&nbsp;&nbsp;<?php endforeach;?>" />
                                </tr>
                            </table>

                        </td>

                        <th  >带班老师</th>
                        <td  >
                            <table id="" border="0" style="border-width:0px;width:150px;">
                                <tr>
                                    <input  type="text" value="<?php foreach($teach_teacher as $val):?><?php echo $val?>&nbsp;&nbsp;<?php endforeach;?>" />
                                </tr>
                            </table>

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

        <div class="panel panel-default">
            <div class="panel-body text-center">

                <input type="button" name="" value="编辑" onclick="location.href='<?=$this->baseurl?>&m=edit&id=<?=$id?>'" class="btn btn-primary">
                <input type="submit" name="" value="返回" onclick="javascript:history.back();" class="btn btn-danger">
            </div>
        </div>
</body>
</html>
