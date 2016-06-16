/*
 *  Ueditor编辑器工作脚本
	$Id: ryo 2015-06-05
*/

function getContent() {
    var arr = [];
    arr.push(UE.getEditor('editor').getContent());
    return arr;
}

function setContent(isAppendTo) {
    var arr = [];
    arr.push("使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容");
    UE.getEditor('editor').setContent('欢迎使用ueditor', isAppendTo);
    alert(arr.join("\n"));
}

