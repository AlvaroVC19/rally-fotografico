<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Fotografía - Rally de Flores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main class="form-container">
    <?php if (isset($_GET["error"])): ?>
        <div class="mensaje error">
            <?php if ($_GET["error"] === "limite"): ?>
                ❌ Has alcanzado el número máximo de fotos permitidas.
            <?php elseif ($_GET["error"] === "fuera_fecha"): ?>
                ⏳ No es posible subir fotos en este momento. El período de participación está cerrado.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <h2>Sube tu fotografía floral</h2>
    <form action="subir_foto.php" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required>

        <label for="descripcion">Descripción (opcional):</label>
        <input type="text" name="descripcion" id="descripcion">

        <label for="archivo">Archivo (JPG/PNG, máx. 3MB):</label>
        <input type="file" name="archivo" id="archivo" accept="image/jpeg, image/png" required>

        <input type="submit" value="Subir fotografía">
    </form>
</main>
</body>
</html>
