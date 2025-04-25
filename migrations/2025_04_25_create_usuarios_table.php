<?php
require_once '../config.php';

$migration = "
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE
)
";

try {
    $pdo->exec($migration);
    echo "Tabla 'usuarios' creada con éxito.\n";
} catch (PDOException $e) {
    die("Error al crear la tabla 'usuarios': " . $e->getMessage() . "\n");
}