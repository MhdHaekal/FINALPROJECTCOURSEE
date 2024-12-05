<?php
session_start();
include '../../config/db.php';
include '../../controllers/CourseController.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Mengambil daftar kursus dari database
$courseController = new CourseController();
$courses = $courseController->getAllCourses();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../../assets/css/styles.css" rel="stylesheet"> <!-- File CSS eksternal -->
</head>
<body>

    <!-- Navbar -->
    <?php include '../../includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero d-flex align-items-center text-white py-5" style="background-color: #8AB6F9;">
        <div class="container text-center">
            <h1 class="display-3 mb-4" style="color: #00246B;">Halo, Selamat Datang Kembali!</h1>
            <p class="lead mb-4" style="color: #00246B;">Jelajahi kursus yang telah kami sediakan dan tingkatkan kemampuan Anda.</p>
            <a href="#courses" class="btn btn-dark btn-lg">Mulai Belajar</a>
        </div>
    </section>

    <!-- Daftar Kursus -->
    <section id="courses" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5" style="color: #00246B;">Kursus yang Direkomendasikan</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($courses as $course): ?>
                    <div class="col">
                        <div class="card shadow-sm border-0 rounded-3 course-card">
                            <img src="../../assets/images/<?= htmlspecialchars($course['image_url']) ?>" alt="Gambar Sampul <?= htmlspecialchars($course['title']) ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #00246B;"><?= htmlspecialchars($course['title']) ?></h5>
                                <p class="card-text" style="color: #555;"><?= htmlspecialchars($course['description']) ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <a href="course_detail.php?course_id=<?= $course['id'] ?>" class="btn btn-dark w-100">Lihat Kursus</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section class="py-5" style="background-color: #CADCFC;">
        <div class="container text-center">
            <h2 class="mb-4" style="color: #00246B;">Kenapa Memilih Kami?</h2>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <p style="color: #555;">Kami menawarkan berbagai kursus berkualitas yang diajarkan oleh instruktur berpengalaman. Temukan kursus yang cocok untuk kebutuhan Anda dan tingkatkan kemampuan Anda sekarang!</p>
                </div>
                <div class="col-lg-6">
                    <img src="../../assets/images/why_us.jpg" alt="Kenapa Memilih Kami" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </section>

    <!-- Instruktur Kami -->
<section class="instructor-section py-5">
    <div class="container text-center">
        <h2 class="mb-4" style="color: #00246B;">Instruktur Kami</h2>
        <div class="instructor-card d-flex justify-content-center">
            <img src="../../assets/images/instructor.jpg" alt="Instruktur" class="instructor-img">
            <div class="instructor-content">
                <h4>Tita Meita Marcusi</h4>
                <p>Instruktur berpengalaman dalam berbagai bidang teknologi dan pengembangan. John telah mengajar selama lebih dari 10 tahun dan memiliki pengalaman dalam mengembangkan materi kursus yang sangat mendalam dan mudah diikuti.</p>
                <a href="mailto:john.doe@example.com" class="btn-contact">Hubungi Instruktur</a> <!-- Tombol Hubungi Instruktur -->
            </div>
        </div>
    </div>
</section>


    <!-- Hubungi Kami -->
    <section class="bg-primary text-white py-5" style="background-color: #00246B;">
        <div class="container text-center">
            <h2 class="mb-4">Butuh Bantuan?</h2>
            <p>Email: <a href="mailto:support@courseplatform.com" class="text-light">support@courseplatform.com</a></p>
            <p>Telepon: <a href="tel:+1234567890" class="text-light">123-456-7890</a></p>
        </div>
    </section>

    <!-- Footer -->
    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
