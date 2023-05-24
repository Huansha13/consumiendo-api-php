<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>

    <?php
    $url = 'https://restcountries.com/v3.1/all';
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);

    if ($response) {
        $countries = json_decode($response, true);

        if ($countries) {
            echo '<table class="table table-bordered table-striped">';
            echo '<thead class="thead-light">';
            echo '<tr>';
            echo '<th>Nombre</th>';
            echo '<th>Bandera</th>';
            echo '<th>Latitud</th>';
            echo '<th>Longitud</th>';
            echo '<th>Capital</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($countries as $country) {
                echo '<tr>';
                echo '<td>' . $country['name']['common'] . '</td>';
                echo '<td><img src="' . $country['flags']['png'] . '" alt="Bandera de ' . $country['name']['common'] . '" width="50"></td>';
                echo '<td>' . (isset($country['latlng'][0]) ? $country['latlng'][0] : '') . '</td>';
                echo '<td>' . (isset($country['latlng'][1]) ? $country['latlng'][1] : '') . '</td>';
                echo '<td>' . (isset($country['capital'][0]) ? $country['capital'][0] : '') . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'No se encontraron datos de países.';
        }
    } else {
        echo 'Error al obtener los datos de la API.';
    }
    curl_close($curl);
    ?>


</body>

</html>