<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION["id"])) {
    header("Location: ../participantes/login_html.php");
    exit;
}

$id_usuario = $_SESSION["id"];
$id_foto = $_GET['id'] ?? null;

if (!$id_foto) {
    echo "ID de foto no especificado.";
    exit;
}

// Obtener datos de la foto
$sql = "SELECT * FROM fotografias WHERE id = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_foto, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Foto no encontrada o no tienes permiso.";
    exit;
}

$foto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Foto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main class="form-container">
    <h2>Editar Fotografía</h2>
    <form action="editar_foto.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $foto['id'] ?>">

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($foto['titulo']) ?>" required>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" value="<?= htmlspecialchars($foto['descripcion']) ?>" required>

        <label for="archivo">Nueva imagen (opcional):</label>
        <input type="file" name="archivo" accept="image/*">

        <input type="submit" value="Guardar cambios">
    </form>
    <p><a href="perfil_html.php">Volver</a></p>
</main>
</body>
</html>
