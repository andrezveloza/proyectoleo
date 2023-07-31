<?php
// Archivo de conexión a la base de datos
require_once "../../../configuraciones/conexion.php";

// Consultar los ingresos de la base de datos
$sql_ingresos = "SELECT monto, fecha FROM ingresos";
$result_ingresos = $conn->query($sql_ingresos);

// Consultar los egresos de la base de datos
$sql_egresos = "SELECT cantidad, fecha FROM tabla_egresos";
$result_egresos = $conn->query($sql_egresos);

// Inicializar un array para almacenar los datos agrupados por mes
$datos_por_mes = array();

if ($result_ingresos->num_rows > 0) {
    // Procesar los ingresos y agruparlos por mes
    while ($row = $result_ingresos->fetch_assoc()) {
        $mes_anio = date("Y-m", strtotime($row["fecha"]));
        if (isset($datos_por_mes[$mes_anio])) {
            $datos_por_mes[$mes_anio]["ingresos"] += $row["monto"];
        } else {
            $datos_por_mes[$mes_anio] = array("ingresos" => $row["monto"], "egresos" => 0);
        }
    }
}

if ($result_egresos->num_rows > 0) {
    // Procesar los egresos y agruparlos por mes
    while ($row = $result_egresos->fetch_assoc()) {
        $mes_anio = date("Y-m", strtotime($row["fecha"]));
        if (isset($datos_por_mes[$mes_anio])) {
            $datos_por_mes[$mes_anio]["egresos"] += $row["cantidad"];
        } else {
            $datos_por_mes[$mes_anio] = array("ingresos" => 0, "egresos" => $row["cantidad"]);
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Módulo de Histogramas de Inversión</title>
    <link rel="stylesheet" href="styles_modulo_histogramas.css">
    <!-- Agrega los enlaces a las librerías de Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Crear una tabla de datos con los datos agrupados por mes
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Mes");
            data.addColumn("number", "Ingresos");
            data.addColumn("number", "Egresos");

            <?php
            // Recorrer el array de datos_por_mes y agregar los datos a la tabla
            foreach ($datos_por_mes as $mes_anio => $datos) {
                $mes = date("F Y", strtotime($mes_anio));
                echo "data.addRow(['$mes', {$datos['ingresos']}, {$datos['egresos']}]);";
            }
            ?>

            // Opciones del gráfico
            var options = {
                title: "Histograma de Ingresos y Egresos por Mes",
                hAxis: { title: "Mes" },
                vAxis: { title: "Monto" },
                legend: { position: "top" }
            };

            // Crear e dibujar el gráfico, pasando la tabla de datos y las opciones
            var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Bienvenido al Módulo de Histogramas de Inversión</h2>
        <p>Aquí podrás visualizar los ingresos y egresos agrupados por mes.</p>

        <div class="chart-box">
            <h3>Gráfico de Histograma</h3>
            <div id="chart_div"></div>
        </div>

        <div class="button-volver">
            <a href="../../../inicio/modulos.php">Volver al Menú Principal</a>
        </div>
    </div>
</body>
</html>
