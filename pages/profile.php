<?php
session_start();
include('../includes/db_connect.php');

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header('Location: login.php');
    exit();
}

$id_pengguna = $_SESSION['id_pengguna'];

// Mendapatkan data pengguna
$user_query = "SELECT * FROM Pengguna WHERE id_pengguna = '$id_pengguna'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Mendapatkan kursus yang sudah diikuti
$courses_query = "SELECT K.* FROM Kursus K
                  JOIN Pendaftaran P ON K.id_kursus = P.id_kursus
                  WHERE P.id_pengguna = '$id_pengguna'";
$courses_result = mysqli_query($conn, $courses_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

    <!-- Menyertakan Header -->
    <?php include('../includes/header.php'); ?>

    <div class="container py-5">
        <div class="row">
            <!-- Informasi Profil -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h4 class="card-title text-primary">Profil Anda</h4>
                        <p><strong>Nama:</strong> <?php echo htmlspecialchars($user['nama']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Peran:</strong> <?php echo htmlspecialchars($user['peran']); ?></p>
                        <a href="edit_profile.php" class="btn btn-primary mt-3">Edit Profil</a>
                    </div>
                </div>
            </div>

            <!-- Daftar Kursus -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Kursus yang Diikuti</h4>
                        <?php if (mysqli_num_rows($courses_result) > 0): ?>
                            <ul class="list-group list-group-flush">
                                <?php while ($course = mysqli_fetch_assoc($courses_result)): ?>
                                    <li class="list-group-item">
                                        <strong><?php echo htmlspecialchars($course['nama_kursus']); ?></strong>
                                        <p><?php echo htmlspecialchars($course['deskripsi']); ?></p>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Anda belum mengikuti kursus apa pun.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menyertakan Footer -->
    <?php include('../includes/footer.php'); ?>
</body>
</html>
