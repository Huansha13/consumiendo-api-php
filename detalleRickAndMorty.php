<!DOCTYPE html>
<html>
<head>
  <title>Detalle de Personaje de Rick and Morty</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Detalle de Personaje de Rick and Morty</h1>

    <form method="GET" action="">
      <div class="form-group">
        <label for="identificador">ID del Personaje:</label>
        <input type="text" class="form-control" id="identificador" name="identificador" required>
      </div>
      <button type="submit" class="btn btn-primary">Consultar</button>
    </form>

    <?php
    if (isset($_GET['identificador'])) {
      $identificador = $_GET['identificador'];

      // Obtener datos del personaje
      $url = "https://rickandmortyapi.com/api/character/$identificador";
      $response = file_get_contents($url);
      $data = json_decode($response, TRUE);

      if (isset($data['name'])) {
        // Mostrar información en una tarjeta
        echo '<div class="card mt-1" style="width: 18rem;">';
        echo '<img src="' . $data['image'] . '" class="card-img-top" alt="Imagen del Personaje">';
        echo '<div class="card-body">';
        
        echo '<h5 class="card-title m-0 p-0">Nombre del Personaje:</h5>';
        echo '<div class="card-text mb-2" style="font-size: 14px;">' . $data['name'] . '</div>';

        echo '<h5 class="card-title m-0 p-0">Especie:</h5>';
        echo '<span class="card-text mb-2" style="font-size: 14px;">' . $data['species'] . '</span>';

        echo '<h5 class="card-title m-0 p-0">Género:</h5>';
        echo '<span class="card-text mb-2" style="font-size: 14px;">' . $data['gender'] . '</span>';

        echo '<h5 class="card-title m-0 p-0">Origen:</h5>';
        echo '<span class="card-text mb-2" style="font-size: 14px;">' . $data['origin']['name'] . '</span>';

        echo '</div>';
        echo '</div>';
      } else {
        echo '<p class="text-danger">No se encontró el personaje con el ID proporcionado.</p>';
      }
    }
    ?>
  </div>
</body>
</html>
