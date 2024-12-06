<?php
session_start();
include '../../config/db.php';
include '../../controllers/CourseController.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil ID kursus dari URL
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
} else {
    header("Location: homepage.php");
    exit;
}

// Mengambil detail kursus dari database
$courseController = new CourseController();
$course = $courseController->getCourseById($course_id);

// Pastikan kursus ditemukan
if (!$course) {
    echo "Kursus tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kursus - <?= htmlspecialchars($course['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/course_detail.css">
</head>
<body>

    <!-- Navbar -->
    <?php include '../../includes/header.php'; ?>

    <!-- Section Detail Kursus -->
    <section class="course-detail py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Judul Kursus -->
                    <h2 class="text-center mb-4" style="color: #00246B;"><?= htmlspecialchars($course['title']) ?></h2>

                    <!-- Gambar Sampul -->
                    <div class="text-center mb-5">
                        <img src="../../assets/images/<?= htmlspecialchars($course['image_url']) ?>" 
                             alt="Gambar Kursus" 
                             class="img-fluid rounded shadow-lg course-image">
                    </div>

                    <!-- Deskripsi Kursus -->
                    <div class="course-description bg-white p-4 rounded shadow mb-4">
                        <h4 class="mb-3" style="color: #00246B;">Deskripsi Kursus</h4>
                        <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>
                    </div>

                    <!-- Video Kursus -->
                    <?php if (!empty($course['video_url'])): ?>
                        <div class="course-video bg-white p-4 rounded shadow mb-4">
                            <h4 class="mb-3" style="color: #00246B;">Video Kursus</h4>
                            <div class="ratio ratio-16x9">
                                <iframe src="<?= htmlspecialchars($course['video_url']) ?>" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Materi Kursus -->
                    <div class="course-materials bg-white p-4 rounded shadow">
                        <h4 class="mb-3" style="color: #00246B;">Materi Kursus</h4>
                        <?php
                        $query = "SELECT * FROM course_materials WHERE course_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $course_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($material = $result->fetch_assoc()) {
                                echo '<div class="mb-3">';
                                if ($material['type'] == 'text') {
                                    echo '<p><strong>Materi Teks:</strong> ' . nl2br(htmlspecialchars($material['content'])) . '</p>';
                                } elseif ($material['type'] == 'file') {
                                    echo '<a href="../../assets/files/' . htmlspecialchars($material['content']) . '" class="btn btn-primary" target="_blank">Unduh Materi</a>';
                                } elseif ($material['type'] == 'video') {
                                    echo '<div class="ratio ratio-16x9">
                                              <iframe src="' . htmlspecialchars($material['content']) . '" frameborder="0" allowfullscreen></iframe>
                                          </div>';
                                }
                                echo '</div>';
                            }
                        } else {
                            echo '<p>Tidak ada materi tambahan untuk kursus ini.</p>';
                        }
                        ?>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="text-center mt-4">
                        <a href="home.php" class="btn btn-secondary px-4 py-2">Kembali ke Halaman Utama</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
