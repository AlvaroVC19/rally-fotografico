<?php
// Datos de conexión
$host = "localhost";       // O 127.0.0.1
$usuario = "root";         // Nombre de usuario por defecto en XAMPP/WAMP
$contrasena = "";          // Contraseña, normalmente vacía en local
$base_datos = "rally_fotografico";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Opcional: establecer codificación
$conn->set_charset("utf8mb4");
?>
