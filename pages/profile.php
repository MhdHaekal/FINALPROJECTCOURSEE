<?php
session_start();
include('../includes/db_connect.php');

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header('Location: login.php');
    exit();
}

$id_pengguna = $_SESSION['id_pengguna'];

// Mendapatkan data pengguna
$user_query = "SELECT * FROM Pengguna WHERE id_pengguna = '$id_pengguna'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Mendapatkan kursus yang sudah diikuti
$courses_query = "SELECT K.* FROM Kursus K 
                  JOIN Pendaftaran P ON K.id_kursus = P.id_kursus
                  WHERE P.id_pengguna = '$id_pengguna' AND P.status = 'aktif'";
$courses_result = mysqli_query($conn, $courses_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2>Profil Pengguna</h2>
        <p><strong>Nama: </strong><?php echo $user['nama']; ?></p>
        <p><strong>Email: </strong><?php echo $user['email']; ?></p>
        
        <h3>Kursus yang Diikuti</h3>
        <ul>
            <?php while ($course = mysqli_fetch_assoc($courses_result)): ?>
                <li><?php echo $course['judul']; ?> 
                    <a href="course_detail.php?id_kursus=<?php echo $course['id_kursus']; ?>" class="btn btn-link">Lihat Detail</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
