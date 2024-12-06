<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Mengecek apakah email ada di database
    $query = "SELECT id, username FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email ditemukan, arahkan pengguna ke halaman reset password
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // Simpan ID pengguna di session untuk digunakan pada halaman reset password
        $_SESSION['user_id'] = $user_id;
        header("Location: reset_password.php");
        exit;
    } else {
        $error_message = "Email tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/forgot.css" rel="stylesheet">
</head>
<body>

<div class="forgot-password-container">
    <div class="forgot-password-card">
        <h2>Lupa Password</h2>
        <form method="POST" action="forgot_password.php">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" required>
                <label for="email">Masukkan Email Anda</label>
            </div>
            <div class="mb-4">
                <button type="submit" class="btn btn-custom w-100">Kirim Link Reset</button>
            </div>
        </form>

        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger mt-3"><?= $error_message ?></div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
