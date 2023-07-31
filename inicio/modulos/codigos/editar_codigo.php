<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha proporcionado un ID de registro para editar
if (isset($_GET["id"])) {
    $codigo_id = $_GET["id"];

    // Configuración de la conexión a la base de datos (puedes reutilizarla aquí)
    require_once "../../../configuraciones/conexion.php";
    

    // Obtener los datos del registro existente en la base de datos
    $sql_select = "SELECT codigo, descripcion FROM codigos_conceptos WHERE id = $codigo_id";
    $result_select = $conn->query($sql_select);

    if ($result_select->num_rows == 1) {
        $row = $result_select->fetch_assoc();
        $codigo = $row["codigo"];
        $descripcion = $row["descripcion"];
    } else {
        // Si el registro no existe, redirigir al módulo de gestión de códigos
        header("Location: modulogestioncodigos.php");
        exit();
    }

    $conn->close();
} else {
    // Si no se proporcionó un ID válido, redirigir al módulo de gestión de códigos
    header("Location: modulogestioncodigos.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Código de Concepto</title>
    <link rel="stylesheet" href="styles_modulo_gestion_codigos.css">
</head>
<body>
    <div class="form-container">
        <h2>Editar Código de Concepto</h2>
        <form action="actualizar_codigo.php" method="post">
            <input type="hidden" name="id" value="<?php echo $codigo_id; ?>">
            <label for="codigo">Código de concepto:</label>
            <input type="text" id="codigo" name="codigo" value="<?php echo $codigo; ?>" required>
            <br>
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>" required>
            <br>
            <input type="submit" value="Actualizar">
        </form>
    </div>

    <!-- Agregar botón para volver al módulo de gestión de códigos -->
    <div class="button-container">
        <a href="modulogestioncodigos.php"><button>Volver al Módulo de Gestión de Códigos</button></a>
    </div>
</body>
</html>
