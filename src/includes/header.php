<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="main-header">
    <div class="container">
        <h1><a href="/rally-fotografico/src/index.php">🌸 Enfoque Natural</a></h1>
        <nav>
            <ul>
                <?php if (isset($_SESSION["id"])): ?>
                    <li>
                        <!-- Cambiar dirección según rol -->
                        <a href="<?php 
                            if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin") {
                                echo '/rally-fotografico/src/admin/admin_html.php';
                            } else {
                                echo '/rally-fotografico/src/participantes/perfil_html.php';
                            }
                        ?>">
                            👤 <?= htmlspecialchars($_SESSION["nombre"]) ?>
                        </a>
                    </li>
                    <li><a href="/rally-fotografico/src/participantes/logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="/rally-fotografico/src/participantes/registro_html.php">Registrarse</a></li>
                    <li><a href="/rally-fotografico/src/participantes/login_html.php">Iniciar sesión</a></li>
                <?php endif; ?>
                <li><a href="/rally-fotografico/src/votacion/galeria_html.php">Galería</a></li>
            </ul>
        </nav>
    </div>
</header>
