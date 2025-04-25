<?php
require_once '../config.php';

// Asignaciones iniciales de permisos a roles
$rol_permisos = [
    'Administrador' => [
        'ver_clientes', 'editar_clientes', 'eliminar_clientes',
        'ver_consorcios', 'editar_consorcios', 'eliminar_consorcios',
        'configurar_permisos', 'ver_registro'
    ],
    'Socios' => [
        'ver_clientes', 'editar_clientes',
        'ver_consorcios', 'editar_consorcios',
        'configurar_permisos'
    ],
    'Operadores' => [
        'ver_clientes', 'ver_consorcios'
    ]
];

try {
    echo "Iniciando asignación de permisos a roles...\n";

    // Obtener todos los roles de la base de datos
    $roles_stmt = $pdo->prepare("SELECT LOWER(TRIM(nombre)) AS nombre, id_rol FROM roles");
    $roles_stmt->execute();
    $roles = $roles_stmt->fetchAll(PDO::FETCH_KEY_PAIR); // ['nombre_rol' => id_rol]

    if (empty($roles)) {
        die("Error: No se encontraron roles en la base de datos. Asegúrate de ejecutar seed_roles.php primero.\n");
    }

    echo "Roles encontrados:\n";
    print_r($roles);

    // Obtener todos los permisos de la base de datos
    $permisos_stmt = $pdo->prepare("SELECT LOWER(TRIM(nombre)) AS nombre, id_permiso FROM permisos");
    $permisos_stmt->execute();
    $permisos = $permisos_stmt->fetchAll(PDO::FETCH_KEY_PAIR); // ['nombre_permiso' => id_permiso]

    if (empty($permisos)) {
        die("Error: No se encontraron permisos en la base de datos. Asegúrate de ejecutar seed_permisos.php primero.\n");
    }

    echo "Permisos encontrados:\n";
    print_r($permisos);

    // Insertar asignaciones en rol_permisos
    $stmt = $pdo->prepare("INSERT INTO rol_permisos (id_rol, id_permiso) VALUES (:id_rol, :id_permiso)");

    foreach ($rol_permisos as $rol_nombre => $permisos_asignados) {
        $rol_nombre_normalizado = strtolower(trim($rol_nombre));
        if (!isset($roles[$rol_nombre_normalizado])) {
            echo "El rol '$rol_nombre' no existe en la base de datos. Verifica seed_roles.php.\n";
            continue;
        }

        $id_rol = $roles[$rol_nombre_normalizado];
        echo "Procesando permisos para el rol '$rol_nombre' (ID: $id_rol)...\n";

        foreach ($permisos_asignados as $permiso_nombre) {
            $permiso_nombre_normalizado = strtolower(trim($permiso_nombre));
            if (!isset($permisos[$permiso_nombre_normalizado])) {
                echo "El permiso '$permiso_nombre' no existe en la base de datos. Verifica seed_permisos.php.\n";
                continue;
            }

            $id_permiso = $permisos[$permiso_nombre_normalizado];
            $stmt->execute([
                'id_rol' => $id_rol,
                'id_permiso' => $id_permiso
            ]);
            echo "Asignado permiso '$permiso_nombre' (ID: $id_permiso) al rol '$rol_nombre' (ID: $id_rol).\n";
        }
    }

    echo "Asignación de permisos a roles completada con éxito.\n";
} catch (PDOException $e) {
    die("Error al asignar permisos a roles: " . $e->getMessage() . "\n");
}