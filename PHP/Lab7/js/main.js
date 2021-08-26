$('#id-address-submit').click(function (e) {
    e.preventDefault();

    let form = document.getElementById('id-address');
    let fd = new FormData(form);

    $.ajax({
        url: 'src/api.php',
        type: 'POST',
        cache: 'false',
        processData: false,
        contentType: false,
        data: fd,
        beforeSend: function () {
            $("#id-address-submit").prop('disabled', true);
        },
        success: function (response) {
            response = JSON.parse(response);
            console.log(response.address);
            displayAddress(response.address);
            displayCoords(response.coords);
            displayMetro(response.metro);
            $("#id-address-submit").prop('disabled', false);
        },
        error: function (response) {
            alert('Запрос не выполнен!');
            $("#id-address-submit").prop('disabled', false);
        }
    });
});

function displayAddress(address) {
    const kind = {
        'country': 'Страна',
        'province': 'Регион',
        'area': 'Район',
        'locality': 'Населенный пункт',
        'district': 'Район города',
        'metro': 'Метро',
        'street': 'Улица',
        'house': 'Дом',
        'hydro': 'Водоем',
        'railway': 'Ж.д. станция',
        'route': 'Линия метро',
        'vegetation': 'Парк',
        'airport': 'Аэропорт',
        'other': 'прочее'
    };

    let addressList = $('#id-address-list');
    addressList.empty();

    Object.keys(address).forEach(key => {
        let rowData = `<li class="list-group-item">${kind[key]}: ${address[key]}</li>`;
        addressList.append(rowData);
    });
}

function displayCoords(coords) {
    let coordsList = $('#id-coords-list');
    coordsList.empty();
    coords = coords.split(',');
    coordsList.append(`<li class="list-group-item">Широта: ${coords[1]}</li>`);
    coordsList.append(`<li class="list-group-item">Долгота: ${coords[0]}</li>`);
}

function displayMetro(metro) {
    let metroArea = $('#id-result-metro');
    metroArea.empty();
    if (metro) {
        metroArea.append(metro);
    }
    else {
        metroArea.append('К сожалению, метро поблизости не найдено!');
    }
}