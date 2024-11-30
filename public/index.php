<?php
include '../config/db.php';
include '../controllers/CourseController.php';

// Mengambil daftar kursus dari database
$courseController = new CourseController();
$courses = $courseController->getAllCourses();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Platform Kursus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/styles.css">  <!-- Menyertakan file CSS untuk styling -->
</head>
<body>

    <!-- Navbar -->
    <?php include '../includes/header.php'; ?>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Selamat datang di Platform Kursus!</h2>
        
        <!-- Daftar Kursus -->
        <div class="row">
            <div class="col-md-12">
                <h3>Kursus yang Tersedia</h3>
                <div class="row g-4">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card">
                                <!-- Menampilkan Gambar Sampul Kursus -->
                                <img src="../assets/images/<?= htmlspecialchars($course['image_url']) ?>" alt="Gambar Sampul <?= htmlspecialchars($course['title']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">

                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                                    <a href="../views/user/course_detail.php?course_id=<?= $course['id'] ?>" class="btn btn-primary w-100">Lihat Kursus</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Tentang Platform (Ditempatkan setelah daftar kursus) -->
        <div class="mt-5">
            <h3 class="text-center mb-4">Tentang Platform Kami</h3>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <p>Platform kursus kami menyediakan berbagai kursus dari berbagai bidang, membantu Anda untuk belajar secara fleksibel dengan materi yang up-to-date dan instruktur yang berpengalaman.</p>
                    <img src="../../assets/images/platform.jpg" alt="Platform Kursus" class="img-fluid rounded-3 mb-4">
                    <p>Kami berkomitmen untuk memberikan pengalaman belajar terbaik yang memungkinkan Anda menguasai keterampilan baru untuk memajukan karir Anda.</p>
                </div>
            </div>
        </div>

        <!-- Hubungi Kami -->
        <div class="mt-5 text-center">
            <h3>Hubungi Kami</h3>
            <p>Email: <a href="mailto:support@courseplatform.com">support@courseplatform.com</a></p>
            <p>Telepon: <a href="tel:+1234567890">123-456-7890</a></p>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>

    <!-- JavaScript (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
