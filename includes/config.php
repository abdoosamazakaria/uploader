<?php
$host = 'localhost';
$dbname = 'u435275044_screenmix';
$username = 'u435275044_screenmix';
$password = 'Doaa100200300400@@';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// تسجيل الأخطاء
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');
?>