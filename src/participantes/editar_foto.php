<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION["id"])) {
    header("Location: ../participantes/login_html.php");
    exit;
}

$id_usuario = $_SESSION["id"];
$id_foto = $_POST['id'] ?? null;
$titulo = trim($_POST['titulo']);
$descripcion = trim($_POST['descripcion']);

if (!$id_foto || !$titulo || !$descripcion) {
    echo "Faltan datos obligatorios.";
    exit;
}

// Comprobar si el usuario es dueño de la foto
$sql = "SELECT archivo FROM fotografias WHERE id = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_foto, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Foto no encontrada o no tienes permiso.";
    exit;
}

$foto = $result->fetch_assoc();
$archivo_actual = $foto['archivo'];

// Procesar nuevo archivo si se subió
if (!empty($_FILES['archivo']['name'])) {
    $nombreArchivo = basename($_FILES['archivo']['name']);
    $rutaSubida = '../uploads/' . $nombreArchivo;

    // Limitar tamaño (ej. 2MB)
    if ($_FILES['archivo']['size'] > 2 * 1024 * 1024) {
        echo "El archivo excede el tamaño máximo de 2MB.";
        exit;
    }

    // Solo permitir imágenes
    $tipo = mime_content_type($_FILES['archivo']['tmp_name']);
    if (!str_starts_with($tipo, "image/")) {
        echo "Solo se permiten archivos de imagen.";
        exit;
    }

    // Mover nuevo archivo
    move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaSubida);
    $archivo_actual = $nombreArchivo;
}

// Actualizar en base de datos
$sql = "UPDATE fotografias SET titulo = ?, descripcion = ?, archivo = ? WHERE id = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssii", $titulo, $descripcion, $archivo_actual, $id_foto, $id_usuario);

if ($stmt->execute()) {
    header("Location: perfil_html.php");
} else {
    echo "Error al actualizar la foto.";
}
