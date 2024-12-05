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

<<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/profile.css">
</head>
<body>

    <!-- Navbar -->
    <?php include '../../includes/header.php'; ?>
<br></br>
    <!-- Profil Section -->
    <section class="profil-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-4">Profil Pengguna</h2>

                    <!-- Foto Profil -->
                    <div class="profile-picture mb-4">
                        <img src="../../uploads/<?= htmlspecialchars($user['profile_picture']) ?: 'default.jpg' ?>" 
                             alt="Foto Profil" 
                             class="img-fluid rounded-circle shadow">
                    </div>

                    <!-- Informasi Pengguna -->
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3" style="color: #00246B;">Informasi Pengguna</h5>
                            <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                        </div>
                    </div>

                    <!-- Tombol Edit dan Kembali -->
                    <div class="d-flex justify-content-center gap-3">
                        <a href="edit_profile.php" class="btn btn-primary px-4 py-2">Edit Profil</a>
                        <a href="home.php" class="btn btn-secondary px-4 py-2">Kembali Ke Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<br></br>
    <!-- Footer -->
    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

