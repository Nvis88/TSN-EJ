<?php
require_once '../config.php';

// Datos iniciales para la tabla "permisos"
$permisos = [
    ['nombre' => 'ver_clientes', 'descripcion' => 'Permite visualizar el listado de clientes.'],
    ['nombre' => 'editar_clientes', 'descripcion' => 'Permite agregar o editar clientes.'],
    ['nombre' => 'eliminar_clientes', 'descripcion' => 'Permite eliminar clientes.'],
    ['nombre' => 'ver_consorcios', 'descripcion' => 'Permite visualizar el listado de consorcios.'],
    ['nombre' => 'editar_consorcios', 'descripcion' => 'Permite agregar o editar consorcios.'],
    ['nombre' => 'eliminar_consorcios', 'descripcion' => 'Permite eliminar consorcios.'],
    ['nombre' => 'configurar_permisos', 'descripcion' => 'Permite configurar los permisos de los roles.'],
    ['nombre' => 'ver_registro', 'descripcion' => 'Permite visualizar el registro de actividades.']
];

try {
    // Verificar si los permisos ya existen
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM permisos");
    $stmt->execute();
    $permisos_existentes = $stmt->fetchColumn();

    if ($permisos_existentes > 0) {
        echo "Los permisos ya están insertados en la base de datos.\n";
    } else {
        // Insertar permisos iniciales
        $stmt = $pdo->prepare("INSERT INTO permisos (nombre, descripcion) VALUES (:nombre, :descripcion)");
        foreach ($permisos as $permiso) {
            $stmt->execute([
                'nombre' => $permiso['nombre'],
                'descripcion' => $permiso['descripcion']
            ]);
        }
        echo "Permisos iniciales insertados con éxito.\n";
    }
} catch (PDOException $e) {
    die("Error al insertar los permisos iniciales: " . $e->getMessage() . "\n");
}