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
    // Jika tidak ada ID kursus yang diterima, alihkan ke halaman utama atau beri error
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kursus - <?= htmlspecialchars($course['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/styles.css">  <!-- Menyertakan file CSS untuk styling -->
</head>
<body>

    <!-- Navbar -->
    <?php include '../../includes/header.php'; ?>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2><?= htmlspecialchars($course['title']) ?></h2>
        
        <!-- Gambar Sampul -->
        <img src="../../assets/images/<?= htmlspecialchars($course['image_url']) ?>" alt="Gambar Sampul Kursus" class="img-fluid mb-4" style="max-height: 300px; object-fit: cover; width: 100%;">

        <p><strong>Deskripsi:</strong> <?= htmlspecialchars($course['description']) ?></p>

        <!-- Video URL (Jika ada video) -->
        <?php if (!empty($course['video_url'])): ?>
            <h4>Video Kursus</h4>
            <iframe width="560" height="315" src="<?= htmlspecialchars($course['video_url']) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <?php endif; ?>

        <!-- Materi Kursus -->
        <h4>Materi Kursus</h4>
        <div class="list-group">
            <?php
            // Menampilkan semua materi kursus yang terkait
            $query = "SELECT * FROM course_materials WHERE course_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $course_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($material = $result->fetch_assoc()) {
                    // Tampilkan materi sesuai tipe
                    echo '<div class="list-group-item">';
                    if ($material['type'] == 'text') {
                        // Tampilkan materi teks
                        echo '<div class="mt-3"><h5>Materi Teks:</h5><p>' . nl2br(htmlspecialchars($material['content'])) . '</p></div>';
                    } elseif ($material['type'] == 'file') {
                        // Tampilkan file materi
                        echo '<a href="../../assets/files/' . htmlspecialchars($material['content']) . '" class="btn btn-secondary" target="_blank">Unduh Materi</a>';
                    } elseif ($material['type'] == 'video') {
                        // Tampilkan video
                        echo '<iframe width="560" height="315" src="' . htmlspecialchars($material['content']) . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    }
                    echo '</div>';
                }
            } else {
                echo '<p>Tidak ada materi tambahan untuk kursus ini.</p>';
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../../includes/footer.php'; ?>

    <!-- JavaScript (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
