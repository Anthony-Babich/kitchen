$(document).ready(function(){
    //возможно будет файл
    $('form.ajaxFormWithFile').submit(function (e) {
        e.preventDefault();
        if ($(this).find('input[name="privacy-politycs"]').prop('checked')) {
            $('form button').attr("disabled","disabled");
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false
            }).done(function (data, status) {
                $('form').trigger('reset');
                if ((data['success'] = 'success')&&(status = 'success')){
                    $('form button').before(
                        '<div class="alert alert-success" role="alert">' +
                        '<strong>Спасибо!</strong> Ваше сообщение отправлено.' +
                        '</div>'
                    );
                }else if (status = 'noData'){
                    $('form button').before(
                        '<div class="alert alert-error" role="alert">' +
                        '<strong>Заполните все поля!</strong>' +
                        '</div>'
                    );
                }else{
                    $('form button').before(
                        '<div class="alert alert-error" role="alert">' +
                        '<strong>Что-то пошло не так!</strong>' +
                        '</div>'
                    );
                }
                setTimeout(function(){$('.alert').fadeOut('fast')},3000);
                $('form button').removeAttr("disabled","disabled");
            }).fail(function (jqXHR, textStatus, errorThrown) {
                if (typeof jqXHR.responseJSON !== 'undefined') {
                    if (jqXHR.responseJSON.hasOwnProperty('form')) {
                        $('#form_body').html(jqXHR.responseJSON.form);
                    }
                    $('.form_error').html(jqXHR.responseJSON.message);
                } else {
                    alert(errorThrown);
                }
                $('form button').removeAttr("disabled","disabled");
            });
        }else{
            $(this).find('button[type="submit"]').after(
                '<div class="alert alert-info" role="alert">' +
                '<strong>Необходимо подтвердить политику конфиденциальности!</strong>' +
                '</div>'
            );
        }
    });
    //обыное сообщение   privacy-politycs
    $('body').on('submit', '.ajaxForm', function (e) {
        e.preventDefault();
        if ($(this).find('input[name="privacy-politycs"]').prop('checked')) {
            $('form button').attr("disabled", "disabled");
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize()
            }).done(function (data, status) {
                $('form').trigger('reset');
                if ((data['success'] = 'success') && ((status = 'success'))) {
                    $('form button[type="submit"]').after(
                        '<div class="alert alert-success" role="alert">' +
                        '<strong>Спасибо!</strong> Ваше сообщение отправлено.' +
                        '</div>'
                    );
                } else {
                    $('form button[type="submit"]').after(
                        '<div class="alert alert-error" role="alert">' +
                        '<strong>Что-то пошло не так!</strong>' +
                        '</div>'
                    );
                }
                $('form button').removeAttr("disabled", "disabled");
                setTimeout(function () {
                    $('.alert').fadeOut('fast')
                }, 3000);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                if (typeof jqXHR.responseJSON !== 'undefined') {
                    if (jqXHR.responseJSON.hasOwnProperty('form')) {
                        $('#form_body').html(jqXHR.responseJSON.form);
                    }
                    $('.form_error').html(jqXHR.responseJSON.message);
                } else {
                    alert(errorThrown);
                }
                $('form button').removeAttr("disabled", "disabled");
            });
        }else{
            $(this).find('button[type="submit"]').after(
                '<div class="alert alert-info" role="alert">' +
                '<strong>Необходимо подтвердить политику конфиденциальности!</strong>' +
                '</div>'
            );
        }
    })

    //like for kitchen
    .on('click', 'button#like', function (e) {
        e.preventDefault();
        var $button = $(this);
        var ar = {
            'id' : $(this).attr('data-id')
        };
        //id kitchen $(this).attr('data-id')
        $.ajax({
            type: 'post',
            url: 'http://kitchen/web/app_dev.php/newlike',
            data: ar
        }).done(function (data, status) {
            var data1 = $.parseJSON(data);
            if ((data1['success'] = 'success') && ((status = 'success'))) {
                if ($button.hasClass('active')) {
                    $button.removeClass('active');
                    $button.find('span.countLikes').text(data1['count']);
                } else {
                    $button.addClass('active');
                    $button.find('span.countLikes').text(data1['count']);
                }
            }else{
                if (data['success'] = 'noData'){
                    alert('Нету такой кухни! Перезагрузите страницу!');
                }
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            if (typeof jqXHR.responseJSON !== 'undefined') {
                if (jqXHR.responseJSON.hasOwnProperty('form')) {
                    $('#form_body').html(jqXHR.responseJSON.form);
                }
                $('.form_error').html(jqXHR.responseJSON.message);
            } else {
                alert(errorThrown);
            }
        });
    });
});