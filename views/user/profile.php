<?php
session_start();
include '../../config/db.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil ID pengguna dari session
$user_id = $_SESSION['user_id'];

// Ambil data pengguna dari database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <?php include '../../includes/header.php'; ?>

    <div class="container mt-5">
        <h2>Profil Pengguna</h2>

        <!-- Tampilkan Foto Profil -->
        <div class="text-center">
            <img src="../../uploads/<?= htmlspecialchars($user['profile_picture']) ?: 'default.jpg' ?>" alt="Foto Profil" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
        </div>

        <p><strong>Nama:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

        <a href="edit_profile.php" class="btn btn-primary mt-3">Edit Profil</a><br /><br><br>
        <a href="home.php" class="btn btn-secondary">Kembali Kehome</a>
    </div>
    

    <!-- Footer -->
    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
