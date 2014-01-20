<?php

$cache = __DIR__ . '/cache';

if (!file_exists($cache)) {

    $addresses = file(__DIR__ . '/config');
    $result = array();

    foreach ($addresses as $address) {
        $address = trim($address);
        if (empty($address)) continue;

        $url = "http://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($address);

        $data = current(json_decode(file_get_contents($url), true));

        $result[$address] = array(
            'lat' => $data['lat'],
            'lng' => $data['lon'],
        );
    }

    $result = json_encode($result);
    file_put_contents($cache, $result);

} else {

    $result = file_get_contents($cache);

}

header('Content-type: application/json');
echo $result;
