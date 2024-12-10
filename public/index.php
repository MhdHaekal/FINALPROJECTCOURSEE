<?php
include '../config/db.php';
include '../controllers/CourseController.php';

// Mengambil daftar kursus dari database
$courseController = new CourseController();
$courses = $courseController->getAllCourses();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Kursus Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/index.css" rel="stylesheet"> <!-- File CSS eksternal -->
</head>
<body>

    <!-- Navbar -->
    <?php include '../includes/header.php'; ?>

   <!-- Hero Section -->
<section class="hero d-flex align-items-center text-white py-5" style="background-color: #8AB6F9;">
    <div class="container d-flex align-items-center">
        <!-- Left Column for Text and Button -->
        <div class="text-left">
            <h1 class="display-3 mb-4" style="color: #00246B;">Selamat Datang di Platform Kursus Kami!</h1>
            <p class="lead mb-4" style="color: #00246B;">Jelajahi berbagai kursus berkualitas yang kami tawarkan untuk meningkatkan kemampuan Anda.</p>
            <a href="#courses" class="btn btn-dark btn-lg">Mulai Belajar</a>
        </div>
        <!-- Right Column for Image -->
        <div class="ml-5">
            <img src="../assets/images/hero.png" alt="Hero Image" class="hero-image">
        </div>
    </div>
</section>

    <!-- Tentang Kami -->
    <section class="py-5" style="background-color: #CADCFC;">
        <div class="container text-center">
            <h2 class="mb-4" style="color: #00246B;">Tentang Kami</h2>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 style="color: #00246B;">Kursus Upgrade Diri Terbaik</h1>
                    <p style="color: #00246B;">Platform kursus kami menyediakan berbagai kursus dari berbagai bidang. Kami menawarkan fleksibilitas dalam belajar dengan materi terkini dan pengajaran dari instruktur berpengalaman.</p>
                </div>
                <div class="col-lg-6">
                    <img src="../assets/images/tentang-kami.png" alt="Platform Kursus" class="img-fluid rounded-3">
                </div>
            </div>
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
                            <img src="../assets/images/<?= htmlspecialchars($course['image_url']) ?>" alt="Gambar Sampul <?= htmlspecialchars($course['title']) ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #00246B;"><?= htmlspecialchars($course['title']) ?></h5>
                                <p class="card-text" style="color: #555;"><?= htmlspecialchars($course['description']) ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <a href="../views/login.php" class="btn btn-dark w-100">Lihat Kursus</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Hubungi Kami -->
    <section class="py-5" style="background-color: #00246B;">
        <div class="container text-center">
            <h2 class="mb-4" style="color: #CADCFC;">Hubungi Kami</h2>
            <p style="color: #CADCFC;">Email: <a href="mailto:support@courseplatform.com" class="text-light">support@courseplatform.com</a></p>
            <form>
                <input type="text" class="form-control mb-3" placeholder="Nama Anda" required>
                <input type="email" class="form-control mb-3" placeholder="Email Anda" required>
                <textarea class="form-control mb-3" placeholder="Pesan Anda" rows="4" required></textarea>
                <button type="submit" class="btn btn-light">Kirim Pesan</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
