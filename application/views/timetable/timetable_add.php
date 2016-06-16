<?php $this->load->view('admin/header');?>

<script>
$(document).ready(function() {

    // 弹出选择课程
    $("#chooseclass").click(function(){
        var grade = $(this).attr("data-grade");
        var classname = $(this).attr("data-classname");
        //alert(classname);
        var chooseclass = encodeURIComponent($("#chooseclass").val());
        chooseclassdialog = dialog_url('index.php?d=admin&c=timetable&m=chooseclass_dialog&grade='+grade+'&classname='+classname,'选择课程：',400,200);
    });

	// 弹出选择老师
	$("#teachername").click(function(){		
		//var classname = encodeURIComponent($("#classname").val());
        var course=$("#chooseclass").val(); //获取id为chooseclass的value值
        var grade = $("#chooseclass").attr("data-grade");
        var classname=$("#chooseclass").attr("data-classname"); //获取id为chooseclass，属性为data-classname的值
		teacherdialog = dialog_url('index.php?d=admin&c=timetable&m=dialog&grade='+grade+'&classname='+classname+'&course='+course,'选择老师：',400,200);
	});
	 
});
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>

    <script>
        function insert_td(){
            var grade=$("#grade_id").val();
            var coursename= $("#chooseclass").val();
            var classname=$("#chooseclass").attr("data-classname");
            var week = $("#gradeid").attr("week");
            var section = $("#grade").attr("section");
            parent.document.getElementById(grade+classname+section+week).innerHTML=coursename;
            return true;
        }
    </script>

    <script>
        function delete_td(){
            //var coursename= $("#chooseclass").val();
            var grade=$("#grade_id").val();
            var classname=$("#chooseclass").attr("data-classname");
            var week = $("#gradeid").attr("week");
            var section = $("#grade").attr("section");
            parent.document.getElementById(grade+classname+section+week).innerHTML='';
            //parent.location.href='<?=$this->baseurl?>&m=delete_timetable&classname='+classname+'&week='+week+'&section='+section;
            $.post("index.php?d=admin&c=timetable&m=delete_timetable", {grade:grade,classname:classname,week:week,section:section},function(data){
                if(data==1)
                {
                    $('#chooseclass').val('');
                    $('#teachername').val('');
                    $('#my_hidden_id').val('');
                    $('.warning').html('');
                }
                else
                {
                    alert('删除失败');
                }
            });
        }

    </script>

<div class="mainbox nomargin">
	<form action="<?=$this->baseurl?>&m=save" method="post"  >
		<input type="hidden" name="id" id="my_hidden_id" value="<?=$id?>">
		<input type="hidden" name="value[classname]" value="<?=$value['classname']?>" />
		<input type="hidden" name="value[grade]" id="grade_id" value="<?=$value['grade']?>" />
		<table border="0" cellpadding="0" cellspacing="0" class="opt">
            <tr style="display:none">
                <th>课程安排</th>
                <td><select name="value[week]" id="gradeid" week="<?=$value['week']?>">
                        <?=getSelect(config_item('week'),$value['week'],'key')?>
                    </select><select name="value[section]" id="grade" section="<?=$value['section']?>">
                        <?=getSelect(config_item('section'),$value['section'],'key')?>
                    </select></td>
            </tr>
            <tr>
				<th width="90">课程名称</th>
				<td><input type="text" class="txt" name="value[title]" id="chooseclass" data-grade="<?=$value['grade']?>" data-classname="<?=$value['classname']?>"
					value="<?=$value['title']?>" /></td>
                <td id="course_num" style="font-weight: bolder;font-size: medium; color: #0000cc"></td>
			</tr>				
			<tr>
				<th width="90">上课老师</th>
				<td>
                    <input type="text" class="txt" name="value[teacher_truename]" id="teachername" value="<?=$value['teacher_truename']?>" />
                </td>
			</tr>
			<tr>
				<th width="90">注意事项</th>
				<td><input type="text" class="txt" name="value[tips]"
					value="<?=$value['tips']?>" /></td>
			</tr>
			<tr>
				<th>课程内容</th>
				<td><textarea id="content11" name="value[content]"
						style="width: 250px; height: 60px;"><?=$value['content']?></textarea></td>
			</tr>			
			<tr>
				<th>&nbsp;</th>
				<td>
                    <input type="submit" name="submit" value=" 提 交 " onclick="insert_td()" onsubmit="return insert_td()" class="btn" tabindex="3" /> &nbsp;&nbsp;&nbsp;
                    <input type="button" name="submit" value=" 取消 " class="btn" onclick="javascript:history.back();"/>&nbsp;&nbsp;&nbsp;
               <a href="javascript:;" onclick="delete_td()">删除</a>
                <!-- <a href="<?=$this->baseurl?>&m=delete_timetable&id=<?=$id?>&classname=<?=$value[classname]?>&section=<?=$value[section]?>&week=<?=$value[week]?>">删除</a>-->
                </td>
			</tr>
		</table>
	</form>

    <!-- 以下是显示提示信息-->
    <style>
        .warning {color: #CC0000;font-size: medium;}
    </style>
    <?php /*if(!empty($warning)){*/?><!--
        <table>
            <?php /*foreach($warning as $k=>$v){ */?>
                <?php /*foreach($v as $kk=>$vv){ */?>
                    <tr >
                        <td class="warning"><?/*= $vv['warning_mession'];*/?></td>
                    </tr>
                <?php /*}*/?>
            <?php /*}*/?>
        </table>
    --><?php /*} */?>
</div>

<?php $this->load->view('admin/footer');?>