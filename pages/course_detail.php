<?php
session_start();
include('../includes/db_connect.php');

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header('Location: login.php');
    exit();
}

// Periksa apakah id_kursus ada di URL
if (!isset($_GET['id_kursus']) || empty($_GET['id_kursus'])) {
    echo "ID kursus tidak ditemukan.";
    exit();
}

$id_kursus = $_GET['id_kursus'];

// Mendapatkan detail kursus
$query = "SELECT * FROM Kursus WHERE id_kursus = '$id_kursus'";
$result = mysqli_query($conn, $query);

// Periksa apakah kursus ditemukan
if (mysqli_num_rows($result) == 0) {
    echo "Kursus tidak ditemukan.";
    exit();
}

$kursus = mysqli_fetch_assoc($result);

// Mendapatkan materi kursus
$content_query = "SELECT * FROM Konten WHERE id_kursus = '$id_kursus'";
$content_result = mysqli_query($conn, $content_query);

// Proses untuk menandai kemajuan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mark_as_completed'])) {
    $id_konten = $_POST['id_konten'];
    $id_pengguna = $_SESSION['id_pengguna'];

    // Cek apakah sudah ada kemajuan untuk materi ini
    $check_query = "SELECT * FROM Kemajuan WHERE id_pengguna = '$id_pengguna' AND id_konten = '$id_konten'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        // Jika belum ada, insert kemajuan
        $insert_query = "INSERT INTO Kemajuan (id_pengguna, id_kursus, id_konten, status_selesai) 
                         VALUES ('$id_pengguna', '$id_kursus', '$id_konten', TRUE)";
        if (mysqli_query($conn, $insert_query)) {
            echo "Kemajuan berhasil ditandai!";
        } else {
            echo "Terjadi kesalahan saat menandai kemajuan.";
        }
    } else {
        echo "Kemajuan sudah ditandai sebelumnya.";
    }
}
?>

<!-- HTML untuk menampilkan detail kursus dan materi -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kursus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2>Detail Kursus: <?php echo $kursus['judul']; ?></h2>

        <p><strong>Deskripsi: </strong><?php echo $kursus['deskripsi']; ?></p>
        <p><strong>Harga: </strong>Rp <?php echo number_format($kursus['harga'], 0, ',', '.'); ?></p>
        <p><strong>Kategori: </strong>
            <?php
            $kategori_query = "SELECT nama FROM Kategori WHERE id_kategori = '".$kursus['id_kategori']."'";
            $kategori_result = mysqli_query($conn, $kategori_query);
            $kategori = mysqli_fetch_assoc($kategori_result);
            echo $kategori['nama'];
            ?>
        </p>

        <h3>Materi Pembelajaran</h3>
        <ul>
            <?php while ($konten = mysqli_fetch_assoc($content_result)): ?>
                <li>
                    <?php echo $konten['judul']; ?> (<?php echo ucfirst($konten['tipe']); ?>)
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id_konten" value="<?php echo $konten['id_konten']; ?>">
                        <button type="submit" name="mark_as_completed" class="btn btn-sm btn-success">Mark as Completed</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
