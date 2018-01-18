$(document).ready(function(){
    $('#search-tags').slick({
        dots: false,
        autoplay: true,
        slidesToShow: 8,
        infinite: false,
        slidesToScroll: 8,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 6,
                    slidesToScroll: 6
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            }
        ]
    });
    $('.popular-slick').slick({
        slidesToShow: 4,
        slidesToScroll: 2,
        autoplay: true,
        dots: false,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    if (device.mobile() || device.tablet()){
        $('.popular-slick .slide-col .pos-bot-l').css('width', $('.popular-slick .slide-col').width());
        $('.popular-slick .slide-col .pos-bot-r').css('margin-left', $('.popular-slick .slide-col').width() - 50 );
        $('.popular-slick .slide-col .phone').css('margin-left', $('.popular-slick .slide-col').width() - 50 );
    }
    //Ограничение количества символов в отвызывах
    var rev = $('.review-span-text');
    for (i = 0; i < rev.length; i++){
        rev.eq(i).text(rev.eq(i).text().slice(0, 198));
    }
    //Пошаговая форма
    $('#freedesignshag a[data-toggle="tab"]').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $(".next-step").click(function () {
        var $active = $('#freedesignshag .nav-tabs li>a.active');
        $active.parent().next().removeClass('disabled');
        $($active).parent().next().find('a[data-toggle="tab"]').click();
    });
    $(".prev-step").click(function () {
        var $active = $('#freedesignshag .nav-tabs li>a.active');
        $($active).parent().prev().find('a[data-toggle="tab"]').click();
    });
    // Конец пошаговой формы
    $('ul.tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');
        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });
    if(!device.tablet() && !device.mobile()){
        $('.navbar-nav').find('.nav-item').last().html('<a class="nav-link" href="#requestcall" data-toggle="modal"><i class="mutted-item">Позвонить<br></i>+7 (987) 522-55-22</a>');
        $('#requestcall').on('show');
    }
});