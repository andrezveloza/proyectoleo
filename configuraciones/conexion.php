<?php
$servername = "localhost";
$username = "id21097391_leo";
$password = "Leo2023.";
$dbname = "id21097391_sistema_contable_db";

// Establecer la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}
