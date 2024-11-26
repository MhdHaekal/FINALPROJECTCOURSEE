<?php
session_start();
include '../../admin/config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Periksa pengguna berdasarkan email
    $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Simpan data ke sesi
        $_SESSION['user_id'] = $user['id_pengguna'];
        $_SESSION['role'] = $user['peran'];

        // Redirect berdasarkan role
        if ($user['peran'] === 'admin') {
            header('Location: ../../admin/dashboard.php');
        } else {
            header('Location: ../index.php');
        }
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body class="bg-light">
    <?php include('../../includes/header.php'); ?>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px; border-radius: 16px;">
            <h2 class="text-center mb-4 text-primary fw-bold">Login</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger text-center">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
            </form>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="register.php" class="text-decoration-none text-primary">Register here</a></p>
            </div>
        </div>
    </div>
    <?php include('../../includes/footer.php'); ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
