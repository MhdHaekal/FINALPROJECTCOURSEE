<?php
$host = 'localhost';
$dbname = 'db_kursus_online'; // Nama database sesuai dengan file dump SQL Anda
$username = 'root';           // Username database Anda
$password = '';               // Password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
