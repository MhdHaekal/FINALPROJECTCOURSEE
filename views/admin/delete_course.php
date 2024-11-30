<?php
session_start();
include '../../config/db.php';
include '../../includes/authclass.php';

$auth = new AuthClass($conn);

// Pastikan admin sudah login
if (!$auth->isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Pastikan ada parameter 'id' untuk menentukan kursus yang akan dihapus
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $course_id = $_GET['id'];

    // Hapus kursus dari database
    $query = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Kursus berhasil dihapus.";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus kursus. Coba lagi.";
    }

    // Redirect kembali ke halaman manajemen kursus
    header("Location: manage_courses.php");
    exit;
} else {
    $_SESSION['error_message'] = "ID kursus tidak valid.";
    header("Location: manage_courses.php");
    exit;
}
