<?php
session_start();
include 'includes/db_connect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash kata sandi
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah email sudah terdaftar
$stmt = $pdo->prepare("SELECT * FROM Pengguna WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "Email sudah terdaftar. Silakan gunakan email lain.";
} else {
    // Simpan pengguna baru ke database
    $stmt = $pdo->prepare("INSERT INTO Pengguna (nama, email, kata_sandi, peran) VALUES (?, ?, ?, 'siswa')");
    if ($stmt->execute([$name, $email, $hashed_password])) {
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_role'] = 'siswa';
        header("Location: pages/home.php");
    } else {
        echo "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
    }
}
?>