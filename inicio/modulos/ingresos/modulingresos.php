<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
    exit();
}

// Configuración de la conexión a la base de datos (ajusta los valores a los de tu servidor)
require_once "../../../configuraciones/conexion.php";

// Procesar el formulario para registrar un nuevo ingreso
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $monto = $_POST["monto"];
    $codigo_ministerio = $_POST["codigo_ministerio"];
    $banco = $_POST["banco"];
    $fecha = $_POST["fecha"];
    $opiniones = $_POST["opiniones"];

    // Preparar la consulta SQL para insertar el ingreso en la base de datos
    $sql_insert = "INSERT INTO ingresos (monto, codigo_ministerio, banco, fecha, opiniones) 
                   VALUES ('$monto', '$codigo_ministerio', '$banco', '$fecha', '$opiniones')";

    // Ejecutar la consulta SQL
    if ($conn->query($sql_insert) === TRUE) {
        // El ingreso se ha registrado exitosamente en la base de datos
        // Puedes mostrar un mensaje de éxito o redirigir a otra página si lo deseas
        header("Location: modulingresos.php");
        exit();
    } else {
        // Si ocurre un error al insertar el ingreso, puedes mostrar un mensaje de error
        echo "Error al registrar el ingreso: " . $conn->$error_message;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Módulo Registro de Ingresos</title>
    <link rel="stylesheet" href="ingresos.css">
</head>
<body>
    <div class="container">
        <h2>Módulo Registro de Ingresos</h2>
        <div class="register-box">
            <p>Registrar nuevo ingreso:</p>

            <!-- Formulario para registrar un nuevo ingreso -->
            <form class="contract-form" method="post">
                <label for="monto">Monto:</label>
                <input type="number" id="monto" name="monto" step="0.01" required>
                <br>
                <label for="codigo_ministerio">Código del Ministerio de Educación:</label>
                <input type="text" id="codigo_ministerio" name="codigo_ministerio" required>
                <br>
                <label for="banco">Banco:</label>
                <input type="text" id="banco" name="banco">
                <br>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
                <br>
                <label for="opiniones">Opiniones:</label>
                <textarea id="opiniones" name="opiniones"></textarea>
                <br>
                <button type="submit">Registrar Ingreso</button>
            </form>
            <!-- Tabla de ingresos registrados -->
<h2>Ingresos Registrados</h2>
<div class="table-container">
    <table class="income-list">
        <tr>
            <th>Monto</th>
            <th>Código del Ministerio de Educación</th>
            <th>Banco</th>
            <th>Fecha</th>
            <th>Opiniones</th>
        </tr>
        <?php
        // Consultar los ingresos existentes en la base de datos
        $sql_select = "SELECT monto, codigo_ministerio, banco, fecha, opiniones FROM ingresos";
        $result_select = $conn->query($sql_select);

        if ($result_select === false) {
            // Si ocurre un error en la consulta, puedes mostrar un mensaje o una tabla vacía
            echo '<tr><td colspan="5">Error al consultar los ingresos.</td></tr>';
        } else {
            // Verificar si hay resultados en la consulta
            if ($result_select->num_rows > 0) {
                // Mostrar los ingresos en la tabla
                while ($row = $result_select->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["monto"] . '</td>';
                    echo '<td>' . $row["codigo_ministerio"] . '</td>';
                    echo '<td>' . $row["banco"] . '</td>';
                    echo '<td>' . $row["fecha"] . '</td>';
                    echo '<td>' . $row["opiniones"] . '</td>';
                    echo '</tr>';
                }
            } else {
                // Si no hay ingresos registrados, puedes mostrar una fila vacía
                echo '<tr><td colspan="5">No hay ingresos registrados.</td></tr>';
            }
        }
        ?>
    </table>
</div>

<div class="button-wrapper">

        <a href="../../../inicio/modulos.php" class="back-button">Volver al Menú Principal</a>
</div>
</body>
</html>
