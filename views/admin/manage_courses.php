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

// Ambil daftar kursus
$query_courses = "SELECT id, title, description FROM courses";  // Ganti 'course_name' dengan 'title' dan 'course_description' dengan 'description'
$result_courses = $conn->query($query_courses);

// Cek jika query gagal
if (!$result_courses) {
    die("Query failed: " . $conn->error); // Menampilkan pesan error jika query gagal
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kursus - Dashboard Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Kelola Kursus</h2>
        <a href="dashboard.php" class="btn btn-primary mb-3">Kembali ke Dashboard</a>
        <a href="add_course.php" class="btn btn-success mb-3">Tambah Kursus</a>

        <!-- Tabel Daftar Kursus -->
        <table id="courses_table" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kursus</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($course = $result_courses->fetch_assoc()): ?>
                    <tr>
                        <td><?= $course['id'] ?></td>
                        <td><?= $course['title'] ?></td> <!-- Ganti course_name dengan title -->
                        <td><?= $course['description'] ?></td> <!-- Ganti course_description dengan description -->
                        <td>
                            <!-- Link untuk menghapus kursus -->
                            <a href="delete_course.php?id=<?= $course['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kursus ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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
