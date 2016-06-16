function addEvent(el,name,fn){//绑定事件 
if(el.addEventListener) return el.addEventListener(name,fn,false); 
return el.attachEvent('on'+name,fn); 
} 

function nextnode(node){//寻找下一个兄弟并剔除空的文本节点 
if(!node)return ; 
if(node.nodeType == 1) 
return node; 
if(node.nextSibling) 
return nextnode(node.nextSibling); 
} 

function prevnode(node){//寻找上一个兄弟并剔除空的文本节点 
if(!node)return ; 
if(node.nodeType == 1) 
return node; 
if(node.previousSibling) 
return prevnode(node.previousSibling); 
} 

function parcheck(self,checked){//递归寻找父亲元素，并找到input元素进行操作 
var par = prevnode(self.parentNode.parentNode.parentNode.previousSibling),parspar; 
if(par&&par.getElementsByTagName('input')[0]){ 
par.getElementsByTagName('input')[0].checked = checked; 
parcheck(par.getElementsByTagName('input')[0],sibcheck(par.getElementsByTagName('input')[0])); 
} 
} 

function sibcheck(self){//判断兄弟节点是否已经全部选中 
var sbi = self.parentNode.parentNode.parentNode.childNodes,n=0; 
for(var i=0;i<sbi.length;i++){ 
if(sbi[i].nodeType != 1)//由于孩子结点中包括空的文本节点，所以这里累计长度的时候也要算上去 
n++; 
else if(sbi[i].getElementsByTagName('input')[0].checked) 
n++; 
} 
return n==sbi.length?true:false; 
} 

addEvent(document.getElementById('root'),'click',function(e){//绑定input点击事件，使用root根元素代理 
e = e||window.event; 
var target = e.target||e.srcElement; 
var tp = nextnode(target.parentNode.nextSibling); 
switch(target.nodeName){ 
case 'A'://点击A标签展开和收缩树形目录，并改变其样式会选中checkbox 
// if(tp&&tp.nodeName == 'UL'){ 
// if(tp.style.display != 'block' ){ 
// tp.style.display = 'block'; 
// prevnode(target.parentNode.previousSibling).className = 'ren' 
// }else{ 
// tp.style.display = 'none'; 
// prevnode(target.parentNode.previousSibling).className = 'add' 
// } 
// } 
break; 
case 'SPAN'://点击图标只展开或者收缩 
var ap = nextnode(nextnode(target.nextSibling).nextSibling); 
if(ap.style.display != 'block' ){ 
ap.style.display = 'block'; 
target.className = 'ren' 
}else{ 
ap.style.display = 'none'; 
target.className = 'add' 
} 

break; 
case 'INPUT'://点击checkbox，父亲元素选中，则孩子节点中的checkbox也同时选中，孩子结点取消父元素随之取消 
if(target.checked){ 
if(tp){ 
var checkbox = tp.getElementsByTagName('input'); 
for(var i=0;i<checkbox.length;i++) 
checkbox[i].checked = true; 
} 
}else{ 
if(tp){ 
var checkbox = tp.getElementsByTagName('input'); 
for(var i=0;i<checkbox.length;i++) 
checkbox[i].checked = false; 
} 
} 
parcheck(target,sibcheck(target));//当孩子结点取消选中的时候调用该方法递归其父节点的checkbox逐一取消选中 
break; 
} 
}); 
window.onload = function(){//页面加载时给有孩子结点的元素动态添加图标 
	 /*var labels = document.getElementById('root').getElementsByTagName('label'); 
	 for(var i=0;i<labels.length;i++){ 
		 var span = document.createElement('span'); 
		 span.style.cssText ='display:inline-block;vertical-align:middle;cursor:pointer;'; 
		 span.innerHTML = ' ' 
		 span.className = 'add'; 
		 if(nextnode(labels[i].nextSibling)&&nextnode(labels[i].nextSibling).nodeName == 'UL') 
		 labels[i].parentNode.insertBefore(span,labels[i]); 
		 else 
		 labels[i].className = 'rem' 
	 } 

 $('.aa').parents('ul').css('display', 'block');

 $('.aa').parents('li').children('span').removeClass('add');
 $('.aa').parents('li').children('span').addClass('ren');
 $('.aa').parent('label').next('ul').css('display', 'block');
 $('.aa').parent('label').next('ul').children('.two').css('display', 'block');
 $('.aa').parent('label').next('ul').children('label').checked;*/
	
}

 $("#input3").click( function allselect() {
     $('#root').find('input[type=checkbox]').each(function () 
	 { $(this).attr('checked', 'checked'); });
})
$("#input4").click(function clearselect() {
     $('#root').find('input[type=checkbox]').each(function () 
	 { $(this).removeAttr('checked', 'checked'); });
 })
