<?php
// Configuración de la base de datos
$db_host = '127.0.0.1';
$db_name = 'TSNEJ';
$db_user = 'root';
$db_pass = '';
$db_charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=$db_charset", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}