<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
    exit();
}

require_once "../../../configuraciones/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];

    // Consultar si el código ya existe en la base de datos
    $sql_check = "SELECT id FROM codigos_conceptos WHERE codigo = '$codigo'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // El código ya existe, puedes mostrar un mensaje de error o redirigir a otra página
        header("Location: modulogestioncodigos.php?error=codigo_existente");
        exit();
    } else {
        // Insertar el nuevo código en la base de datos
        $sql_insert = "INSERT INTO codigos_conceptos (codigo, descripcion) VALUES ('$codigo', '$descripcion')";

        if ($conn->query($sql_insert) === TRUE) {
            // Redirigir al módulo de gestión de códigos con un mensaje de éxito
            header("Location: modulogestioncodigos.php?success=codigo_guardado");
            exit();
        } else {
            // Ocurrió un error al insertar el código en la base de datos
            header("Location: modulogestioncodigos.php?error=error_bd");
            exit();
        }
    }
}

$conn->close();
?>
