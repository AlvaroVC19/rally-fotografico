<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: /rally-fotografico/src/index.php");
    exit();
}

require_once '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: usuarios_html.php");
    exit();
}

$id = intval($_GET['id']);

// Evitar que admin se elimine a sí mismo
if ($_SESSION["id"] == $id) {
    header("Location: usuarios_html.php?error=autoeliminar");
    exit();
}

// Eliminar usuario
$stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: usuarios_html.php?msg=eliminado");
exit();
?>
