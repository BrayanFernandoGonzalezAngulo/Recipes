<?php
$host = 'localhost'; // Cambia esto si es necesario
$db = 'gestor_recetas';
$user = 'root'; // Cambia el usuario si es necesario
$password = ''; // Cambia la contraseña si es necesario

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}
?>
