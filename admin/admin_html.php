<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main class="form-container">
        <h2>Panel de Administrador</h2>

        <p>Bienvenido, <?= htmlspecialchars($_SESSION["nombre"] ?? "Admin") ?>. Desde aquí puedes gestionar el concurso.</p>

        <div style="margin-top: 2rem; text-align: center;">
            <a href="validar_fotos_html.php" class="btn">✅ Validar Fotografías</a>
            <a href="usuarios_html.php" class="btn">👥 Gestionar Usuarios</a>
            <a href="estadisticas_html.php" class="btn">📊 Ver Estadísticas</a>
        </div>
    </main>
</body>
</html>
