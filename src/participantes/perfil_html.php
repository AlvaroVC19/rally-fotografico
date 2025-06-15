<?php
session_start();
include '../includes/header.php';
require_once '../includes/db.php';

// Verificar sesión activa
if (!isset($_SESSION["id"])) {
    header("Location: login_html.php");
    exit;
}

$id_usuario = $_SESSION["id"];
$nombre = $_SESSION["nombre"];

// Obtener fotos del usuario
$stmt = $conn->prepare("SELECT id, titulo, archivo, descripcion, estado FROM fotografias WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$fotos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de <?= htmlspecialchars($nombre) ?> - FlorClick 2025</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .modal-confirm {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-confirm.hidden {
            display: none;
        }
        .modal-content {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            max-width: 320px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            font-size: 1.1rem;
        }
        .modal-buttons {
            margin-top: 1.5rem;
            display: flex;
            justify-content: space-around;
        }
        .modal-buttons .btn {
            min-width: 100px;
        }
    </style>
</head>
<body>
<main class="galeria-main">
    <h2>Perfil de <?= htmlspecialchars($nombre) ?></h2>

    <div style="display: flex; justify-content: center; gap: 1rem; margin: 1rem 0;">
        <button onclick="location.href='subir_foto_html.php'" class="btn">Subir nueva foto</button>
        <button onclick="location.href='registro_html.php'" class="btn">Editar datos</button>
    </div>

    <?php if ($fotos->num_rows > 0): ?>
        <div class="galeria-grid">
            <?php while ($foto = $fotos->fetch_assoc()): ?>
                <div class="foto-card">
                    <img src="../uploads/<?= htmlspecialchars($foto['archivo']) ?>" alt="Foto subida" class="foto-img">
                    <h3><?= htmlspecialchars($foto['titulo']) ?></h3>
                    <p style="<?= empty($foto['descripcion']) ? 'color: #bbb; font-style: italic;' : '' ?>">
                        <?= !empty($foto['descripcion']) ? htmlspecialchars($foto['descripcion']) : 'Sin descripción' ?>
                    </p>

                    <button onclick="location.href='editar_foto_html.php?id=<?= $foto['id'] ?>'" style="margin-bottom: 5px">✏️ Editar</button>

                    <form action="borrar_foto.php" method="POST" class="form-borrar-foto" id="form-borrar-<?= $foto['id'] ?>">
                        <input type="hidden" name="id" value="<?= $foto['id'] ?>">
                        <button type="button" class="btn btn-danger btn-borrar" data-id="<?= $foto['id'] ?>">🗑️ Borrar</button>
                    </form>

                    <p>
                        Estado:
                        <?php
                        echo match($foto['estado']) {
                            'pendiente' => '<span style="color: orange;">Pendiente</span>',
                            'admitida' => '<span style="color: green;">Admitida</span>',
                            'rechazada' => '<span style="color: red;">Rechazada</span>',
                            default => 'Desconocido'
                        };
                        ?>
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p style="text-align:center;">Aún no has subido ninguna fotografía.</p>
    <?php endif; ?>
</main>

<!-- Modal de confirmación -->
<div id="modalConfirm" class="modal-confirm hidden">
    <div class="modal-content">
        <p>¿Deseas eliminar esta foto?</p>
        <div class="modal-buttons">
            <button id="confirmYes" class="btn btn-danger">Sí, borrar</button>
            <button id="confirmNo" class="btn btn-secondary">Cancelar</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalConfirm');
    const btnYes = document.getElementById('confirmYes');
    const btnNo = document.getElementById('confirmNo');
    let formToSubmit = null;

    // Al hacer clic en cualquier botón "Borrar"
    document.querySelectorAll('.btn-borrar').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            formToSubmit = document.getElementById('form-borrar-' + id);
            modal.classList.remove('hidden');
        });
    });

    // Confirmar borrado
    btnYes.addEventListener('click', () => {
        if (formToSubmit) {
            formToSubmit.submit();
        }
    });

    // Cancelar borrado
    btnNo.addEventListener('click', () => {
        formToSubmit = null;
        modal.classList.add('hidden');
    });

    // Cerrar modal si clicas fuera del contenido
    modal.addEventListener('click', e => {
        if (e.target === modal) {
            formToSubmit = null;
            modal.classList.add('hidden');
        }
    });
});
</script>
</body>
</html>
