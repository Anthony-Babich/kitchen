//возможно будет файл
$('body').on('submit', '.ajaxFormWithFile', function (e) {
    e.preventDefault();
    $('form button').attr("disabled","disabled");
    var formData = new FormData($(this));
    var $input = $("form#ZayavkaRazmer").find("#form_imageFile_file");
    var $form = $(this);
    $inputs = $form.find('input');
    formData.append('files', $input.prop('files')[0]);
    for(i = 0; i < $inputs.length; i++){
        formData.append(i, $inputs[i].value);
    }
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: formData,
        processData: false,
        cache: false,
        contentType: false
    }).done(function (data, status) {
        $('form').trigger('reset');
        if ((data['success'] = 'success')&&(status = 'success')){
            $('form button').before(
                '<div class="alert alert-success" role="alert">' +
                    '<strong>Спасибо!</strong> Ваше сообщение отправлено.' +
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
})
//обыное сообщение
.on('submit', '.ajaxForm', function (e) {
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