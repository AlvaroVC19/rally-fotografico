<?php
session_start();
require_once '../includes/db.php';

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT id, nombre, password, rol FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario["password"])) {
            $_SESSION["id"] = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["rol"] = $usuario["rol"];

            // Redirigir antes de enviar cualquier HTML
            if ($usuario["rol"] === "admin") {
                header("Location: ../admin/admin_html.php");
            } else {
                header("Location: perfil_html.php");
            }
            exit;
        } else {
            $error = "Usuario/Contraseña incorrectos.";
        }
    } else {
        $error = "Usuario/Contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main class="form-container">
    <h2>Iniciar sesión</h2>

    <?php if ($error): ?>
        <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Entrar">
    </form>

    <p><a href="registro_html.php">¿No tienes cuenta? Regístrate aquí</a></p>
</main>
</body>
</html>
