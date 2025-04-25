<?php
session_start();
require_once 'config.php'; // Archivo con la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Verificar si el usuario existe
    $stmt = $pdo->prepare("SELECT id_usuario, password, id_rol FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        // Credenciales correctas, iniciar sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['id_rol'] = $usuario['id_rol'];
        echo "Login exitoso. Redirigiendo...";
        header('Location: dashboard.php'); // Redirigir a la página principal
        exit;
    } else {
        // Credenciales incorrectas
        echo "Correo electrónico o contraseña incorrectos.";
    }
} else {
    echo "Método no permitido.";
}