<?php
require_once '../config.php';

// Crear la tabla 'clientes'
$migration = "
CREATE TABLE IF NOT EXISTS clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telefono VARCHAR(50),
    direccion TEXT,
    tipo ENUM('consorcio', 'general') NOT NULL DEFAULT 'general', -- Tipo de cliente
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
";

try {
    $pdo->exec($migration);
    echo "Migración ejecutada: Tabla 'clientes' creada con éxito.\n";
} catch (PDOException $e) {
    die("Error en la migración: " . $e->getMessage() . "\n");
}