<?php
require_once 'auth.php';

// Verificar si el usuario está autenticado
checkAuth();

// Verificar si el usuario tiene el rol de "Administrador" (id_rol = 1)
checkRole([1]);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa</title>
</head>
<body>
    <h1>Bienvenido al Área Administrativa</h1>
    <p>Solo los administradores pueden acceder a esta página.</p>
</body>
</html>