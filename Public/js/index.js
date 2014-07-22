/*
 * 首页全局js
 * author：zy
 * email: 1016366921@qq.com
*/
$(document).ready(function () {
    //$('.carousel').carousel(); //启动图片轮播
    $('#navbar li').click(function(){
        $('#navbar').find('li').removeClass('active');
        $(this).addClass('active');        
    });
    //图片鼠标悬停效果
    $('.img-responsive').adipoli({
        'startEffect' : 'normal',
        'hoverEffect' : 'boxRainGrowReverse'
    });
});




