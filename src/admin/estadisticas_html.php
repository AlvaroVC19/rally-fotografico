<?php
session_start();
require_once '../includes/db.php';
include '../includes/header.php';

// Verifica si el usuario es administrador
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    die("Acceso denegado.");
}

// Filtros
$orden = $_GET["orden"] ?? "votos_desc";
$id_usuario = isset($_GET["usuario"]) ? intval($_GET["usuario"]) : null;

$order_clause = match($orden) {
    "votos_asc" => "votos ASC",
    default => "votos DESC"
};

$where_clause = "";
$params = [];
$types = "";

if ($id_usuario) {
    $where_clause = " AND f.id_usuario = ?";
    $params[] = $id_usuario;
    $types .= "i";
}

// Estadísticas globales
$participantes = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'participante'")->fetch_assoc()['total'];
$fotos_admitidas = $conn->query("SELECT COUNT(*) AS total FROM fotografias WHERE estado = 'admitida'")->fetch_assoc()['total'];
$votos = $conn->query("SELECT COUNT(*) AS total FROM votos")->fetch_assoc()['total'];

// Lista usuarios
$usuarios = $conn->query("SELECT id, nombre FROM usuarios ORDER BY nombre ASC");

// Consulta principal
$sql = "SELECT f.id, f.titulo, f.archivo, u.nombre, 
               (SELECT COUNT(*) FROM votos WHERE id_foto = f.id) AS votos
        FROM fotografias f
        JOIN usuarios u ON f.id_usuario = u.id
        WHERE f.estado = 'admitida' $where_clause
        ORDER BY $order_clause";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main class="estadisticas-main">
    <h2>📊 Estadísticas del Rally</h2>

    <div class="estadisticas-panel">
        <div class="estadistica">👥 Participantes: <strong><?= $participantes ?></strong></div>
        <div class="estadistica">📷 Fotos admitidas: <strong><?= $fotos_admitidas ?></strong></div>
        <div class="estadistica">🗳️ Votos registrados: <strong><?= $votos ?></strong></div>
    </div>

    <form method="GET" style="margin-bottom: 2rem; text-align: center;">
        <label for="usuario">Filtrar por usuario:</label>
        <select name="usuario" id="usuario" class="select-floral">
            <option value="">Todos</option>
            <?php while ($u = $usuarios->fetch_assoc()): ?>
                <option value="<?= $u['id'] ?>" <?= $id_usuario === $u['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($u['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="orden">Ordenar por votos:</label>
        <select name="orden" id="orden" class="select-floral">
            <option value="votos_desc" <?= $orden === "votos_desc" ? 'selected' : '' ?>>Más votadas</option>
            <option value="votos_asc" <?= $orden === "votos_asc" ? 'selected' : '' ?>>Menos votadas</option>
        </select>
    </form>

    <?php if ($resultado->num_rows > 0): ?>
        <div class="galeria-grid">
            <?php while ($foto = $resultado->fetch_assoc()): ?>
                <div class="foto-card">
                    <img src="../uploads/<?= htmlspecialchars($foto['archivo']) ?>" alt="Foto" class="foto-img">
                    <h3><?= htmlspecialchars($foto['titulo']) ?></h3>
                    <p>Autor: <?= htmlspecialchars($foto['nombre']) ?></p>
                    <p>Votos: <?= $foto['votos'] ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No hay fotografías que coincidan con los filtros seleccionados.</p>
    <?php endif; ?>
</main>

<!-- Refrescar al cambiar filtro -->
<script>
    document.querySelectorAll("form select").forEach(select => {
        select.addEventListener("change", () => {
            select.form.submit();
        });
    });
</script>
</body>
</html>
