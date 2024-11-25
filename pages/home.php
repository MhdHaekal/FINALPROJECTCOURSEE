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
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

    <!-- Menyertakan Header -->
    <?php include('../includes/header.php'); ?>

    <div class="container py-5">
        <h1 class="text-center mb-4 text-primary">Selamat Datang di Platform Belajar Online</h1>

        <div class="row">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($course = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?php echo htmlspecialchars($course['nama_kursus']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($course['deskripsi']); ?></p>
                                <a href="course_detail.php?id=<?php echo $course['id_kursus']; ?>" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-muted">Belum ada kursus yang tersedia.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Menyertakan Footer -->
    <?php include('../includes/footer.php'); ?>
</body>
</html>
