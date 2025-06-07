<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION["id"])) {
    header("Location: login_html.php");
    exit;
}

$id_usuario = $_SESSION["id"];
$titulo = trim($_POST["titulo"]);
$descripcion = trim($_POST["descripcion"] ?? "");

// 1. Obtener configuración
$config = $conn->query("SELECT * FROM configuracion WHERE id = 1")->fetch_assoc();
$limite_fotos = intval($config['max_fotos_por_participante']);
$inicio_subida = $config['fecha_inicio_subida'];
$fin_subida = $config['fecha_fin_subida'];
$ahora = date('Y-m-d H:i:s');


// 2. Verificar fechas de subida
if ($ahora < $inicio_subida || $ahora > $fin_subida) {
    header("Location: subir_foto_html.php?error=fuera_fecha");
    exit;
}

// 3. Contar fotos del usuario
$stmt = $conn->prepare("SELECT COUNT(*) FROM fotografias WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$stmt->bind_result($total_subidas);
$stmt->fetch();
$stmt->close();

if ($total_subidas >= $limite_fotos) {
    header("Location: subir_foto_html.php?error=limite");
    exit;
}

// 4. Procesar imagen
if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] === 0) {
    $archivo_tmp = $_FILES["archivo"]["tmp_name"];
    $nombre_original = basename($_FILES["archivo"]["name"]);
    $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));

    $permitidos = ["jpg", "jpeg", "png"];
    if (!in_array($extension, $permitidos)) {
        die("Formato no permitido.");
    }

    if ($_FILES["archivo"]["size"] > 3 * 1024 * 1024) {
        die("Archivo demasiado grande.");
    }

    $nombre_archivo = uniqid() . "." . $extension;
    $ruta = "../uploads/" . $nombre_archivo;

    if (move_uploaded_file($archivo_tmp, $ruta)) {
        $stmt = $conn->prepare("INSERT INTO fotografias (id_usuario, titulo, descripcion, archivo, estado)
                                VALUES (?, ?, ?, ?, 'pendiente')");
        $stmt->bind_param("isss", $id_usuario, $titulo, $descripcion, $nombre_archivo);
        $stmt->execute();

        header("Location: mis_fotos_html.php?ok=1");
        exit;
    } else {
        die("Error al guardar la imagen.");
    }
} else {
    die("No se ha enviado ningún archivo.");
}

