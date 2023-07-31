<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
    exit();
}

// Configuración de la conexión a la base de datos (ajusta los valores a los de tu servidor)
require_once "../../../configuraciones/conexion.php";

// Procesar el formulario para registrar un nuevo contrato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_contrato = $_POST["nombre"];
    $descripcion_contrato = $_POST["descripcion"];

    // Preparar la consulta SQL para insertar el contrato en la base de datos
    $sql_insert = "INSERT INTO contratos (nombre, descripcion) VALUES ('$nombre_contrato', '$descripcion_contrato')";

    // Ejecutar la consulta SQL
    if ($conn->query($sql_insert) === TRUE) {
        // El contrato se ha registrado exitosamente en la base de datos
        // Puedes mostrar un mensaje de éxito o redirigir a otra página si lo deseas
        header("Location: modulocontratos.php");
        exit();
    } else {
        // Si ocurre un error al insertar el contrato, puedes mostrar un mensaje de error
        echo "Error al registrar el contrato: " . $conn->$error_message;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Módulo Contratos</title>
    <link rel="stylesheet" href="modulocontratos.css"> <!-- Vincula el archivo CSS -->
</head>
<body>
    <h2>Módulo Contratos</h2>
    <div class="contract-form">
        <p>Esta es la página del módulo de contratos.</p>

        <!-- Formulario para registrar un nuevo contrato -->
        <form method="post">
            <label for="nombre">Nombre del Contrato:</label>
            <input type="text" id="nombre" name="nombre" required>
            <br>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>
            <br>
            <button type="submit">Registrar Contrato</button>
        </form>
    </div>

    <!-- Tabla de contratos registrados -->
    <table class="contract-table">
        <tr>
            <th>Nombre del Contrato</th>
            <th>Descripción</th>
            <th>Ver Contrato (PDF)</th>
        </tr>
        <?php
        // Consultar los contratos existentes en la base de datos
        $sql_select = "SELECT id, nombre, descripcion FROM contratos";
        $result_select = $conn->query($sql_select);

        if ($result_select->num_rows > 0) {
            // Mostrar los contratos en la tabla
            while ($row = $result_select->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["nombre"] . '</td>';
                echo '<td>' . $row["descripcion"] . '</td>';
                echo '<td><a href="contratos_pdf/contrato_' . $row["id"] . '.pdf" target="_blank">Ver Contrato (PDF)</a></td>';
                echo '</tr>';
            }
        } else {
            // Si no hay contratos registrados, puedes mostrar una fila vacía
            echo '<tr><td colspan="3">No hay contratos registrados.</td></tr>';
        }
        ?>
    </table>

    <!-- Botón para volver al menú principal -->
    <div class="back-button">
        <a href="../../../inicio/modulos.php">Volver al Menú Principal</a>
    </div>
</body>
</html>
