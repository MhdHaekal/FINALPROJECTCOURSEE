<?php
include('../includes/db_connect.php');

// Query untuk mengambil data kursus
$query = "SELECT * FROM Kursus";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2>Daftar Kursus</h2>
        <div class="row">
            <?php while ($kursus = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="../assets/images/course.jpg" class="card-img-top" alt="Kursus">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $kursus['judul']; ?></h5>
                            <p class="card-text"><?php echo substr($kursus['deskripsi'], 0, 100); ?>...</p>
                            <a href="course_detail.php?id_kursus=<?php echo $kursus['id_kursus']; ?>" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
