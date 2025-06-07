<?php
session_start();
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: /rally-fotografico/src/index.php");
    exit();
}

include '../includes/header.php';
require_once '../includes/db.php';

// Obtener configuración actual
$config = $conn->query("SELECT * FROM configuracion WHERE id = 1")->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Gestión del Rally - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<main class="galeria-main" style="padding: 1rem; background-image: url('images/fondo.jpg'); max-width: 600px; margin: auto;">

    <h2>Gestión del Rally</h2>

    <?php if (isset($_GET['ok'])): ?>
        <p style="color: green; font-weight: bold;">Configuración actualizada correctamente.</p>
    <?php endif; ?>

    <form action="gestion_rally.php" method="POST" class="form-container">
        <label for="max_fotos_por_participante">Máximo fotos por participante:</label>
        <input type="number" id="max_fotos_por_participante" name="max_fotos_por_participante" min="1" required
               value="<?= htmlspecialchars($config['max_fotos_por_participante'] ?? 3) ?>">

        <label for="fecha_inicio_subida">Fecha inicio subida:</label>
        <input type="datetime-local" id="fecha_inicio_subida" name="fecha_inicio_subida" required
               value="<?= date('Y-m-d\TH:i', strtotime($config['fecha_inicio_subida'])) ?>">

        <label for="fecha_fin_subida">Fecha fin subida:</label>
        <input type="datetime-local" id="fecha_fin_subida" name="fecha_fin_subida" required
               value="<?= date('Y-m-d\TH:i', strtotime($config['fecha_fin_subida'])) ?>">

        <label for="fecha_inicio_votacion">Fecha inicio votación:</label>
        <input type="datetime-local" id="fecha_inicio_votacion" name="fecha_inicio_votacion" required
               value="<?= date('Y-m-d\TH:i', strtotime($config['fecha_inicio_votacion'])) ?>">

        <label for="fecha_fin_votacion">Fecha fin votación:</label>
        <input type="datetime-local" id="fecha_fin_votacion" name="fecha_fin_votacion" required
               value="<?= date('Y-m-d\TH:i', strtotime($config['fecha_fin_votacion'])) ?>">

        <input type="submit" value="Guardar Cambios">
    </form>

</main>
</body>
</html>
