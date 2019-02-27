$(window).scroll(function(){
    var vscroll = $(this).scrollTop();
    $('#logotext').css({
        "transform" : "translate(0px,"+ vscroll/2+"px)"
    })
});