<?php
require_once '../config.php';

// Función para ejecutar una migración
function migrate($pdo, $migration_name, $query) {
    // Crear la tabla de control de migraciones si no existe
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration_name VARCHAR(255) NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Verificar si la migración ya fue ejecutada
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration_name = :migration_name");
    $stmt->execute(['migration_name' => $migration_name]);
    if ($stmt->fetchColumn() > 0) {
        echo "La migración '$migration_name' ya fue ejecutada.\n";
        return;
    }

    // Ejecutar la migración
    try {
        $pdo->exec($query);
        $pdo->prepare("INSERT INTO migrations (migration_name) VALUES (:migration_name)")
            ->execute(['migration_name' => $migration_name]);
        echo "Migración '$migration_name' ejecutada con éxito.\n";
    } catch (PDOException $e) {
        die("Error en la migración '$migration_name': " . $e->getMessage() . "\n");
    }
}

// Ejecutar migración para la tabla 'clientes'
$migration_name = "2025_04_25_create_clientes_table";
$migration_query = "
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
migrate($pdo, $migration_name, $migration_query);

// Ejecutar migración para la tabla 'consorcios'
$migration_name = "2025_04_25_create_consorcios_table";
$migration_query = "
CREATE TABLE IF NOT EXISTS consorcios (
    id_consorcio INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL, -- Relación con la tabla 'clientes'
    cuenta_bancaria VARCHAR(100),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
";
migrate($pdo, $migration_name, $migration_query);