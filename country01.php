<?php
$countryCode = 'us'; // Código del país que deseas obtener información

$url = "https://restcountries.com/v2/alpha/$countryCode";

$options = array(
    'http' => array(
        'method' => 'GET',
        'header' => 'Content-type: application/json'
    )
);

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response) {
    $countryData = json_decode($response, true);
    // Procesar y mostrar los datos del país
    echo "Nombre del país: " . $countryData['name'] . "\n";
    echo "Capital: " . $countryData['capital'] . "\n";
    echo "Población: " . $countryData['population'] . "\n";
    // Otros datos disponibles en la respuesta...
} else {
    echo "Error al obtener los datos del país.";
}
?>
