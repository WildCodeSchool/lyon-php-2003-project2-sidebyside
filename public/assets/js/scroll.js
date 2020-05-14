$(document).ready(function() {
    $('a').click(function(e) {

        var targetHref = $(this).attr('href');

        $('html, body').animate({
            scrollTop: $(targetHref).offset().top-100
        }, 1000);

        e.preventDefault();
    });
});