<?php
require_once 'auth.php';

// Verificar si el usuario está autenticado
checkAuth();

// Opcional: Verificar si el usuario tiene un rol permitido
// checkRole([1]); // Solo usuarios con el rol "Administrador" (id_rol = 1)

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido al Dashboard</h1>
    <p>Solo los usuarios autenticados pueden ver esta página.</p>
</body>
</html>