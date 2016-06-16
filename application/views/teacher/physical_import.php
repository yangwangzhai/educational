<?php $this->load->view('admin/header');?>
    <script type="text/javascript" src="static/plugin/uploadify/jquery.uploadify-3.1.js"></script>
    <link rel="stylesheet" type="text/css" href="static/plugin/uploadify/uploadify.css"/>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#submit").bind("click",function(){
                var myFilePath=$("input[name='myFilePath']");
                if(myFilePath.length==0)
                {
                    return false;
                }
                else
                {
                    var filename=[];
                    var i=0;
                    myFilePath.each(function(){
                        filename[i]=$(this).val();
                        i++;
                    });
                }
                $.ajax({
                    url: "<?=$this->baseurl?>&m=excelIn",   //后台处理程序
                    type: "post",         //数据发送方式
                    /*dataType:"json", */   //接受数据格式
                    data:{filename:filename},  //要传递的数据
                    success:function(data){
                        if(data==1)
                        {
                            alert('导入完成！')
                            //parent.dialog.remove();
                            parent.location.href='<?php echo $_SESSION ['url_forward']?>';
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        alert(errorThrown);
                    }
                });

            });

            $('#fileInput2').uploadify({
                height        : 24,
                width         : 80,
                'formData'         : {'upload' : 'upload'},
                'auto'     : false,//关闭自动上传
                'multi': true,//是否多文件上传
                //'checkScript': 'js/check.php',//验证 ，服务端的
                'displayData': 'speed',//进度条的显示方式
                'removeTimeout' : 1,//文件队列上传完成1秒后删除
                'swf'      : 'static/plugin/uploadify/uploadify.swf',
                'uploader' : 'index.php?d=admin&c=file_upload&m=xls_upload',//index.php?d=admin&c=student&m=upload
                'method'   : 'post',//方法，服务端可以用$_POST数组获取数据
                'buttonText' : '选择表格',//设置按钮文本
                'uploadLimit' : 10,//一次最多只允许上传10张图片
                'fileTypeDesc' : 'Image Files',//只允许上传图像
                'fileTypeExts' : '*.xls;',//限制允许上传的图片后缀
                'fileSizeLimit' : '2048',//限制上传的图片不得超过200KB
                'onUploadSuccess' : function(file, data, response) {//每次成功上传后执行的回调函数，从服务端返回数据到前端
                    var data =$.parseJSON(data);
                    if(data.file_name!='')
                    {
                        getResult(file.name);//获得上传的文件路径
                        setResult(data.url);
                    }
                    else
                    {
                        alert(data);
                    }
                },
                'onQueueComplete' : function(queueData) {//上传队列全部完成后执行的回调函数
                }
                // Put your options here
            });
        });
        function getResult(content){
            //通过上传的图片来动态生成text来保存路径
            var board = document.getElementById("divTxt");
            board.style.display="";
            var newInput = document.createElement("input");
            newInput.type = "text";
            newInput.size = "45";
            /*newInput.name="myFilePath[]";*/
            var obj = board.appendChild(newInput);
            var br= document.createElement("br");
            board.appendChild(br);
            obj.value=content;
        }
        function setResult(content){
            //通过上传的图片来动态生成text来保存路径
            var board = document.getElementById("divTxt");
            var newInput = document.createElement("input");
            newInput.type = "hidden";
            newInput.name="myFilePath";
            var obj = board.appendChild(newInput);
            obj.value=content;
        }
    </script>

    <fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0">
        <legend> <strong> 学生体征导入</strong></legend>
        <div><input id="fileInput2" name="fileInput2" type="file" />
            <input type="button" class="btn" value="确定上传" onclick="javascript:$('#fileInput2').uploadify('upload','*')">&nbsp;&nbsp;
            ||&nbsp;&nbsp;<a class="btn" href="javascript:$('#fileInput2').uploadify('cancel','*')">清除上传列表</a></div>
        <p></p>
    </fieldset>
    <div id="divTxt" style="display:none"><span style="color:red"><strong>已经上传的文件有：</strong></span><br></div><br>
    <div id="divTxt" style="display:none"><span style="color:red"><strong>已经上传的文件有：</strong></span><br></div>
    <INPUT TYPE="submit" id="submit" class="btn" value="提  交">
<?php $this->load->view('admin/footer');?>