<?php
require_once '../config.php';

// Datos iniciales para la tabla "roles"
$roles = [
    ['nombre' => 'administrador', 'descripcion' => 'Acceso completo al sistema.'],
    ['nombre' => 'socios', 'descripcion' => 'Acceso a casi todo, permisos configurados por el Administrador.'],
    ['nombre' => 'operadores', 'descripcion' => 'Permisos controlados por los Socios.']
];

try {
    // Verificar si los roles ya existen
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM roles");
    $stmt->execute();
    $roles_existentes = $stmt->fetchColumn();

    if ($roles_existentes > 0) {
        echo "Los roles ya están insertados en la base de datos.\n";
    } else {
        // Insertar roles iniciales
        $stmt = $pdo->prepare("INSERT INTO roles (nombre, descripcion) VALUES (:nombre, :descripcion)");
        foreach ($roles as $rol) {
            $stmt->execute([
                'nombre' => $rol['nombre'],
                'descripcion' => $rol['descripcion']
            ]);
        }
        echo "Roles iniciales insertados con éxito.\n";
    }
} catch (PDOException $e) {
    die("Error al insertar los roles iniciales: " . $e->getMessage() . "\n");
}