<?php
// Menyertakan file koneksi ke database
include('../includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $kata_sandi = password_hash($_POST['kata_sandi'], PASSWORD_DEFAULT);
    $peran = $_POST['peran'];

    // Query untuk memasukkan data pengguna baru ke tabel Pengguna
    $query = "INSERT INTO Pengguna (nama, email, kata_sandi, peran)
              VALUES ('$nama', '$email', '$kata_sandi', '$peran')";

    if (mysqli_query($conn, $query)) {
        header("Location: login.php?success=1");
        exit();
    } else {
        $error_message = "Gagal mendaftarkan pengguna. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/register.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

    <!-- Menyertakan Header -->
    <?php include('../includes/header.php'); ?>

    <div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="card shadow-lg p-4 w-100" style="max-width: 500px;">
        <h1 class="text-center mb-4 text-primary">Register</h1>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="kata_sandi" class="form-label">Password</label>
                <input type="password" class="form-control" id="kata_sandi" name="kata_sandi" required>
            </div>
            <div class="mb-3">
                <label for="peran" class="form-label">Peran</label>
                <select class="form-select" id="peran" name="peran" required>
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <p class="text-center mt-3">
            <a href="login.php" class="text-decoration-none">Already have an account? Login</a>
        </p>
    </div>
</div>


    <!-- Menyertakan Footer -->
    <?php include('../includes/footer.php'); ?>
</body>
</html>
