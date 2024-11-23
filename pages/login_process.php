<?php
session_start();
include 'includes/db_connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Cek pengguna di database
$stmt = $pdo->prepare("SELECT * FROM Pengguna WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['kata_sandi'])) {
    $_SESSION['user_id'] = $user['id_pengguna'];
    $_SESSION['user_role'] = $user['peran'];
    header("Location: pages/home.php");
} else {
    echo "Email atau kata sandi salah.";
}
?>
``