<?php
session_start();

// Verificar que sea admin
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: /rally-fotografico/src/index.php");
    exit();
}

include '../includes/header.php';
require_once '../includes/db.php';

// Obtener lista de usuarios
$sql = "SELECT id, nombre, email, rol, fecha_registro FROM usuarios ORDER BY fecha_registro DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Gestión de Usuarios - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<main class="galeria-main" style="padding: 1rem; background-image: url('images/fondo.jpg');">

    <h2>Gestión de Usuarios</h2>

    <?php if ($result && $result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($usuario = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td><?= htmlspecialchars($usuario['rol']) ?></td>
                <td><?= htmlspecialchars($usuario['fecha_registro']) ?></td>
                <td>
                    <button class="btn" onclick="location.href='editar_usuario_html.php?id=<?= $usuario['id'] ?>'">Editar</button>
                    <?php if ($usuario['rol'] !== 'admin'): ?>
                        <button class="btn" onclick="if(confirm('¿Eliminar usuario <?= htmlspecialchars($usuario['nombre']) ?>?')) location.href='eliminar_usuario.php?id=<?= $usuario['id'] ?>'">Eliminar</button>
                    <?php else: ?>
                        <button class="btn" disabled style="opacity: 0.5; cursor: not-allowed;" title="No se puede eliminar a un administrador">Eliminar</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No hay usuarios registrados.</p>
    <?php endif; ?>

</main>
</body>
</html>
