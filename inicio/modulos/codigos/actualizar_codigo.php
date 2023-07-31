<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado el formulario para actualizar el registro
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["codigo"], $_POST["descripcion"])) {
    $codigo_id = $_POST["id"];
    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];

    // Configuración de la conexión a la base de datos (puedes reutilizarla aquí)
    require_once "../../../configuraciones/conexion.php";
    

    // Consulta para actualizar el registro en la base de datos
    $sql_update = "UPDATE codigos_conceptos SET codigo = '$codigo', descripcion = '$descripcion' WHERE id = $codigo_id";

    if ($conn->query($sql_update) === TRUE) {
        // Redirigir al módulo de gestión de códigos después de actualizar
        header("Location: modulogestioncodigos.php");
    } else {
        echo "Error al actualizar el registro: " . $conn->$error_message;
    }

    $conn->close();
} else {
    // Si no se enviaron los datos del formulario, redirigir al módulo de gestión de códigos
    header("Location: modulogestioncodigos.php");
}
?>
