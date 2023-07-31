<?php
// Incluir el archivo de conexión
require_once "../configuraciones/conexion.php";

session_start();

$error_message = ""; // Variable para almacenar el mensaje de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST["nombre_usuario"];
    $contraseña = $_POST["contraseña"];

    // Aquí se realizará la lógica de autenticación
    // Consulta la base de datos para verificar las credenciales del usuario

    // Ejemplo básico de verificación (NO seguro, solo para ilustrar)
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario' AND contraseña = '$contraseña'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Inicio de sesión exitoso, establecer variables de sesión y redirigir a la página de módulos
        $_SESSION["nombre_usuario"] = $nombre_usuario;
        header("Location: modulos.php");
        exit();
    } else {
        // Credenciales inválidas, mostrar un mensaje de error
        $error_message = "Nombre de usuario o contraseña incorrectos.";
    }
}

$conn->close();
?>


<<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form action="" method="post">
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required>
        <br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        <br>
        <input type="submit" value="Iniciar sesión">
        <p class="error-message" id="error-message"><?php echo isset($error_message) ? $error_message : ""; ?></p>
    </form>
</body>
</html>

