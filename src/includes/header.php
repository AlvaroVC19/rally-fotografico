<header class="main-header">
    <div class="container">
        <h1><a href="/index.php">🌸 Enfoque Natural</a></h1>
        <nav>
            <ul>
                <?php if (isset($_SESSION["id"])): ?>
                    <li>
                        <a href="<?php 
                            if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin") {
                                echo '/admin/admin_html.php';
                            } else {
                                echo '/participantes/perfil_html.php';
                            }
                        ?>">
                            👤 <?= htmlspecialchars($_SESSION["nombre"]) ?>
                        </a>
                    </li>
                    <li><a href="/participantes/logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="/participantes/registro_html.php">Registrarse</a></li>
                    <li><a href="/participantes/login_html.php">Iniciar sesión</a></li>
                <?php endif; ?>
                <li><a href="/votacion/galeria_html.php">Galería</a></li>
            </ul>
        </nav>
    </div>
</header>
