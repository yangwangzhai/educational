<?php $this->load->view('admin/header');?>

    <script>
        var ue = UE.getEditor('editor');
        $(document).ready(function(){

        });
        KindEditor.ready(function(K) {
            var uploadbutton = K.uploadbutton({
                button : K('#btn_thumb')[0],
                fieldName : 'imgFile',
                url : './static/js/kindeditor410/php/upload_json.php?dir=file&folder=news',
                afterUpload : function(data) {
                    if (data.error === 0) {
                        var url = K.formatUrl(data.url, 'relative');
                        K('#thumb').val(url);
                    } else {
                        alert(data.message);
                    }
                },
                afterError : function(str) {
                    alert('自定义错误信息: ' + str);
                }
            });
            uploadbutton.fileBox.change(function(e) {
                uploadbutton.submit();
            });
        });
    </script>
    <div class="mainbox nomargin">
        <form id="form" action="<?=$this->baseurl?>&m=save" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="value[content]" id="content" value='<?=$value['content']?>'>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="opt">

                <tr>
                    <th width="90">学校名称 *</th>
                    <td><input type="text" class="txt w400" name="value[title]"
                               value="<?=$value['title']?>"/> </td>
                </tr>
                <tr>
                    <th>学校图标</th>
                    <td><input name="value[thumb]" class="txt w400" type="text" id="thumb"
                               value="<?=$value['thumb']?>"  /> <input type="button" value="选择.."
                                                                     id="btn_thumb"/></td>
                </tr>
                <tr>
                    <th>学校简介</th>
                    <td><script id="editor" type="text/plain" style="width:850px;height:250px;"></script></td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td><input id="sub" type="button" name="s" value=" 提 交 " class="btn"
                               tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
                                                                        name="canc" value=" 取消 " class="btn"
                                                                        onclick="javascript:history.back();" /></td>
                </tr>
            </table>
        </form>

    </div>
    <script type="text/javascript">
        $(function() {
            var contentVal = $("#content").val();
            ue.addListener("ready", function () {
                ue.setContent(contentVal);
            });

            $("#sub").click(function(){
                var content = getContent();
                $("#content").val(content);

                $("#form").submit();
            });
        });

        function getContent() {
            var arr = [];
            arr.push(UE.getEditor('editor').getContent());
            return arr;
        }
    </script>
<?php $this->load->view('admin/footer');?>