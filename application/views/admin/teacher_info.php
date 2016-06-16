<?php $this->load->view('admin/header');?>
    <link href="static/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />



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
                1.用户信息
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
                            <span><img id=avtor  class='img-thumbnail' src=<?php echo $value['thumb']?>></span>

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

                        <th  >性 别</th>
                        <td  >
                            <input name="value[fax]" type="text" value="<?=config_item('gender')[$value['gender']]?>">

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

                            <input name="" type="text" value="<?=$value['manage_class']?>" />

                        </td>

                        <th  >任教班级</th>
                        <td  >

                            <input name="" type="text" value="<?=$value['teach_class']?>" />

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
                        <td colspan="4" style="text-align:center">
                            <input type="button" <?php if($prepage):?>  value="上一条" onclick="location.href='<?=$this->baseurl?>&m=info&id=<?=$prepage['id']?>'" <?php else:?> value="没有了"<?php endif;?> class="btn btn-success">

                            <button type="button" class="btn btn-danger" onclick="parent.$.fancybox.close();" data-dismiss="modal"><i class="fa fa-times"></i> 关闭</button>
                            <a href="javascript:void(0)" id="edit" class="btn btn-primary">编辑</a>

                            <input type="button"  <?php if($nextpage):?>  value="下一条" onclick="location.href='<?=$this->baseurl?>&m=info&id=<?=$nextpage['id']?>'" <?php else:?> value="没有了"<?php endif;?> class="btn btn-success">
                        </td>
                    </tr>
                </table>
            </div>
        </div>


<script type="application/javascript">
    $(document).ready(function(){
        $("#edit").bind('click',function(){
             parent.$.fancybox.close();
             parent.location.href='<?=$this->baseurl?>&m=edit&id=<?=$id?>';
        });


    });
</script>




