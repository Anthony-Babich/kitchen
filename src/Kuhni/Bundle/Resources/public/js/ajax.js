//возможно будет файл
$('form.ajaxFormWithFile').submit(function (e) {
    e.preventDefault();
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
        $('form button').removeAttr("disabled","disabled");
        setTimeout(function(){$('.alert').fadeOut('fast')},3000);
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
});
//обыное сообщение
$('body').on('submit', '.ajaxForm', function (e) {
    e.preventDefault();
    $('form button').attr("disabled","disabled");
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
    }).done(function (data, status) {
        $('form').trigger('reset');
        if ((data['success'] = 'success')&&((status = 'success'))){
            $('form button').before(
                '<div class="alert alert-success" role="alert">' +
                '   <strong>Спасибо!</strong> Ваше сообщение отправлено.' +
                '</div>'
            );
        }else{
            $('form button').before(
                '<div class="alert alert-error" role="alert">' +
                '<strong>Что-то пошло не так!</strong>' +
                '</div>'
            );
        }
        $('form button').removeAttr("disabled","disabled");
        setTimeout(function(){$('.alert').fadeOut('fast')},3000);
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
});