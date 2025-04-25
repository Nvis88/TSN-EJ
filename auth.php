<?php
session_start();

/**
 * Verificar si el usuario está autenticado.
 * En caso contrario, redirigir al login.
 */
function checkAuth() {
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Verificar si el usuario tiene un rol específico.
 * @param array $rolesPermitidos Lista de roles permitidos para acceder a la página.
 */
function checkRole($rolesPermitidos) {
    if (!isset($_SESSION['id_rol']) || !in_array($_SESSION['id_rol'], $rolesPermitidos)) {
        header('HTTP/1.1 403 Forbidden');
        echo "No tienes permiso para acceder a esta página.";
        echo "Session ID ROL: " . $_SESSION['id_rol'] . "\n";
        echo "Roles permitidos: " . $rolesPermitidos . "\n";
        exit;
    }
}