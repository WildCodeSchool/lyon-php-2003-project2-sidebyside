$(window).scroll(function (event) {
    var scroll = $(window).scrollTop();
    if (scroll > 80) {
        $('.navbar').css({
            background: 'black'
        });
        $('main').css({
            'margin-top': '0'
        });
    } else {
        $('.navbar').css({
            background: 'none'
        });
        $('main').css({
            'margin-top': '0'
        });
    }
});
$('.navbar').css({
    background: 'none'
});
$('main').css({
    'margin-top': '0'
});