<?php
require_once '../config.php';

$migration = "
CREATE TABLE IF NOT EXISTS roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT
)
";

try {
    $pdo->exec($migration);
    echo "Tabla 'roles' creada con éxito.\n";
} catch (PDOException $e) {
    die("Error al crear la tabla 'roles': " . $e->getMessage() . "\n");
}