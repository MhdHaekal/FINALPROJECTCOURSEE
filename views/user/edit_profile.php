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

// Menangani pembaruan profil
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data yang diubah
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    
    // Foto Profil (jika ada)
    $profile_picture = $user['profile_picture']; // Default (jika tidak ada perubahan)

    // Periksa apakah foto profil baru diupload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['name'] != '') {
        $image = $_FILES['profile_picture'];
        $image_name = time() . '_' . basename($image['name']);
        $image_tmp_name = $image['tmp_name'];
        $image_upload_path = '../../uploads/' . $image_name;

        // Pastikan folder uploads ada, jika tidak buat
        if (!file_exists('../../uploads')) {
            mkdir('../../uploads', 0777, true);
        }

        if (move_uploaded_file($image_tmp_name, $image_upload_path)) {
            $profile_picture = $image_name;
        } else {
            $error_message = 'Gagal mengunggah foto profil!';
        }
    }

    // Update data pengguna di database
    if (empty($error_message)) {
        $update_query = "UPDATE users SET full_name = ?, email = ?, profile_picture = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssi", $full_name, $email, $profile_picture, $user_id);
        if ($stmt->execute()) {
            $success_message = "Profil berhasil diperbarui!";
        } else {
            $error_message = "Gagal memperbarui profil!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/edit_profile.css">
</head>
<body>

    <!-- Navbar -->
    <?php include '../../includes/header.php'; ?>

    <br></br>

    <!-- Edit Profil Section -->
    <div class="container edit-profile-container mt-5">
        <h2 class="text-center mb-4">Edit Profil</h2>

        <!-- Pesan Error atau Success -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>

        <!-- Form Edit Profil -->
        <form method="POST" enctype="multipart/form-data" class="card shadow-sm p-4 mb-4 rounded">
            <!-- Foto Profil -->
            <div class="mb-3 text-center">
                <img src="../../uploads/<?= htmlspecialchars($user['profile_picture']) ?: 'default.jpg' ?>" 
                     alt="Foto Profil" class="img-fluid rounded-circle shadow"
                     style="width: 150px; height: 150px; object-fit: cover;">
            </div>

            <!-- Input Nama Lengkap -->
            <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="full_name" 
                       value="<?= htmlspecialchars($user['full_name']) ?>" required>
            </div>

            <!-- Input Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" 
                       value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <!-- Input Foto Profil Baru -->
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Foto Profil</label>
                <input type="file" class="form-control" name="profile_picture">
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Simpan Perubahan</button>
        </form>

        <a href="profile.php" class="btn btn-secondary w-100 back-to-profile-btn">Kembali Ke Profil</a>
    </div>

    <!-- Footer -->
    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
