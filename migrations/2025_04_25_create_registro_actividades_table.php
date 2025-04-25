<?php
require_once '../config.php';

$migration = "
CREATE TABLE IF NOT EXISTS registro_actividades (
    id_registro INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    actividad TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
)
";

try {
    $pdo->exec($migration);
    echo "Tabla 'registro_actividades' creada con éxito.\n";
} catch (PDOException $e) {
    die("Error al crear la tabla 'registro_actividades': " . $e->getMessage() . "\n");
}