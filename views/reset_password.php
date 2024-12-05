<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: forgot_password.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password == $confirm_password) {
        // Hash password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password di database
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $hashed_password, $user_id);
        
        if ($stmt->execute()) {
            // Hapus session user_id setelah berhasil mengubah password
            unset($_SESSION['user_id']);
            $_SESSION['success_message'] = "Password berhasil diubah. Silakan login.";
            header("Location: login.php");
            exit;
        } else {
            $error_message = "Gagal memperbarui password. Coba lagi.";
        }
    } else {
        $error_message = "Password tidak cocok.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/reset_pass.css" rel="stylesheet">
</head>
<body>

<div class="reset-password-container">
    <div class="reset-password-card">
        <h2>Reset Password</h2>
        <form method="POST" action="reset_password.php">
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="new_password" id="new_password" required>
                <label for="new_password">Password Baru</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                <label for="confirm_password">Konfirmasi Password</label>
            </div>
            <div class="mb-4">
                <button type="submit" class="btn btn-custom w-100">Reset Password</button>
            </div>
        </form>

        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger mt-3"><?= $error_message ?></div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success mt-3"><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
