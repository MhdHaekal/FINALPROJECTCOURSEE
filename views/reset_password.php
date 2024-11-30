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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Reset Password</h2>
        <form method="POST" action="reset_password.php">
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger mt-3"><?= $error_message ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success mt-3"><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
