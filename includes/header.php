<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="main-header">
    <div class="container">
        <h1><a href="/rally-fotografico/index_html.php">🌸 Rally de Flores</a></h1>
        <nav>
            <ul>
                <?php if (isset($_SESSION["id"])): ?>
                    <li><a href="/rally-fotografico/participantes/perfil_html.php">👤 <?= htmlspecialchars($_SESSION["nombre"]) ?></a></li>
                    <li><a href="/rally-fotografico/participantes/logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="/rally-fotografico/participantes/registro_html.php">Registrarse</a></li>
                    <li><a href="/rally-fotografico/participantes/login_html.php">Iniciar sesión</a></li>
                <?php endif; ?>
                <li><a href="/rally-fotografico/votacion/galeria_html.php">Galería</a></li>
            </ul>
        </nav>
    </div>
</header>
