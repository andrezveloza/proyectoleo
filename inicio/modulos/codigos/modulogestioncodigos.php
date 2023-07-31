<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
    exit();
}

// Obtener el nombre de usuario desde la sesión
$nombre_usuario = $_SESSION["nombre_usuario"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Módulo de Gestión de Códigos</title>
    <link rel="stylesheet" href="styles_modulo_gestion_codigos.css"> <!-- Enlaza el archivo CSS específico para este módulo -->
</head>
<body>
    <div class="container">
        <h2>Registro Catálogo Conceptos Ingresos - Bienvenido, <?php echo $nombre_usuario; ?>!</h2>
        <form class="form-container" action="guardar_codigo.php" method="post">
            <label for="codigo">Código de concepto:</label>
            <input type="text" id="codigo" name="codigo" required>
            <br>
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" required>
            <br>
            <input type="submit" value="Guardar">
        </form>

        <!-- Mostrar mensaje de error si existe el parámetro "error" en la URL -->
        <?php
        if (isset($_GET["error"]) && $_GET["error"] === "codigo_existente") {
            echo '<p class="error-message">El código ingresado ya existe. Por favor, intenta con otro código.</p>';
        }
        ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código de Concepto</th>
                        <th>Descripción</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                  require_once "../../../configuraciones/conexion.php";
                

                    // Consultar los códigos existentes en la base de datos
                    $sql_select = "SELECT id, codigo, descripcion FROM codigos_conceptos";
                    $result_select = $conn->query($sql_select);

                    if ($result_select->num_rows > 0) {
                        // Mostrar los datos en la tabla
                        while ($row = $result_select->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["codigo"] . "</td>";
                            echo "<td>" . $row["descripcion"] . "</td>";
                            echo "<td><a href=\"editar_codigo.php?id=" . $row["id"] . "\">Editar</a></td>";
                            echo "<td><a href=\"eliminar_codigo.php?id=" . $row["id"] . "\">Eliminar</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        // Si no hay códigos, puedes mostrar un mensaje o una fila vacía en la tabla
                        echo "<tr><td colspan='5'>No hay códigos registrados.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="button-volver">
    <a href="../../../inicio/modulos.php">Volver al Menú Principal</a>
</div>
    
   
