<?php
require_once '../config.php';

// Crear la tabla 'consorcios'
$migration = "
CREATE TABLE IF NOT EXISTS consorcios (
    id_consorcio INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL, -- Relación con la tabla 'clientes'
    cuenta_bancaria VARCHAR(100),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
";

try {
    $pdo->exec($migration);
    echo "Migración ejecutada: Tabla 'consorcios' creada con éxito.\n";
} catch (PDOException $e) {
    die("Error en la migración: " . $e->getMessage() . "\n");
}