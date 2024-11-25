<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../project/auth/login.php');
    exit;
}

include 'config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM kursus WHERE id_kursus = ?");
$stmt->execute([$id]);

header('Location: view_courses.php');
exit;
?>
