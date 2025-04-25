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

// Migraciones para las tablas relacionadas con clientes y consorcios
$migrations = [
    "2025_04_25_create_clientes_table" => "
        CREATE TABLE IF NOT EXISTS clientes (
            id_cliente INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            email VARCHAR(100),
            telefono VARCHAR(50),
            direccion TEXT,
            tipo ENUM('consorcio', 'general') NOT NULL DEFAULT 'general',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ",
    "2025_04_25_create_consorcios_table" => "
        CREATE TABLE IF NOT EXISTS consorcios (
            id_consorcio INT AUTO_INCREMENT PRIMARY KEY,
            id_cliente INT NOT NULL,
            cuenta_bancaria VARCHAR(100),
            FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE CASCADE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ",
    // Migraciones para usuarios, roles, permisos y registro de actividades
    "2025_04_25_create_roles_table" => "
        CREATE TABLE IF NOT EXISTS roles (
            id_rol INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL UNIQUE,
            descripcion TEXT
        )
    ",
    "2025_04_25_create_permisos_table" => "
        CREATE TABLE IF NOT EXISTS permisos (
            id_permiso INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL UNIQUE,
            descripcion TEXT
        )
    ",
    "2025_04_25_create_rol_permisos_table" => "
        CREATE TABLE IF NOT EXISTS rol_permisos (
            id_rol INT NOT NULL,
            id_permiso INT NOT NULL,
            PRIMARY KEY (id_rol, id_permiso),
            FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE,
            FOREIGN KEY (id_permiso) REFERENCES permisos(id_permiso) ON DELETE CASCADE
        )
    ",
    "2025_04_25_create_usuarios_table" => "
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
    ",
    "2025_04_25_create_registro_actividades_table" => "
        CREATE TABLE IF NOT EXISTS registro_actividades (
            id_registro INT AUTO_INCREMENT PRIMARY KEY,
            id_usuario INT NOT NULL,
            actividad TEXT NOT NULL,
            fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
        )
    "
];

// Ejecutar todas las migraciones
foreach ($migrations as $migration_name => $migration_query) {
    migrate($pdo, $migration_name, $migration_query);
}