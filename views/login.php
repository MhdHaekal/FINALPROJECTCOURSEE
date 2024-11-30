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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <!-- Tambahkan tombol link lupa password -->
        <div class="mt-3">
            <a href="forgot_password.php">Lupa Password?</a>
        </div>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger mt-3"><?= $error_message ?></div>
        <?php endif; ?>
    </div>
</body>
</html>

