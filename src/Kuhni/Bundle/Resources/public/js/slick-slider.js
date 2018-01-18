$('.featured_links_banner').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    arrows: true,
    lazyLoad: 'ondemand',
    fade: true,
    asNavFor: '.featured_links',
    autoplaySpeed: 3000
});
$('.featured_links').slick({
    slidesToShow: $(".banner_col").length,
    autoplay: true,
    centerMode: false,
    lazyLoad: 'ondemand',
    focusOnSelect: true,
    asNavFor: '.featured_links_banner',
    autoplaySpeed: 3000,
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                arrows: false,
                centerMode: true,
                slidesToShow: 4
            }
        },
        {
            breakpoint: 768,
            settings: {
                arrows: false,
                centerMode: true,
                slidesToShow: 3
            }
        },
        {
            breakpoint: 480,
            settings: {
                arrows: false,
                centerMode: true,
                slidesToShow: 2
            }
        }
    ]
});