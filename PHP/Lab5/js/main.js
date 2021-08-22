$("#id-protected-submit").click(
    function (e) {
        e.preventDefault();
        $('#id-result').empty();

        let form = document.getElementById('id-protected-form');
        let fd = new FormData(form);

        $.ajax({
            url: "src/main.php",
            type: "POST",
            cache: false,
            processData: false,
            contentType: false,
            data: fd,
            success: function (response) {
                result = $.parseJSON(response);
                for (let i = 0; i < result.length; ++i) {
                    $('#id-result').append(`<li>
                        id: ${result[i].id}|
                        Имя: ${result[i].name}|
                        Почта: ${result[i].email}|
                        Пароль: ${result[i].password} </li>`);
                }
            },
            error: function (response) {
                $('#id-result').append('Ошибка. Данные не отправлены.');
                console.log(response);
            }
        });
    }
);

$("#id-injected-submit").click(
    function (e) {
        e.preventDefault();
        $('#id-result').empty();

        let form = document.getElementById('id-injected-form');
        let fd = new FormData(form);

        $.ajax({
            url: "src/main.php",
            type: "POST",
            cache: false,
            processData: false,
            contentType: false,
            data: fd,
            success: function (response) {
                result = $.parseJSON(response);
                for (let i = 0; i < result.length; ++i) {
                    $('#id-result').append(`<li>
                        id: ${result[i].id}|
                        Имя: ${result[i].name}|
                        Почта: ${result[i].email}|
                        Пароль: ${result[i].password} </li>`);
                }
            },
            error: function (response) {
                $('#id-result').append('Ошибка. Данные не отправлены.');
                console.log(response);
            }
        });
    }
);