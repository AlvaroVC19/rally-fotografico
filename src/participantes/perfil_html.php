<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi perfil - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main class="form-container">
        <h2>Bienvenido, <?= htmlspecialchars($_SESSION["nombre"] ?? "Participante") ?></h2>

        <p>Aquí podrás gestionar tu participación en el Rally Fotográfico de Flores.</p>

        <div style="margin-top: 2rem; text-align: center;">
            <a href="subir_foto_html.php" class="btn">📷 Subir nueva fotografía</a>
            <a href="mis_fotos_html.php" class="btn">🖼️ Ver mis fotos</a>
        </div>
    </main>
</body>
</html>
