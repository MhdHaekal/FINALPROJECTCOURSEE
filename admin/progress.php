<?php
include 'config/db.php';

// Query untuk mendapatkan data progres siswa dari tabel yang sesuai
$progress = $pdo->query("
    SELECT 
        pk.id_pendaftaran AS id,
        p.nama_lengkap AS student_name,
        k.judul AS course_title,
        pk.persentase_progres AS progress_percentage
    FROM pendaftaran_kursus pk
    JOIN pengguna p ON pk.id_pengguna = p.id_pengguna
    JOIN kursus k ON pk.id_kursus = k.id_kursus
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Progress</title>
</head>
<body>
    <h1>Student Progress</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Course</th>
            <th>Progress (%)</th>
        </tr>
        <?php foreach ($progress as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['student_name']) ?></td>
            <td><?= htmlspecialchars($p['course_title']) ?></td>
            <td><?= htmlspecialchars($p['progress_percentage']) ?>%</td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
