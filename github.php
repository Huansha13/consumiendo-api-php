<form method="GET" action="">
    <label for="username">Nombre de usuario de GitHub:</label>
    <input type="text" id="username" name="username" required>
    <button type="submit">Mostrar perfil</button>
</form>

<?php
$username = isset($_GET['username']) ? $_GET['username'] : '';

if ($username) {
    // Realizar la solicitud GET al API de GitHub
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.github.com/users/{$username}");
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'); // aplicación que se utiliza para acceder al sitio web.

    $response = curl_exec($ch);
    curl_close($ch);

    $curl_error = curl_error($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($http_status != 200) {
        echo 'Error al obtener los datos de la API. Código de estado: ' . $http_status . '<br>';
        echo 'Mensaje de error: ' . $curl_error . '<br>';
        return;
    }

    // Decodificar la respuesta JSON
    $profile = json_decode($response, true);

    // Mostrar la información del perfil
    if (isset($profile['message'])) {
        echo 'Error: ' . $profile['message'];
        return;
    }

    echo '<img src="' . $profile['avatar_url'] . '" alt="Foto de perfil"><br>';
        echo 'Nombre de usuario: ' . $profile['login'] . '<br>';
        echo 'Nombre completo: ' . $profile['name'] . '<br>';
        echo 'Biografía: ' . $profile['bio'] . '<br>';
        echo 'Seguidores: ' . $profile['followers'] . '<br>';
        echo 'Repositorios públicos: ' . $profile['public_repos'] . '<br>';
}
?>