<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
    exit();
}

// Obtener el nombre de usuario desde la sesión
$nombre_usuario = $_SESSION["nombre_usuario"];

// Archivo de conexión a la base de datos
require_once "../../../configuraciones/conexion.php";

// Obtener la lista de códigos concepto para mostrar en el formulario
$sql_codigos = "SELECT codigo FROM codigos_conceptos";
$result_codigos = $conn->query($sql_codigos);

$codigos_conceptos = array();
while ($row = $result_codigos->fetch_assoc()) {
    $codigos_conceptos[] = $row["codigo"];
}

// Procesar el formulario de registro de egreso
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $banco = $_POST["banco"];
    $numero_cuenta = $_POST["numero_cuenta"];
    $cantidad = $_POST["cantidad"];
    $fecha = $_POST["fecha"];
    $codigo_concepto = $_POST["codigo_concepto"];

    // Realiza la inserción del egreso en la base de datos
    $sql_insert_egreso = "INSERT INTO tabla_egresos (banco, numero_cuenta, cantidad, fecha, codigo_concepto) 
                         VALUES ('$banco', '$numero_cuenta', '$cantidad', '$fecha', '$codigo_concepto')";

    if ($conn->query($sql_insert_egreso) === TRUE) {
        // Redireccionar a esta misma página para mostrar el mensaje de éxito
        header("Location: modulogestionegresos.php?success=1");
        exit();
    } else {
        // Redireccionar a esta misma página con mensaje de error si hay un problema
        header("Location: modulogestionegresos.php?error=1");
        exit();
    }
}

// Consultar los registros de la tabla de egresos
$sql_select_egresos = "SELECT id, banco, numero_cuenta, cantidad, fecha, codigo_concepto FROM tabla_egresos";
$result_egresos = $conn->query($sql_select_egresos);

$registros_egresos = array();
if ($result_egresos->num_rows > 0) {
    while ($row = $result_egresos->fetch_assoc()) {
        $registros_egresos[] = $row;
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Módulo de Gestión de Egresos</title>
    <link rel="stylesheet" href="styles_modulo_gestion_egresos.css"> <!-- Enlaza el archivo CSS específico para este módulo -->
</head>
<body>
    <div class="container">
        <h2>Registro de Egresos - Bienvenido, <?php echo $nombre_usuario; ?>!</h2>
        <form class="form-container" action="modulogestionegresos.php" method="post">
            <label for="banco">Banco:</label>
            <input type="text" id="banco" name="banco" required>
            <br>
            <label for="numero_cuenta">Número de Cuenta:</label>
            <input type="text" id="numero_cuenta" name="numero_cuenta" required>
            <br>
            <label for="cantidad">Cantidad:</label>
            <input type="number" step="0.01" id="cantidad" name="cantidad" required>
            <br>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>
            <br>
            <label for="codigo_concepto">Código de Concepto:</label>
            <select id="codigo_concepto" name="codigo_concepto" required>
                <?php
                // Mostrar las opciones de códigos concepto disponibles
                foreach ($codigos_conceptos as $codigo) {
                    echo "<option value=\"$codigo\">$codigo</option>";
                }
                ?>
            </select>
            <br>
            <input type="submit" value="Guardar">
        </form>

        <!-- Mostrar mensaje de éxito si el registro fue exitoso -->
        <?php
        if (isset($_GET["success"]) && $_GET["success"] === "1") {
            echo '<p class="success-message">Egreso registrado exitosamente.</p>';
        }

        // Mostrar mensaje de error si hubo un problema en el registro
        if (isset($_GET["error"]) && $_GET["error"] === "1") {
            echo '<p class="error-message">Hubo un problema al registrar el egreso. Por favor, intenta nuevamente.</p>';
        }
        ?>

        <!-- Aquí puedes mostrar la tabla de egresos si tienes información en la base de datos -->
        <!-- Puedes seguir el mismo enfoque que se utilizó para mostrar los códigos de concepto en el módulo de gestión de códigos -->
        <!-- Recuerda que deberías tener una tabla llamada "egresos" en la base de datos con las columnas mencionadas -->
        
        <div class="button-volver">
            <a href="../../../inicio/modulos.php">Volver al Menú Principal</a>
        </div>
    </div>
</body>
<!-- Mostrar tabla de egresos -->
<h2>Registros de Egresos</h2>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Banco</th>
                <th>Número de Cuenta</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Código de Concepto</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($registros_egresos)) {
                foreach ($registros_egresos as $registro) {
                    echo "<tr>";
                    echo "<td>" . $registro["id"] . "</td>";
                    echo "<td>" . $registro["banco"] . "</td>";
                    echo "<td>" . $registro["numero_cuenta"] . "</td>";
                    echo "<td>" . $registro["cantidad"] . "</td>";
                    echo "<td>" . $registro["fecha"] . "</td>";
                    echo "<td>" . $registro["codigo_concepto"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay registros de egresos.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</html>
