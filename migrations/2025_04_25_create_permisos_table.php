<?php
require_once '../config.php';

$migration = "
CREATE TABLE IF NOT EXISTS permisos (
    id_permiso INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
)
";

try {
    $pdo->exec($migration);
    echo "Tabla 'permisos' creada con éxito.\n";
} catch (PDOException $e) {
    die("Error al crear la tabla 'permisos': " . $e->getMessage() . "\n");
}