$('#id-sendEmail').click(function (e) {
    e.preventDefault();
    clearForm();

    let form = document.getElementById('id-feedback-form');
    let fd = new FormData(form);

    let errors = validate(fd);

    if (errors.length != 0) {
        displayErrors(errors);
        return;
    }

    $.ajax({
        url: 'src/mail.php',
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        data: fd,
        success: function (response) {
            alert(response);
        },
        error: function (response) {
            alert(response);
            displayErrors(response.responseJSON);
        }
    });

});

function validate(fd) {
    const fields = {
        'surname': 'Фамилия',
        'name': 'Имя',
        'patronymic': 'Отчетсво',
        'email': 'Email',
        'phone': 'Телефон',
        'comment': 'Комментарий'
    };

    let errors = [];

    for (let pair of fd.entries()) {
        if (pair[1] == '') {
            errors.push({'field_id': `id-${pair[0]}`, 'error_text': `Поле "${fields[pair[0]]}" является обязательным!`})
        }

        if (pair[0] == 'email') {
            if (!validateEmail(pair[1])) errors.push({
                'field_id': `id-${pair[0]}`,
                'error_text': 'Email не соответсвует допустимому формату!'
            })
        }

        if (pair[0] == 'phone') {
            if (!validatePhone(pair[1])) errors.push({
                'field_id': `id-${pair[0]}`,
                'error_text': 'Телефон не соответсвует формату РФ!'
            })
        }
    }
    return errors;
}

function clearForm() {
    $('#id-form-errors').empty();
    $('#id-feedback-form *').filter(':input').each(function () {
        if ($(this).hasClass('error')) $(this).removeClass('error')
    });
    let textarea = $('#id-comment')
    if (textarea.hasClass('error')) textarea.removeClass('error')
}

function displayErrors(errors) {
    for (let error of errors) {
        $(`#${error['field_id']}`).addClass('error')
        $('#id-form-errors').append(`<li>${error['error_text']}</li>`);
    }
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validatePhone(phone) {
    const re = /^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/;
    return re.test(String(phone).toLowerCase());
}
