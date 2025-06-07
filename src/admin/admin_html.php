<?php
session_start();

// Verifica si el usuario es administrador
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: /rally-fotografico/src/index.php");
    exit();
}

include '../includes/header.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main class="galeria-main" style="background-image: url('images/fondo.jpg');">
        <h2>Panel de Administrador</h2>

        <p>Bienvenido, <?= htmlspecialchars($_SESSION["nombre"] ?? "Admin") ?>. Desde aquí puedes gestionar el concurso.</p>

        <div style="margin-top: 2rem; text-align: center;">
            <button onclick="location.href='validar_fotos_html.php'" class="btn">✅ Validar Fotografías</button>
            <button onclick="location.href='usuarios_html.php'" class="btn">👥 Gestionar Usuarios</button>
            <button onclick="location.href='gestion_rally_html.php'" class="btn">⚙️ Gestión del Rally</button>
            <button onclick="location.href='estadisticas_html.php'" class="btn">📊 Ver Estadísticas</button>
        </div>
    </main>
</body>
</html>
