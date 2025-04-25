<?php
$password = 'hola1478'; // Cambia este valor por la contraseña deseada
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

echo "Contraseña encriptada: " . $hashed_password;