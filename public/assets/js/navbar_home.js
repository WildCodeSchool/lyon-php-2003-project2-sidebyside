$(window).scroll(function (event) {
    var scroll = $(window).scrollTop();
    if ($(window).width() > 992) {
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
    }
});
if ($(window).width() > 992) {
    $('.navbar').css({
        background: 'none'
    });
    $('main').css({
        'margin-top': '0'
    });
}
