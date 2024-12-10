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

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses penambahan kursus
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $instructor_id = $_SESSION['user_id'];

    // Upload gambar sampul
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $image = $_FILES['image'];
        $image_name = time() . '_' . basename($image['name']);
        $image_tmp_name = $image['tmp_name'];
        $image_upload_path = '../../assets/images/' . $image_name;
        
        if (move_uploaded_file($image_tmp_name, $image_upload_path)) {
            $image_url = $image_name;  // Simpan nama file gambar
        } else {
            $error_message = 'Gagal mengunggah gambar sampul!';
        }
    }

    // Upload file materi kursus
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
        $file = $_FILES['file'];
        $file_name = time() . '_' . basename($file['name']);
        $file_tmp_name = $file['tmp_name'];
        $file_upload_path = '../../assets/files/' . $file_name;

        if (move_uploaded_file($file_tmp_name, $file_upload_path)) {
            $file_url = $file_name;  // Simpan nama file
        } else {
            $error_message = 'Gagal mengunggah file!';
        }
    }

    // Ambil materi teks
    $text_material = isset($_POST['text_material']) ? $_POST['text_material'] : '';

    // Insert data kursus ke tabel courses
    if (empty($error_message)) {
        // Masukkan data kursus ke tabel courses
        $query = "INSERT INTO courses (title, description, image_url, file_url, instructor_id) 
                  VALUES (?, ?, ?, ?, ?)";  // Hapus bagian video_url dari query
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die('Query Error: ' . mysqli_error($conn));  // Menangkap error jika query gagal
        }

        $stmt->bind_param("ssssi", $title, $description, $image_url, $file_url, $instructor_id);  // Hapus video_url dari bind_param
        if ($stmt->execute()) {
            $course_id = $stmt->insert_id;  // Ambil ID kursus yang baru dimasukkan

            // Masukkan materi kursus ke tabel course_materials
            if (!empty($file_url)) {
                $material_query = "INSERT INTO course_materials (course_id, type, content) VALUES (?, 'file', ?)";
                $material_stmt = $conn->prepare($material_query);
                $material_stmt->bind_param("is", $course_id, $file_url);
                $material_stmt->execute();
            }

            // Insert materi teks ke tabel course_materials
            if (!empty($text_material)) {
                $material_query = "INSERT INTO course_materials (course_id, type, content) VALUES (?, 'text', ?)";
                $material_stmt = $conn->prepare($material_query);
                $material_stmt->bind_param("is", $course_id, $text_material);
                $material_stmt->execute();
            }

            $success_message = "Kursus berhasil ditambahkan!";
        } else {
            $error_message = "Gagal menambahkan kursus!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kursus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/add_course.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
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
        <h2>Tambah Kursus</h2>

        <!-- Pesan Error atau Success -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>

        <form method="POST" action="add_course.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Nama Kursus</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Gambar Sampul</label>
                <input type="file" class="form-control" name="image">
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">File Materi Kursus</label>
                <input type="file" class="form-control" name="file">
            </div>

            <!-- Tambahkan input untuk materi teks -->
            <div class="mb-3">
                <label for="text_material" class="form-label">Materi Teks</label>
                <textarea class="form-control" name="text_material" rows="4" placeholder="Masukkan materi teks untuk kursus ini (misal: artikel, modul, dll.)"></textarea>
            </div>

            <button type="submit" class="btn cta-btn">Tambah Kursus</button>
        </form>
        <br/>
        <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali Ke Dashboard</a>
    </div>

    <footer class="footer">
        <p>© 2024 Platform Kursus. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
