<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION["id"])) {
    header("Location: ../participantes/login_html.php");
    exit;
}

$id_usuario = $_SESSION["id"];
$id_foto = $_POST['id'] ?? null;

if (!$id_foto) {
    header("Location: perfil_html.php?borrado=error");
    exit;
}

// Obtener la foto para verificar propietario y eliminar archivo
$sql = "SELECT archivo FROM fotografias WHERE id = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_foto, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: perfil_html.php?borrado=error");
    exit;
}

$foto = $result->fetch_assoc();
$archivo = $foto['archivo'];
$rutaArchivo = "../uploads/" . $archivo;

// Borrar registro de la base de datos
$sql = "DELETE FROM fotografias WHERE id = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_foto, $id_usuario);
$stmt->execute();

// Borrar archivo físico si existe
if (file_exists($rutaArchivo)) {
    unlink($rutaArchivo);
}

header("Location: perfil_html.php?borrado=ok");
exit;
