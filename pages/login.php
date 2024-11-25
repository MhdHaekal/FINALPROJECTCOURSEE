<?php
// Menyertakan koneksi ke database
include('../includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $kata_sandi = $_POST['kata_sandi'];

    // Query untuk mencari pengguna berdasarkan email
    $query = "SELECT * FROM Pengguna WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($kata_sandi, $user['kata_sandi'])) {
            // Menyimpan session untuk login
            session_start();
            $_SESSION['id_pengguna'] = $user['id_pengguna'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['peran'] = $user['peran'];

            header("Location: ../index.php"); // Arahkan pengguna ke halaman beranda
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/styles.css">

</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-lg p-4 w-100" style="max-width: 400px;">
            <h1 class="text-center mb-4 text-primary">Login</h1>

            <!-- Menampilkan pesan error jika ada -->
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="kata_sandi" class="form-label">Password</label>
                    <input type="password" class="form-control" id="kata_sandi" name="kata_sandi" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <p class="text-center mt-3"> Belum memiliki akun?
                <a href="register.php" class="text-decoration-none">Daftar Sekarang</a>
            </p>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>