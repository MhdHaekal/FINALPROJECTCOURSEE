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

// Proses Hapus Kursus
if (isset($_GET['delete_course_id'])) {
    $course_id = $_GET['delete_course_id'];

    // Menghapus gambar jika ada
    $query = "SELECT image_url FROM courses WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
    if ($course && $course['image_url']) {
        $image_path = '../../assets/images/' . $course['image_url'];
        if (file_exists($image_path)) {
            unlink($image_path); // Menghapus file gambar
        }
    }

    // Menghapus data kursus dari database
    $delete_query = "DELETE FROM courses WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $course_id);
    if ($delete_stmt->execute()) {
        $success_message = "Kursus berhasil dihapus!";
    } else {
        $error_message = "Terjadi kesalahan saat menghapus kursus!";
    }
}

// Ambil daftar kursus
$query_courses = "SELECT id, title, description, image_url, created_at FROM courses"; 
$result_courses = $conn->query($query_courses);

// Cek jika query gagal
if (!$result_courses) {
    die("Query failed: " . $conn->error); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/admin_das.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Dashboard Admin</h2>

        <!-- Tampilkan pesan error atau sukses -->
        <?php if (isset($error_message) && $error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        <?php if (isset($success_message) && $success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>

        <!-- Button Section: Separate from the table -->
        <div class="mb-3">
            <a href="add_course.php" class="btn btn-success">Tambah Kursus</a>
            <!-- Menambahkan tombol "Lihat Pengguna Terdaftar" -->
            <a href="views_user.php" class="btn btn-info">Lihat Pengguna Terdaftar</a>
        </div>

        <!-- Table displaying course list -->
        <div class="table-responsive">
            <table id="courses_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kursus</th>
                        <th>Deskripsi</th>
                        <th>Gambar Sampul</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($course = $result_courses->fetch_assoc()): ?>
                        <tr>
                            <td><?= $course['id'] ?></td>
                            <td><?= $course['title'] ?></td> 
                            <td><?= $course['description'] ?></td> 
                            <td>
                                <?php if ($course['image_url']): ?>
                                    <img src="../../assets/images/<?= $course['image_url'] ?>" alt="Gambar Sampul" width="100">
                                <?php else: ?>
                                    <span>No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d-m-Y', strtotime($course['created_at'])) ?></td>
                            <td>
                                <!-- Button Edit -->
                                <a href="edit_course.php?id=<?= $course['id'] ?>" class="btn btn-warning">Edit</a>

                                <!-- Button Hapus -->
                                <a href="?delete_course_id=<?= $course['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kursus ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            $('#courses_table').DataTable();
        });
    </script>
</body>
</html>
