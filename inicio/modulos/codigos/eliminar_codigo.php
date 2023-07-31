<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha proporcionado un ID de registro para eliminar
if (isset($_GET["id"])) {
    $codigo_id = $_GET["id"];

    // Configuración de la conexión a la base de datos (puedes reutilizarla aquí)
    require_once "../../../configuraciones/conexion.php";
    

    // Consulta para eliminar el registro por ID
    $sql_delete = "DELETE FROM codigos_conceptos WHERE id = $codigo_id";

    if ($conn->query($sql_delete) === TRUE) {
        // Redirigir al módulo de gestión de códigos después de eliminar
        header("Location: modulogestioncodigos.php");
    } else {
        echo "Error al eliminar el registro: " . $conn->$error_message;
    }

    $conn->close();
} else {
    // Si no se proporcionó un ID válido, redirigir al módulo de gestión de códigos
    header("Location: modulogestioncodigos.php");
}
?>
