<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
    exit();
}

// Configuración de la conexión a la base de datos (ajusta los valores a los de tu servidor)
require_once "../../../configuraciones/conexion.php";
    

// Procesar el formulario para registrar un nuevo activo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_activo = $_POST["id"];
    $nombre_activo = $_POST["nombre"];
    $fecha_adquisicion = $_POST["fecha_adquisicion"];
    $marca_activo = $_POST["marca"];
    $cantidad_unidades = $_POST["cantidad_unidades"];
    $sede_ubicacion = $_POST["sede_ubicacion"];

    // Preparar la consulta SQL para insertar el activo en la base de datos
    $sql_insert = "INSERT INTO inventarios (id, nombre, fecha_adquisision, marca, cantidad, sede) 
                   VALUES ('$id_activo', '$nombre_activo', '$fecha_adquisicion', '$marca_activo', '$cantidad_unidades', '$sede_ubicacion')";

    // Ejecutar la consulta SQL
    if ($conn->query($sql_insert) === TRUE) {
        // El activo se ha registrado exitosamente en la base de datos
        // Puedes mostrar un mensaje de éxito o redirigir a otra página si lo deseas
        header("Location: moduloinventarios.php");
        exit();
    } else {
        // Si ocurre un error al insertar el activo, puedes mostrar un mensaje de error
        echo "Error al registrar el activo: " . $conn->$error_message;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Módulo Registro y Visualización del Inventario</title>
    <link rel="stylesheet" href="stylesinventarios.css">
</head>
<body>
    <div class="container">
        <h2>Módulo Registro y Visualización del Inventario</h2>
        <div class="register-box">
            <p>Registrar nuevo activo en el inventario:</p>

            <!-- Formulario para registrar un nuevo activo -->
            <form class="contract-form" method="post">
                <label for="id">Id:</label>
                <input type="text" id="id" name="id" required>
                <br>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <br>
                <label for="fecha_adquisicion">Fecha de Adquisición:</label>
                <input type="date" id="fecha_adquisicion" name="fecha_adquisicion" required>
                <br>
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" required>
                <br>
                <label for="cantidad_unidades">Cantidad de Unidades:</label>
                <input type="number" id="cantidad_unidades" name="cantidad_unidades" required>
                <br>
                <label for="sede_ubicacion">Sede de Ubicación:</label>
                <input type="text" id="sede_ubicacion" name="sede_ubicacion" required>
                <br>
                <button type="submit">Registrar Activo</button>
            </form>
        </div>

        <!-- Tabla de activos registrados -->
        <div class="table-container">
            <table class="contract-list">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Fecha de Adquisición</th>
                    <th>Marca</th>
                    <th>Cantidad de Unidades</th>
                    <th>Sede de Ubicación</th>
                </tr>
                <?php
                // Consultar los activos existentes en la base de datos
                $sql_select = "SELECT id, nombre, fecha_adquisision, marca, cantidad, sede FROM inventarios";
                $result_select = $conn->query($sql_select);

                if ($result_select === false) {
                    // Si ocurre un error en la consulta, puedes mostrar un mensaje o una tabla vacía
                    echo '<tr><td colspan="6">Error al consultar los activos.</td></tr>';
                } else {
                    // Verificar si hay resultados en la consulta
                    if ($result_select->num_rows > 0) {
                        // Mostrar los activos en la tabla
                        while ($row = $result_select->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["id"] . '</td>';
                            echo '<td>' . $row["nombre"] . '</td>';
                            echo '<td>' . $row["fecha_adquisision"] . '</td>';
                            echo '<td>' . $row["marca"] . '</td>';
                            echo '<td>' . $row["cantidad"] . '</td>';
                            echo '<td>' . $row["sede"] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        // Si no hay activos registrados, puedes mostrar una fila vacía
                        echo '<tr><td colspan="6">No hay activos registrados.</td></tr>';
                    }
                }
                ?>
            </table>
        </div>

        <!-- Botón para volver al menú principal -->
        <a href="../../../inicio/modulos.php" class="back-button">Volver al Menú Principal</a>
    </div>
</body>
</html>
