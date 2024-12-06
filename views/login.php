<?php
session_start();
include '../config/db.php';
include '../includes/authclass.php';

$auth = new AuthClass($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($auth->login($email, $password)) {
        $role = $auth->getUserRole();
        if ($role === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: user/home.php");
        }
        exit;
    } else {
        $error_message = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Link ke file CSS eksternal -->
    <link href="../css/login.css" rel="stylesheet">
</head>
<body style="background-color: #CADCFC;">

<div class="login-container">
    <div class="login-card" style="background-color: #ffffff; border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 class="text-center" style="color: #00246B;">Login</h2>
        <form method="POST" action="login.php">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email" required style="border: 1px solid #00246B;">
                <label for="email" style="color: #00246B;">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password" required style="border: 1px solid #00246B;">
                <label for="password" style="color: #00246B;">Password</label>
            </div>
            <div class="mb-4">
                <button type="submit" class="btn" style="background-color: #00246B; color: #fff; width: 100%; padding: 12px 0; border-radius: 5px;">Login</button>
            </div>
        </form>
        
        <!-- Link untuk lupa password -->
        <div class="text-center">
            <a href="forgot_password.php" style="color: #00246B;">Lupa Password?</a>
        </div>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger mt-3"><?= $error_message ?></div>
        <?php endif; ?>

        <div class="footer-text text-center mt-3" style="color: #00246B;">
            Belum punya akun? <a href="register.php" style="color: #00246B;">Daftar disini</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
