<?php
require_once '../config.php';

try {
    $sql = "
        CREATE TABLE IF NOT EXISTS usuarios (
            id_usuario INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            id_rol INT NOT NULL,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
        );
    ";

    $pdo->exec($sql);
    echo "Tabla 'usuarios' creada correctamente.\n";
} catch (PDOException $e) {
    die("Error al crear la tabla 'usuarios': " . $e->getMessage() . "\n");
}