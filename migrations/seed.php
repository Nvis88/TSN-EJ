<?php
require_once '../config.php';

try {
    // Insertar datos en la tabla 'clientes'
    $pdo->exec("
        INSERT INTO clientes (nombre, email, telefono, direccion, tipo)
        VALUES 
        ('Cliente 1', 'cliente1@example.com', '123456789', 'Dirección 1', 'general'),
        ('Cliente 2', 'cliente2@example.com', '987654321', 'Dirección 2', 'consorcio')
    ");
    echo "Datos insertados en la tabla 'clientes'.\n";

    // Insertar datos en la tabla 'consorcios'
    $pdo->exec("
        INSERT INTO consorcios (id_cliente, cuenta_bancaria)
        VALUES 
        (2, 'Cuenta Bancaria 1')
    ");
    echo "Datos insertados en la tabla 'consorcios'.\n";
} catch (PDOException $e) {
    die("Error al insertar datos: " . $e->getMessage() . "\n");
}