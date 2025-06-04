<?php
session_start();
require_once '../includes/db.php';
include '../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Buscar usuario por correo
    $sql = "SELECT id, nombre, password, rol FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar contraseña
        if (password_verify($password, $usuario["password"])) {
            $_SESSION["id"] = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["rol"] = $usuario["rol"];

            // Redirigir según el rol
            if ($usuario["rol"] === "admin") {
                header("Location: ../admin/admin_html.php");
            } else {
                header("Location: perfil_html.php");
            }
            exit;
        } else {
            echo "⚠️ Contraseña incorrecta.";
        }
    } else {
        echo "⚠️ Usuario no encontrado.";
    }
}
?>
