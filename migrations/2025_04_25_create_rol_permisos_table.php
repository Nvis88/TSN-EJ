<?php
require_once '../config.php';

$migration = "
CREATE TABLE IF NOT EXISTS rol_permisos (
    id_rol INT NOT NULL,
    id_permiso INT NOT NULL,
    PRIMARY KEY (id_rol, id_permiso),
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE,
    FOREIGN KEY (id_permiso) REFERENCES permisos(id_permiso) ON DELETE CASCADE
)
";

try {
    $pdo->exec($migration);
    echo "Tabla 'rol_permisos' creada con éxito.\n";
} catch (PDOException $e) {
    die("Error al crear la tabla 'rol_permisos': " . $e->getMessage() . "\n");
}