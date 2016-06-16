<?php $this->load->view('admin/header');?>
    <script>
        $(document).ready(function(){
            $("a").click(function(){
                var grade=parent.document.getElementById('chooseclass').attributes["data-grade"].value;
                var classname=parent.document.getElementById('chooseclass').attributes["data-classname"].value;
                var course=parent.document.getElementById('chooseclass').value = $(this).text();
                $.ajax({
                    url: "index.php?d=admin&c=timetable&m=get_have_course",   //后台处理程序
                    type: "post",         //数据发送方式
                    dataType:"json",    //接受数据格式
                    //async: false,       //设置ajax为同步（默认为异步）
                    data:{grade:grade,classname:classname,course:course},  //要传递的数据
                    success:function(mess){
                        parent.document.getElementById('course_num').innerHTML="已排"+mess+"节";
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        alert(errorThrown);
                    }
                });
                //parent.chooseclassdialog.remove();

            });
        });
    </script>

    <ul class="citys">
        <li>
            <?php foreach($list as $value):?>
                <a href="javascript:;" ><?= $value['course']?></a>
            <?php endforeach;?>
        </li>
    </ul>

<?php $this->load->view('admin/footer');?>