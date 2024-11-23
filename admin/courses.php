<?php
session_start();
include('../includes/db_connect.php');

// Pastikan pengguna adalah admin
if (!isset($_SESSION['id_pengguna']) || $_SESSION['peran'] != 'admin') {
    header('Location: ../pages/login.php');
    exit();
}

// Menambahkan kursus baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_course'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $id_kategori = $_POST['id_kategori'];
    $id_pengajar = $_POST['id_pengajar'];

    // Query untuk menambahkan kursus
    $query = "INSERT INTO Kursus (judul, deskripsi, harga, id_kategori, id_pengajar)
              VALUES ('$judul', '$deskripsi', '$harga', '$id_kategori', '$id_pengajar')";
    
    if (mysqli_query($conn, $query)) {
        $message = "Kursus berhasil ditambahkan!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Mengupdate kursus
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_course'])) {
    $id_kursus = $_POST['id_kursus'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $id_kategori = $_POST['id_kategori'];
    $id_pengajar = $_POST['id_pengajar'];

    // Query untuk mengupdate kursus
    $query = "UPDATE Kursus SET judul = '$judul', deskripsi = '$deskripsi', harga = '$harga', id_kategori = '$id_kategori', id_pengajar = '$id_pengajar' WHERE id_kursus = '$id_kursus'";
    
    if (mysqli_query($conn, $query)) {
        $message = "Kursus berhasil diperbarui!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Menghapus kursus
if (isset($_GET['delete'])) {
    $id_kursus = $_GET['delete'];
    
    // Query untuk menghapus kursus
    $query = "DELETE FROM Kursus WHERE id_kursus = '$id_kursus'";
    
    if (mysqli_query($conn, $query)) {
        $message = "Kursus berhasil dihapus!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Query untuk menampilkan daftar kursus
$query = "SELECT * FROM Kursus";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kursus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2>Manajemen Kursus</h2>
        
        <!-- Pesan Informasi -->
        <?php
        if (isset($message)) {
            echo "<div class='alert alert-info'>$message</div>";
        }
        ?>

        <!-- Form untuk menambahkan kursus -->
        <h3>Tambah Kursus Baru</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Kursus</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="mb-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select class="form-control" id="id_kategori" name="id_kategori" required>
                    <!-- Query kategori akan ditambahkan disini -->
                    <?php
                    $kategori_query = "SELECT * FROM Kategori";
                    $kategori_result = mysqli_query($conn, $kategori_query);
                    while ($kategori = mysqli_fetch_assoc($kategori_result)) {
                        echo "<option value='".$kategori['id_kategori']."'>".$kategori['nama']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_pengajar" class="form-label">Pengajar</label>
                <select class="form-control" id="id_pengajar" name="id_pengajar" required>
                    <!-- Query pengguna yang berperan sebagai pengajar akan ditambahkan disini -->
                    <?php
                    $pengajar_query = "SELECT * FROM Pengguna WHERE peran = 'pengajar'";
                    $pengajar_result = mysqli_query($conn, $pengajar_query);
                    while ($pengajar = mysqli_fetch_assoc($pengajar_result)) {
                        echo "<option value='".$pengajar['id_pengguna']."'>".$pengajar['nama']."</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="add_course">Tambah Kursus</button>
        </form>

        <hr>

        <!-- Daftar Kursus -->
        <h3>Daftar Kursus</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Pengajar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($kursus = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $kursus['id_kursus']; ?></td>
                    <td><?php echo $kursus['judul']; ?></td>
                    <td><?php echo substr($kursus['deskripsi'], 0, 50) . '...'; ?></td>
                    <td><?php echo $kursus['harga']; ?></td>
                    <td>
                        <?php
                        $kategori_query = "SELECT nama FROM Kategori WHERE id_kategori = '".$kursus['id_kategori']."'";
                        $kategori_result = mysqli_query($conn, $kategori_query);
                        $kategori = mysqli_fetch_assoc($kategori_result);
                        echo $kategori['nama'];
                        ?>
                    </td>
                    <td>
                        <?php
                        $pengajar_query = "SELECT nama FROM Pengguna WHERE id_pengguna = '".$kursus['id_pengajar']."'";
                        $pengajar_result = mysqli_query($conn, $pengajar_query);
                        $pengajar = mysqli_fetch_assoc($pengajar_result);
                        echo $pengajar['nama'];
                        ?>
                    </td>
                    <td>
                        <a href="courses.php?edit=<?php echo $kursus['id_kursus']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="courses.php?delete=<?php echo $kursus['id_kursus']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kursus ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
