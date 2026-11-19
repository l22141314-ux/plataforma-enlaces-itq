<?php
// config/db.php
// Conexión a la base de datos usando PDO

$host = 'localhost';
$dbname = 'itq_enlaces';
$username = 'root';
$password = ''; // En XAMPP por defecto está vacío

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Modo de errores para que lance excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Fetch como array asociativo por defecto
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>