<!DOCTYPE html>
<html>
<head>
  <title>Detalle de Pokémon</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Detalle de Pokémon</h1>

    <form method="GET" action="">
      <div class="form-group">
        <label for="identificador">Identificador del Pokémon:</label>
        <input type="text" class="form-control" id="identificador" name="identificador" required>
      </div>
      <button type="submit" class="btn btn-primary">Consultar</button>
    </form>

    <?php
    if (isset($_GET['identificador'])) {
      $identificador = $_GET['identificador'];

      // Obtener datos del Pokémon
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon/$identificador/");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      $respuesta = curl_exec($ch);
      curl_close($ch);

      $datos = json_decode($respuesta, TRUE);

      if (isset($datos['name'])) {
        // Mostrar información en una tarjeta
        echo '<div class="card mt-1" style="width: 18rem;">';
        echo '<img src="' . $datos['sprites']['front_default'] . '" class="card-img-top" alt="Imagen del Pokémon">';
        echo '<div class="card-body">';
        
        echo '<h5 class="card-title m-0 p-0">Nombre del Pokémon:</h5>';
        echo '<div class="card-text mb-2" style="font-size: 14px;">' . $datos['name'] . '</div>';

        echo '<h5 class="card-title m-0 p-0">Altura:</h5>';
        echo '<span class="card-text mb-2" style="font-size: 14px;">' . $datos['height'] . ' dm</span>';

        echo '<h5 class="card-title m-0 p-0">Peso:</h5>';
        echo '<span class="card-text mb-2" style="font-size: 14px;">' . $datos['weight'] . ' hg</span>';

        echo '<h5 class="card-title m-0 p-0">Habilidades:</h5>';
        echo '<div class="card-text" style="font-size: 14px;">';
        foreach ($datos['abilities'] as $habilidad) {
            echo '<span class="badge badge-primary">' . $habilidad['ability']['name'] . '</span> ';
        }
        echo '</div>';

        echo '</div>';
        echo '</div>';
      } else {
        echo '<p class="text-danger">No se encontró el Pokémon con el identificador proporcionado.</p>';
      }
    }
    ?>
  </div>
</body>
</html>
