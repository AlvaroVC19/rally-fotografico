<?php
session_start();
require_once '../includes/db.php';

$esEdicion = isset($_SESSION["id"]);
$nombre = "";
$email = "";

if ($esEdicion) {
    // Cargar datos actuales del usuario
    $id_usuario = $_SESSION["id"];
    $sql = "SELECT nombre, email FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $nombre = $usuario['nombre'];
        $email = $usuario['email'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $esEdicion ? "Editar Datos" : "Registro" ?> - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main class="form-container">
    <h2><?= $esEdicion ? "Editar Datos de Usuario" : "Registro de Participante" ?></h2>
    
    <form action="registro.php" method="POST">
        <label for="nombre">Nombre completo:</label>
        <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($nombre) ?>">

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email) ?>">

        <label for="password"><?= $esEdicion ? "Nueva contraseña (dejar vacío para no cambiarla):" : "Contraseña:" ?></label>
        <input type="password" id="password" name="password" <?= $esEdicion ? "" : "required" ?> minlength="6">

        <label for="confirmar"><?= $esEdicion ? "Confirmar nueva contraseña:" : "Confirmar contraseña:" ?></label>
        <input type="password" id="confirmar" name="confirmar" <?= $esEdicion ? "" : "required" ?> minlength="6">

        <input type="submit" value="<?= $esEdicion ? "Guardar cambios" : "Registrarse" ?>">

        <!-- Botón Cancelar -->
        <a href="<?= $esEdicion ? 'perfil_html.php' : '../index.php' ?>">
            <button type="button" style="margin-top: 1rem;">Cancelar</button>
        </a>
    </form>

    <?php if (!$esEdicion): ?>
        <p><a href="login_html.php">¿Ya tienes cuenta? Inicia sesión</a></p>
    <?php endif; ?>
</main>
</body>
</html>
