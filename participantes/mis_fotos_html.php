<?php include '../includes/header.php';
require_once '../includes/db.php';

//session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login_html.php");
    exit;
}

$id_usuario = $_SESSION["id"];

$sql = "SELECT titulo, archivo, estado, fecha_subida FROM fotografias WHERE id_usuario = ? ORDER BY fecha_subida DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Fotos - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main class="form-container">
    <h2>Mis Fotografías</h2>
    <?php if ($resultado->num_rows > 0): ?>
        <?php while ($foto = $resultado->fetch_assoc()): ?>
            <div style="margin-bottom: 1.5rem; text-align:center;">
                <img src="../uploads/<?= htmlspecialchars($foto['archivo']) ?>" style="max-width: 100%; height: auto; border-radius: 8px;">
                <p><strong><?= htmlspecialchars($foto['titulo']) ?></strong> (<?= $foto['estado'] ?>)</p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No has subido ninguna fotografía todavía.</p>
    <?php endif; ?>
</main>
</body>
</html>
