<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador Musica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <img src="https://logos-world.net/wp-content/uploads/2020/09/Spotify-Logo.png" style="height: 100px;">
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form class="mb-3" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" name="busqueda" id="busqueda"
                            placeholder="Buscar música" aria-label="Buscar música" aria-describedby="buscar-btn">
                        <button class="btn btn-primary" type="submit" id="buscar-btn">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        if (!isset($_POST['busqueda'])) {
            return;
        }

        // Definir los parámetros de búsqueda
        $busqueda = $_POST['busqueda']; // Inserta aquí la consulta de búsqueda deseada

        if (empty($busqueda)) {
            mensaje('Ingrese que música quiere buscar.', 'danger');
            return;
        }

        $tipo = "track"; // Puedes ajustar el tipo de búsqueda (track, album, artist, playlist, etc.)
    
        // Codificar la consulta de búsqueda para incluir en la URL
        $consultaCodificada = urlencode($busqueda);

        // Construir la URL de la API de Spotify para la búsqueda
        $url = "https://api.spotify.com/v1/search?q={$consultaCodificada}&type={$tipo}";

        // validamos la autorización de la URL
        if (!isset($_GET['access_token'])) {
            mensaje('No se recibió el código de autorización.', 'warning');
            header("Location: token.php");
            return;
        }

        $authorizationCode = $_GET['access_token'];

        // Inicializar cURL
        $curl = curl_init();

        // Configurar las opciones de solicitud HTTP con cURL
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $authorizationCode
                )
            )
        );

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

       
        // La solicitud no fue exitosa, mostrar el código de estado HTTP
        if ($codigoHttp != 200) {
            echo "Error HTTP: " . $codigoHttp;
            return;
        }

        // Procesar la respuesta
        // La solicitud fue exitosa, se obtienen los datos de la respuesta
        $datos = json_decode($respuesta, true);

        // Realizar el procesamiento deseado con los datos obtenidos
        // Por ejemplo, mostrar los nombres de las canciones encontradas
        echo '<div class="row">';
        foreach ($datos['tracks']['items'] as $item) {
            $nombreCancion = $item['name'];
            $imagenCancion = $item['album']['images'][0]['url'];
            $nombreArtista = $item['artists'][0]['name'];
            $duracion = $item['duration_ms'];
            $duracionMinutos = floor($duracion / 60000); // Divide la duración en milisegundos entre 60000 para obtener los minutos
            echo '
            <div class="col-3">
                <div class="card mb-2">
                    <img src="' . $imagenCancion . '" class="card-img-top" alt="' . $nombreCancion . '">
                    <div class="card-body">
                        <h5 class="card-title">' . $nombreCancion . '</h5>
                        <p class="card-text">Artista: ' . $nombreArtista . '</p>
                        <p class="card-text">Duración: ' . $duracionMinutos . ' minutos</p>
                    </div>
                </div>
            </div>
            ';
        }
        echo '</div>';
        
        function mensaje($mss, $tipo) {
            echo '
                <div class="alert alert-'.$tipo.' alert-dismissible fade show" role="alert">
                    <strong>¡Atención!</strong> '.$mss.'
                </div>
            ';
        }

        ?>

    </div>
</body>

</html>