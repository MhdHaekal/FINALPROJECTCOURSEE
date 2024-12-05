<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];  // Role yang dipilih oleh user (admin atau user)

    // Query untuk memasukkan data user ke database
    $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    
    if ($stmt->execute()) {
        header("Location: login.php");  // Arahkan ke halaman login setelah registrasi sukses
        exit;
    } else {
        $error_message = "Gagal mendaftar, coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Link ke file CSS eksternal -->
    <link href="../css/register.css" rel="stylesheet">
</head>
<body style="background-color: #CADCFC;">

<div class="register-container">
    <div class="register-card" style="background-color: #ffffff; border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 class="text-center" style="color: #00246B;">Registrasi</h2>
        <form method="POST" action="register.php">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="username" id="username" required style="border: 1px solid #00246B;">
                <label for="username" style="color: #00246B;">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" required style="border: 1px solid #00246B;">
                <label for="email" style="color: #00246B;">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password" required style="border: 1px solid #00246B;">
                <label for="password" style="color: #00246B;">Password</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" name="role" id="role" required style="border: 1px solid #00246B;">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <label for="role" style="color: #00246B;">Role</label>
            </div>
            <div class="mb-4">
                <button type="submit" class="btn" style="background-color: #00246B; color: #fff; width: 100%; padding: 12px 0; border-radius: 5px;">Daftar</button>
            </div>
        </form>

        <!-- Link untuk login -->
        <div class="text-center">
            Sudah punya akun? <a href="login.php" style="color: #00246B;">Login disini</a>
        </div>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger mt-3"><?= $error_message ?></div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
