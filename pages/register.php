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
    
    // Menjalankan query dan memeriksa apakah berhasil
    if (mysqli_query($conn, $query)) {
        echo "Registrasi berhasil! Silakan login.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2>Registrasi Pengguna</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="kata_sandi" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" id="kata_sandi" name="kata_sandi" required>
            </div>
            <div class="mb-3">
                <label for="peran" class="form-label">Peran</label>
                <select class="form-control" id="peran" name="peran" required>
                    <option value="admin">Siswa</option>
                    <option value="siswa">Admin/Pengajar</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
