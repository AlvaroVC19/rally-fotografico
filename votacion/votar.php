<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_foto'])) {
    $id_foto = intval($_POST['id_foto']);
    $ip = $_SERVER['REMOTE_ADDR'];
    $id_votante = $_SESSION["id"] ?? null;

    // Validar fechas de votación
    $config = $conn->query("SELECT fecha_inicio_votacion, fecha_fin_votacion FROM configuracion WHERE id = 1")->fetch_assoc();
    $inicio_votacion = $config['fecha_inicio_votacion'];
    $fin_votacion = $config['fecha_fin_votacion'];
    $ahora = date('Y-m-d H:i:s');

    if ($ahora < $inicio_votacion || $ahora > $fin_votacion) {
        header("Location: galeria_html.php?voto=fuera_fecha");
        exit;
    }

    // Obtener autor de la foto
    $stmt = $conn->prepare("SELECT id_usuario FROM fotografias WHERE id = ?");
    $stmt->bind_param("i", $id_foto);
    $stmt->execute();
    $stmt->bind_result($id_autor);
    $stmt->fetch();
    $stmt->close();

    if ($id_votante !== null && intval($id_votante) === intval($id_autor)) {
        header("Location: galeria_html.php?voto=autovoto");
        exit;
    }

    // Verificar si ya votó desde esta IP
    $stmt = $conn->prepare("SELECT id FROM votos WHERE id_foto = ? AND ip_usuario = ?");
    $stmt->bind_param("is", $id_foto, $ip);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: galeria_html.php?voto=duplicado");
        exit;
    }

    // Registrar voto
    $stmt = $conn->prepare("INSERT INTO votos (id_foto, ip_usuario) VALUES (?, ?)");
    $stmt->bind_param("is", $id_foto, $ip);
    if ($stmt->execute()) {
        header("Location: galeria_html.php?voto=ok");
        exit;
    } else {
        header("Location: galeria_html.php?voto=error");
        exit;
    }
}
