<?php
session_start();  // Memulai sesi
session_unset();  // Menghapus semua variabel sesi
session_destroy();  // Menghancurkan sesi

// Mengarahkan pengguna ke halaman login
header("Location: login.php");
exit();
?>
