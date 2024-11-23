<?php
session_start();
include('../includes/db_connect.php');

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header('Location: login.php');
    exit();
}

// Mendapatkan daftar kursus
$query = "SELECT * FROM Kursus WHERE visibilitas = 1"; // Menampilkan kursus yang aktif
$result = mysqli_query($conn, $query);

// Proses pendaftaran kursus
if (isset($_GET['daftar'])) {
    $id_kursus = $_GET['daftar'];
    $id_pengguna = $_SESSION['id_pengguna'];

    // Memeriksa apakah pengguna sudah mendaftar ke kursus tersebut
    $check_query = "SELECT * FROM Pendaftaran WHERE id_pengguna = '$id_pengguna' AND id_kursus = '$id_kursus'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $message = "Anda sudah terdaftar di kursus ini!";
    } else {
        // Menambahkan pendaftaran kursus
        $insert_query = "INSERT INTO Pendaftaran (id_pengguna, id_kursus, status) VALUES ('$id_pengguna', '$id_kursus', 'aktif')";
        if (mysqli_query($conn, $insert_query)) {
            $message = "Pendaftaran berhasil! Anda sekarang terdaftar di kursus ini.";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kursus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2>Daftar Kursus</h2>

        <!-- Pesan Informasi -->
        <?php
        if (isset($message)) {
            echo "<div class='alert alert-info'>$message</div>";
        }
        ?>

        <div class="row">
            <?php while ($kursus = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="../assets/images/course.jpg" class="card-img-top" alt="Kursus">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $kursus['judul']; ?></h5>
                        <p class="card-text"><?php echo substr($kursus['deskripsi'], 0, 100) . '...'; ?></p>
                        <p><strong>Harga: </strong>Rp <?php echo number_format($kursus['harga'], 0, ',', '.'); ?></p>
                        <a href="course_detail.php?id_kursus=<?php echo $kursus['id_kursus']; ?>" class="btn btn-primary">Lihat Detail</a>
                        <a href="courses.php?daftar=<?php echo $kursus['id_kursus']; ?>" class="btn btn-success">Daftar</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
