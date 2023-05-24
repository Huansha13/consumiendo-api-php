<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>

    <!-- Contenedor para mostrar la lista de Pokémon -->
    <div class="container" id="pokemon-container">
        <h1>
            Lista de pokemon
        </h1>
        
        <?php
        // Verificar si se ha recibido la URL en la solicitud POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
            // Obtener la URL enviada desde el botón
            $url = $_POST['url'];
            // Ejecutar la función getPokemonData con la nueva URL
            getPokemonData($url);
        } else {
            // Si no se ha recibido una URL, cargar la lista de Pokémon inicial
            $pokemonUrl = 'https://pokeapi.co/api/v2/pokemon';
            getPokemonData($pokemonUrl);
        }
        ?>
    </div>

    <?php
    function getPokemonData($url)
    {
        $resp = file_get_contents($url);
        loadPokemons($resp);
        return $resp;
    }

    function loadPokemons($response)
    {
        // Verificar si la solicitud se realizó correctamente
        if ($response !== false) {
            // Decodificar la respuesta JSON en un arreglo asociativo
            $data = json_decode($response, true);

            // Obtener la lista de Pokémon
            $results = $data['results'];

            // Mostrar la información de cada Pokémon utilizando tarjetas de Bootstrap
            echo '<div class="row">';

            foreach ($results as $pokemon) {
                $name = $pokemon['name'];
                $image = "https://img.pokemondb.net/artwork/" . $name . ".jpg";
                // Generar la estructura de la tarjeta de Bootstrap con la imagen, nombre y descripción del Pokémon
                echo '
                    <div class="col-3 card" style="width: 18rem;">
                        <img src="' . $image . '" class="card-img-top" alt="' . $name . '">
                        <div class="card-body d-flex flex-column justify-content-between">                           
                            <div class="mt-auto">
                                <h5 class="card-title">' . $name . '</h5>
                            </div>
                        </div>
                    </div>
                ';

            }

            // Obtener los enlaces para los botones de "Anterior" y "Siguiente"
            $previousUrl = $data['previous'];
            $nextUrl = $data['next'];

                // Mostrar los botones de navegación
                echo '<div class="mt-2 mb-2">';
                    if ($previousUrl) {
                        echo '<button type="button" onclick="cargarPokemons(\'' . $previousUrl . '\')" class="btn btn-secondary mr-2">Anterior</button>';
                    } else {
                        echo '<button class="btn btn-secondary mr-2" disabled>Anterior</button>';
                    }
                    if ($nextUrl) {
                        echo '<button type="button" onclick="cargarPokemons(\'' . $nextUrl . '\')" class="btn btn-primary">Siguiente</button>';
                    }
                echo '</div>';
            echo '</div>';
        } else {
            // Ocurrió un error al realizar la solicitud
            echo "Error al acceder a la PokéAPI.";
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function cargarPokemons(url) {
            console.log(url);
            // Realizar una solicitud AJAX para cargar la nueva lista de Pokémon
            // Reemplaza 'tu_archivo.php' con la ruta correcta de tu archivo PHP
            $.ajax({
                url: 'pokemones.php',
                type: 'POST',
                data: { url: url },
                success: function (response) {
                    // Actualizar el contenido de la página con la nueva lista de Pokémon
                    $('#pokemon-container').html(response);
                },
                error: function () {
                    // Manejar el error si la solicitud AJAX falla
                    console.log('Error al cargar la lista de Pokémon');
                }
            });
        }
    </script>

</body>

</html>