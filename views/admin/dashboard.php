<?php
session_start();
include '../../config/db.php';
include '../../includes/authclass.php';

$auth = new AuthClass($conn);

// Pastikan admin sudah login
if (!$auth->isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$course_query = "SELECT * FROM courses";
$result_courses = $conn->query($course_query);

// Menangani error jika query gagal
if ($result_courses === false) {
    die('Query Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Dashboard Admin</h2>

        <!-- Tabel Daftar Kursus -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kursus</th>
                    <th>Deskripsi</th>
                    <th>Gambar Sampul</th>
                    <th>Dibuat Pada</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($course = $result_courses->fetch_assoc()): ?>
                    <tr>
                        <td><?= $course['id']; ?></td>
                        <td><?= $course['title']; ?></td>
                        <td><?= substr($course['description'], 0, 50); ?>...</td> <!-- Potong deskripsi -->
                        <td>
                            <?php if ($course['image_url']): ?>
                                <img src="../../assets/images/<?= $course['image_url']; ?>" alt="Image" width="50">
                            <?php else: ?>
                                <span>No image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $course['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tombol untuk menuju halaman pengguna -->
        <a href="views_user.php" class="btn btn-info mb-3">Lihat Pengguna Terdaftar</a>
        <a href="add_course.php" class="btn btn-primary mb-3">Tambah Kursus</a>
        <a href="manage_courses.php" class="btn btn-secondary mb-3">Kelola Kursus</a>
        <a href="../logout.php" class="btn btn-danger mb-3">Logout</a>
    </div>
</body>
</html>
