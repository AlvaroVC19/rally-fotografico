<?php
// Datos de conexión
$host = "db";
$usuario = "root";
$contrasena = "root";
$base_datos = "rally_fotografico";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer codificación
$conn->set_charset("utf8mb4");

