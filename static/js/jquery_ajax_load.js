/**
 * Created by Administrator on 2015-10-27.
 */
function ajaxreadyload()
{
    $loadMask=$('<div><div style="background-color:#fff;opacity:0.8;width:100%;height: 100%;position:absolute;left: 0;top: 0;z-index: 9999;"></div>' +
    '<div style="position: absolute;z-index:10000;width: 170px;height: 100px;left: 50%;margin-left: -135px;margin-top: -50px;text-align: center;font: 16px/25px \"Microsoft YaHei\";"><img src="../static/images/ajax_loader.gif"></<br/></div></div>');
    $loadMask.appendTo(document.getElementById("")).hide();

    $.ajaxSend({
        timeout:30000,// 超时设置：5分钟
        beforeSend:function()
        {
            $win =$(window);
            var x=(($win.width()-$loadMask.outerWidth())/2)+$win.scrollLeft()+"px";
            var y=(($win.height()-$loadMask.outerHeight()/2)+$win.scrollTop())+"px";
            $loadMask.css({
                left:x,
                top:y
            }).show();
        },
        complete:function(){
            $loadMask.hide();
        }

    });
    $(".ajaxload").ajaxStart(function () {
        winshow();
    });

    $(".ajaxload").ajaxComplete(function (event, request, settings) {
        hideshow();
    });
}


function winshow() {

    $win = $(window);
    var x = (($win.width() - $loadMask.outerWidth()) / 2) + $win.scrollLeft() + "px";
    var y = (($win.height() - $loadMask.outerHeight()) / 2) + $win.scrollTop() + "px";
    $loadMask.css({
        left: x,
        top: y
    }).show();
}

function hideshow() {
    $loadMask.hide();
}