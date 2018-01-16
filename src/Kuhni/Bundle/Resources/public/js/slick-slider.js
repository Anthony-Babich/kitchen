$('.featured_links_banner').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    arrows: false,
    fade: true,
    asNavFor: '.featured_links',
    autoplaySpeed: 5000
});
$('.featured_links').slick({
    slidesToShow: $('.banner_col').length,
    slidesToScroll: 0,
    asNavFor: '.featured_links_banner',
    dots: false,
    autoplay: true,
    centerMode: false,
    focusOnSelect: true,
    autoplaySpeed: 5000,
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
$('.testimonial_inner').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    dots: false,
    asNavFor: '.slider-nav-thumbnails'
});
$('.slider-nav-thumbnails').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    asNavFor: '.testimonial_inner',
    dots: false,
    arrows: false,
    focusOnSelect: true
});
$('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
$('.slider-nav-thumbnails .slick-slide').eq(0).addClass('slick-active');
$('.testimonial_inner').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
    var mySlideNumber = nextSlide;
    $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
    $('.slider-nav-thumbnails .slick-slide').eq(mySlideNumber).addClass('slick-active');
});