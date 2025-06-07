<?php
session_start();

// Verificar que sea admin
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: /rally-fotografico/src/index.php");
    exit();
}

require_once '../includes/db.php';

// Función para convertir formato datetime-local a MySQL DATETIME
function formatearFechaMySQL($fecha_iso) {
    return str_replace('T', ' ', $fecha_iso) . ":00";
}

// Recoger y validar datos POST
$max_fotos = intval($_POST['max_fotos_por_participante'] ?? 0);
$inicio_subida = formatearFechaMySQL($_POST['fecha_inicio_subida'] ?? '');
$fin_subida = formatearFechaMySQL($_POST['fecha_fin_subida'] ?? '');
$inicio_votacion = formatearFechaMySQL($_POST['fecha_inicio_votacion'] ?? '');
$fin_votacion = formatearFechaMySQL($_POST['fecha_fin_votacion'] ?? '');

if ($max_fotos < 1 || !$inicio_subida || !$fin_subida || !$inicio_votacion || !$fin_votacion) {
    die("Datos incompletos o incorrectos.");
}

// Preparar y ejecutar actualización
$stmt = $conn->prepare("UPDATE configuracion SET max_fotos_por_participante = ?, fecha_inicio_subida = ?, fecha_fin_subida = ?, fecha_inicio_votacion = ?, fecha_fin_votacion = ? WHERE id = 1");
$stmt->bind_param("issss", $max_fotos, $inicio_subida, $fin_subida, $inicio_votacion, $fin_votacion);

if ($stmt->execute()) {
    header("Location: gestion_rally_html.php?ok=1");
} else {
    die("Error al actualizar configuración.");
}
