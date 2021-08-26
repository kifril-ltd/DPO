<?php
    $config = require __DIR__ . '/../config/config.php';
    if (isset($_POST['address'])) {
        $base_url = 'https://geocode-maps.yandex.ru/1.x/?';
        $params = [
            'apikey' => $config['apikey'],
            'geocode' => $_POST['address'],
            'format' => 'json',
        ];

        $resp = file_get_contents($base_url . http_build_query($params));

        $resp = json_decode($resp, true);

        $address_components = $resp['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'];
        $address_coords = str_replace(' ', ',', $resp['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);

        $params = [
            'apikey' => $config['apikey'],
            'geocode' => $address_coords,
            'kind' => 'metro',
            'format' => 'json',
            'results' => 1,
        ];

        $resp = file_get_contents($base_url . http_build_query($params));
        $resp = json_decode($resp, true);

        $metro = $resp['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];

        $result = [];

        foreach ($address_components as $component) {
            $result['address'][$component['kind']] = $component['name'];
        }

        $result['coords'] = $address_coords;

        $result['metro'] = $metro;


        echo json_encode($result);
    }