<?php session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Platform Kursus</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Link Home (Selalu muncul) -->
                <li class="nav-item">
                    <a class="nav-link active" href="home.php">Home</a>
                </li>

                <!-- Link Profile dan Logout hanya muncul jika sudah login -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <!-- Jika belum login, tampilkan Login dan Register -->
                    <li class="nav-item">
                        <a class="nav-link" href="../views/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/register.php">Daftar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
