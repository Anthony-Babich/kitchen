$(document).ready(function () {
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // FEATURES LINK BANNER
    $('.featured_links_banner').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        fade: true,
        asNavFor: '.featured_links',
        autoplaySpeed: 5000,
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

    $('.learn_more').removeAttr('tabindex');
    $('.learn_more').append('<em class="wave1 blue-effect"></em>');
    $('.coloroptions').slick({
        infinite: true,
        slidesToShow: 2,
        arrows: true,
        slidesToScroll: 1,
        responsive: [
        {breakpoint: 902, settings: {slidesToShow: 2}},
        {breakpoint: 667, settings: {slidesToShow: 1}}
        ]
    });
    $('.testimonial_inner').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        dots: false,
        asNavFor: '.slider-nav-thumbnails',
    });
    $('.slider-nav-thumbnails').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.testimonial_inner',
        dots: false,
        arrows: false,
        focusOnSelect: true,
    });

    // Remove active class from all thumbnail slides
    $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');

    // Set active class to first thumbnail slides
    $('.slider-nav-thumbnails .slick-slide').eq(0).addClass('slick-active');

    // On before slide change match active thumbnail to current slide
    $('.testimonial_inner').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        var mySlideNumber = nextSlide;
        $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
        $('.slider-nav-thumbnails .slick-slide').eq(mySlideNumber).addClass('slick-active');
    });

    var timer_video;
    var trigger = $(".play-btn");
    trigger.click(function () {
        var theModal = $(this).data("target");

        var videoSRC = $(this).attr("rel"),
        videoSRCauto = videoSRC;
        $(theModal + ' iframe').attr('src', videoSRCauto);
        $(theModal + ' button.close').click(function () {
            $(theModal + ' iframe').attr('src', videoSRC);
        });
        timer_video = setTimeout(function () {
            $(theModal).modal('hide');
        }, 19000);
    });

    $("#myModalClickDiv").click(function () {
        $("#myModal").modal('hide');
        if (timer_video) {
            clearTimeout(timer_video);
        }
    });

    new WOW().init();
});
$(".tab-slide").slick({
    slidesToShow: $('.tab-slide li').length || 4,
    arrows: !1,
    infinite: !1,
    slidesToScroll: 1,
    focusOnSelect: !0,
    responsive: [{
        breakpoint: 990,
        settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            centerMode: !0,
            centerPadding: "60px"
        }
    },
    {
        breakpoint: 480,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            centerMode: !0,
            centerPadding: "60px"
        }

    },
    {
        breakpoint: 990,
        settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            centerMode: !0,
            centerPadding: "60px"
        }
    }]
});
$('.retailer_inner').slick({
    centerMode: false,
    arrows: false,
    centerPadding: '15px',
    autoplay: true,
    //  slidesToScroll: 1,
    slidesToShow: $('.retailer_inner img').length > 4 ? 5 : $('.retailer_inner img').length,
    dots: false,
    responsive: [
    {
        breakpoint: 992,
        settings: {
            centerMode: true,
            slidesToShow: 4,
            variableWidth: true
        }
    },
    {
        breakpoint: 767,
        settings: {
            centerMode: true,
            slidesToShow: 2,
            variableWidth: true
        }
    },
    {
        breakpoint: 560,
        settings: {
            centerMode: true,
            slidesToShow: 1,
            variableWidth: true
        }
    }
    ]

});
$(document).ready(function () {

    $('ul.tabs li').click(function () {
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $("#" + tab_id).addClass('current');
    })
    $( window ).resize(function() {
        get_height();                   
    });
    
    $(".meet_artist").click(function(){ 
        $( "#meet_artist_toggle" ).slideDown( "slow")
        $( ".meet_artist" ).addClass( "slide_btn")
        $( ".meet_artist_close" ).addClass( "view")
    }); 
    
    $(".meet_artist_close").click(function(){   
        $( "#meet_artist_toggle" ).slideUp( "slow")
        $( ".meet_artist" ).removeClass( "slide_btn")
        $( ".meet_artist_close" ).removeClass( "view")           
    });    
    
    $('.share_artwork').click(function(){
        var element = document.createElement("script");
        element.src = 'https://app.viralsweep.com/vsa-lightbox-73c665-19683.js?sid=19683_451921';
        element.id = 'vsscript_19683_451921';
        element.type = 'text/javascript';
        document.body.appendChild(element);
    });

});
$('#myModal').on('hidden.bs.modal', function () {
    var theModal = $('.play-btn').data("target");
    var videoSRC = $('.play-btn').attr("rel");
    videoSRCauto = videoSRC;
    $(theModal + ' iframe').attr('src', videoSRCauto);
    videoSRC = videoSRC.replace('autoplay=1', 'autoplay=0');
    $(theModal + ' iframe').attr('src', videoSRC);
});
$('.close-btn').click(function (e) {
    e.preventDefault();
    $('.ue-top_haeder').slideUp();
    $('body').removeClass('top-signup');
    $('body').addClass('no-top-signup');
});
$('.close-btn').click(function (e) {
    e.preventDefault();
    $('.ue-top_haeder').remove();
    $('header').addClass("top44no");
    $('body').css("padding-top", "53px");
});
jQuery('.comparetrigger').click(function () {
    jQuery('.coloroptions .slick-next').trigger('click');
});
jQuery('#click_auto').click(function () {
    jQuery('.coloroptions .slick-next').trigger('click');
});
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
$(document).on('click', '.art_thumb li', function(){
    setTimeout(function(){
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav',
        });
        $('.slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: true,
            centerMode: true,
            focusOnSelect: true
        });
        $('.slider-for').on('afterChange', function(event, slick, currentSlide, nextSlide){
            var imageUrl = $('#main_popup .slick-active img').attr('src');
            imageName = imageUrl.substring(imageUrl.lastIndexOf('/')+1, imageUrl.length);
            url = pageUrl + '?download='+imageName;
            $('.download_link_container a').attr('href', url);
        });
    }, 500);
});
window.onload = function () {
    var reviewElements = document.getElementsByClassName('whole_link');
    for (x in reviewElements) {
        if (x < reviewElements.length) { 
            var variant = reviewElements[x].getAttribute('data-variant');
            var product = reviewElements[x].getAttribute('data-product');
            var targetId = 'rev-' + product;
            POWERREVIEWS.display.render({
                api_key: 'c7636b92-ee5b-4631-baa4-710ad0688e49',
                locale: 'en_US',
                merchant_group_id: '49360',
                merchant_id: '301706',
                page_id: product,
                pr_page_id_variant: variant,
                components: {
                    CategorySnippet: targetId,
                }
            });
        }
    }    
}
$( '.learn_more_button').click(function(){
    $(this).attr('played_vid', 1);
    $('#playerModal').modal('show');
    var videoId = 'W6p1FJJcp1I';
    var src = "https://www.youtube.com/embed/" + videoId + "?modestbranding=1&wmode=opaque&controls=0&autoplay=1&showinfo=0&enablejsapi=1";
    $('#player').attr('src', src);
    onYouTubeIframeAPIReady();
    return false;
});
$('.video_content').click(function(){
    setTimeout(function(){
        get_height();
        $('.lifestyle_section iframe').css('height', '');
        var maxHeight = Math.max.apply(null,
            jQuery(".lifestyle_section iframe").map(function(){
                return $(this).height();
            }).get());
        $(".lifestyle_section iframe").height(maxHeight);
        if (!$('.slider').hasClass('slick-slider')){
            $('.lifestyle_section .slider').slick({
                centerMode: true,
                arrows: false,
                centerPadding: '15px',
                centerMode: false,
                autoplay: true,                    
                slidesToShow: 3,
                responsive: [
                {
                    breakpoint: 769, 
                    settings: { 
                        arrows: false,
                        centerMode: true,
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 668,
                    settings: { 
                        arrows: false,
                        centerMode: true,
                        slidesToShow:1
                    }
                }
                ]
            }); }
            $('#artwork-modal .play_video_btn').first().trigger('click');
        }, 1000);
});
var player;
function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}
function onPlayerReady(event) {
    player.setPlaybackQuality('hd1080');
        // event.target.playVideo();0
        //alert('starting playback');
    }
    var done = false;
    function onPlayerStateChange(event) {
        if (event.data == 0) {
            $('#playerModal').modal('hide');
            var src = $('#player').attr('src', $('#player').data('src'));
            var src = src.replace('autoplay=1', 'autoplay=0');
            $('#player').attr(src);
            stopVideo();
        }
    }
    function stopVideo() {
        player.stopVideo();
        
    }
    $(document).on('click', '.play_video_btn', function (ev) {
        $('#playerModal').modal('show');
        var videoId = $(this).attr('data-video-id');
        var src = "https://www.youtube.com/embed/" + videoId + "?modestbranding=1&wmode=opaque&controls=0&autoplay=1&showinfo=0&enablejsapi=1";
        $('#player').attr('src', src);
        onYouTubeIframeAPIReady();
        return false;
    });

//== stop youtube video on modal close
$(document).on("click", ".modal-backdrop, #playerModal .close, #playerModal .btn",function () {
    var src = jQuery("#playerModal iframe").attr("src");
    var iFrame = jQuery("#playerModal").find("iframe");
    iFrame.attr("src", "");
//jQuery("#myModal iframe").attr("src", jQuery("#myModal iframe").attr("src"));
});
$("#pr-reviewsnippet").click(function () {
    $(".reviews").trigger("click");
});
function get_height() {             
    var aHeight = $('.depend_height').innerHeight();                                
    var bHeight = $('.main_height').innerHeight();                          
    $('.depend_height').css('height',bHeight + "px");   
}
$('#playerModal').on('hidden.bs.modal', function(){
    if ($('.modal.in').length > 0){
        $('body').addClass('modal-open');
    }
});
$('#artwork-modal').on('hidden.bs.modal', function(){
    $('body').css('padding-right', 0);
});