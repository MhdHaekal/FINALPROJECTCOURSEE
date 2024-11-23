<?php
// Ganti dengan kredensial database Anda
$host = 'localhost';  // atau IP address server
$username = 'root';   // ganti dengan username database Anda
$password = '';       // ganti dengan password database Anda
$dbname = 'sistem_course_online'; // ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
