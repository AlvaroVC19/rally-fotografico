<?php
session_start();
include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Rally de Flores</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="hero-home" style="background-image: url('images/fondo.jpg');">
    <div class="hero-text">
        <h1>🌸 Enfoque Natural 🌸</h1>
        <p>Participa en el concurso capturando la belleza natural de las flores. Sube tus mejores fotos, compite y consigue votos.</p>
        <div class="hero-buttons">
            <a href="participantes/registro_html.php" class="btn">Registrarse</a>
            <a href="participantes/login_html.php" class="btn-outline">Iniciar sesión</a>
        </div>
    </div>
</section>

<section class="info">
    <div class="info-box">
        <h2>📷 ¿Qué es Enfoque Natural?</h2>
        <p>Enfoque Natural es un rally fotográfico en línea donde podrás demostrar tu creatividad capturando el mundo floral que te rodea. Este evento fomenta la participación artística, la fotografía de la naturaleza y la sana competencia.</p>
        <p>Las fotos serán revisadas y validadas por el equipo organizador y, si son admitidas, serán expuestas en la galería para ser votadas por el público.</p>
    </div>
    <div class="info-box">
        <h2>📋 Normas de participación</h2>
        <ul>
            <li>✅ Solo se admiten fotografías relacionadas con el tema: <strong>flores y naturaleza floral</strong>.</li>
            <li>📸 Cada participante puede subir <strong>hasta 3 fotografías</strong>.</li>
            <li>🔎 Todas las fotografías serán validadas por el administrador antes de ser visibles.</li>
            <li>❌ Si una foto es rechazada, <strong>no se podrá subir otra en su lugar</strong>.</li>
            <li>🕒 El período de subida y votación será anunciado y limitado en el tiempo.</li>
            <li>🗳️ Cada usuario puede votar una vez por foto (voto por IP) y no puede votar sus propias imágenes.</li>
        </ul>
    </div>
    <div class="info-box">
        <h2>❗ Avisos importantes</h2>
        <p><strong>📅 Asegúrate de subir tus fotos a tiempo, ya que una vez finalizado el plazo no se aceptarán nuevas imágenes.</strong></p>
        <p><strong>🔄 Las fotografías deben ser originales, sin plagios ni contenido ofensivo.</strong></p>
        <p><strong>🌼 Las imágenes deben mostrar flores como elemento principal. Pueden ser en exterior, interior, naturales o cultivadas. Prohibido usar imagenes por IA.</strong></p>
        <p>Participar implica aceptar todas las normas del concurso. Consulta tu perfil para ver el estado de tus fotos.</p>
    </div>
</section>

<footer>
    <p>&copy; 2025 Rally de Flores | Proyecto Integrado DAW</p>
</footer>
</body>
</html>
