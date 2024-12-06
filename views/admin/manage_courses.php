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
$query_courses = "SELECT id, title, description FROM courses"; 
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
    <title>Kelola Kursus - Dashboard Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Kelola Kursus</h2>

        <!-- Tampilkan pesan error atau sukses -->
        <?php if (isset($error_message) && $error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        <?php if (isset($success_message) && $success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
            <a href="add_course.php" class="btn btn-success">Tambah Kursus</a>
        </div>

        <!-- Tabel Daftar Kursus -->
        <div class="table-responsive">
            <table id="courses_table" class="table table-striped table-bordered">
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
                            <td><?= $course['title'] ?></td> 
                            <td><?= $course['description'] ?></td> 
                            <td>
                                <!-- Button Edit -->
                                <a href="edit_course.php?id=<?= $course['id'] ?>" class="btn btn-warning">Edit</a>
                                
                                <!-- Button Hapus -->
                                <a href="delete_course.php?id=<?= $course['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kursus ini?')">Hapus</a>
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
