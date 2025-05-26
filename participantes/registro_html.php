<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
    <?php include '../includes/header.php'; ?>
</head>
<body>
    <main class="form-container">
        <h2>Registro de Participante</h2>
        <form action="registro.php" method="POST">
            <label for="nombre">Nombre completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required minlength="6">

            <label for="confirmar">Confirmar contraseña:</label>
            <input type="password" id="confirmar" name="confirmar" required minlength="6">

            <input type="submit" value="Registrarse">
        </form>
        <p><a href="login.html">¿Ya tienes cuenta? Inicia sesión</a></p>
    </main>
</body>
</html>
