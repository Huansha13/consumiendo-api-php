<?php

// Parámetros de autenticación
$clientId = "ef40d05a59574155b47e4051f9f50c0c*"; // Reemplaza con tu ID de cliente de Spotify
$clientSecret = "4670d4c93d5a4fff96aeb6f039b54fc6*"; // Reemplaza con tu cliente secreto de Spotify
$authorization = base64_encode($clientId . ':' . $clientSecret);

// URL para solicitar el token de acceso
$url = 'https://accounts.spotify.com/api/token';

// Datos de la solicitud POST
$data = array(
    'grant_type' => 'client_credentials'
);

// Configurar las opciones de solicitud HTTP con cURL
$opciones = array(
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Basic ' . $authorization,
        'Content-Type: application/x-www-form-urlencoded'
    )
);

// Inicializar cURL y establecer las opciones
$curl = curl_init();
curl_setopt_array($curl, $opciones);

// Ejecutar la solicitud y obtener la respuesta
$respuesta = curl_exec($curl);

// Verificar si hubo algún error en la solicitud
if (curl_errno($curl)) {
    echo 'Error en la solicitud: ' . curl_error($curl);
}

// Obtener el código de estado HTTP de la respuesta
$codigoHttp = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// Cerrar la conexión cURL
curl_close($curl);

// Procesar la respuesta
if ($codigoHttp == 200) {
    // La solicitud fue exitosa, se obtiene el token de acceso
    $datos = json_decode($respuesta, true);
    $accessToken = $datos['access_token'];
    echo $accessToken;
    header("Location: buscar-musica.php?access_token=" . $accessToken);
    exit;

    // Ahora puedes usar el token de acceso para realizar otras solicitudes a la API de Spotify
    // ...
} else {
    // La solicitud no fue exitosa, mostrar el código de estado HTTP
    echo "Error HTTP: " . $codigoHttp;
}

?>
