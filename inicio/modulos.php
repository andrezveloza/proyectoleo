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
    <title>Módulos del Sistema Contable</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #007bff;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        p {
            text-align: center;
            margin-bottom: 20px;
        }

        ul {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        li {
            margin: 10px;
            text-align: center;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .module-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Bienvenido, <?php echo $nombre_usuario; ?>!</h2>
    <p>Esta es la página de módulos del sistema contable.</p>
    <ul>
        <li class="module-container">
            <img src="images\modulocodigos.jpg" alt="Módulo de Gestión de Códigos">
            <br>
            <a href="../inicio/modulos/codigos/modulogestioncodigos.php"><button>Módulo de Gestión de Códigos</button></a>
        </li>
        <li class="module-container">
            <img src="images/modulocontratos.jpg" alt="Módulo de Contratos">
            <br>
            <!-- Agrega enlaces y botones para otros módulos -->
            <a href="../inicio/modulos/contratos/modulocontratos.php"><button>Módulo de Contratos</button></a>
        <li class="module-container">
        
            <img src="images/moduloinventarios.jpg" alt="Módulo de Inventarios">
            <br>
            <a href="../inicio/modulos/inventarios/moduloinventarios.php"><button>Módulo de Inventarios</button></a>
        </li>
        <li class="module-container">
            <img src="images/moduloingresosyegresos.jpg" alt="Módulo de Ingresos y Egresos">
            <br>
            <!-- Agrega enlaces y botones para otros módulos -->
            <a href="../inicio/modulos/ingresos/modulingresos.php"><button>Módulo de Ingresos</button></a>
        </li>
        <li class="module-container">
            <img src="images/moduloingresosyegresos.jpg" alt="Módulo de Ingresos y Egresos">
            <br>
            <!-- Agrega enlaces y botones para otros módulos -->
            <a href="../inicio/modulos/egresos/modulogestionegresos.php"><button>Módulo de egresos</button></a>
        </li>
        <li class="module-container">
            <img src="images/modulograficos.jpg" alt="Módulo de Gráficos">
            <br>
            <!-- Agrega enlaces y botones para otros módulos -->
            
            <a href="../inicio/modulos/histogramas/modulogestionhistogramas.php"><button>Módulo de graficos</button></a>
        </li>
        <li class="module-container">
            <img src="images/cerrarsesion.jpg" alt="Cerrar Sesión">
            <br>
            <a href="logout.php"><button>Cerrar Sesión</button></a>
        </li>
        <!-- Agrega más módulos aquí -->
    </ul>
</body>
<p><a href="../configuraciones/logout.php">Cerrar sesión</a></p>
</html>
