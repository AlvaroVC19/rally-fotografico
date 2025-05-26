<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
    <?php include '../includes/header.php'; ?>

</head>
<body>
    <main class="form-container">
        <h2>Iniciar sesión</h2>

        <form action="login.php" method="POST">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Entrar">
        </form>

        <p><a href="registro.html">¿No tienes cuenta? Regístrate aquí</a></p>
    </main>
</body>
</html>
