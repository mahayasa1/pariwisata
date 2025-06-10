<?php
session_start();
include_once "../../config/database.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../../controller/auth/login/login_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Statistik Pengunjung per Tempat Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">DIBALI</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="destinasi.php">Destinasi</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        User
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="user.php">User</a></li>
                        <li><a class="dropdown-item" href="pengunjung.php">Pengunjung</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="transaksi.php">Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="booking.php">Booking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="berita.php">Berita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="statistik.php">Statistik</a>
                </li>
            </ul>
            <div class="d-flex">
                <span class="navbar-text text-white me-3"><?php echo $_SESSION['username']; ?></span>
                <form action="../../controller/auth/logout/logout_admin.php" method="post">
                    <button type="submit" name="logout" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h2 class="mb-4">📊 Statistik Pengunjung per Tempat Wisata</h2>

    <a href="excel.php" class="btn btn-success mb-3">📤 Export ke Excel</a>

    <!-- Statistik Harian -->
    <h4>📅 Statistik Harian</h4>
    <table class="table table-bordered">
    <thead>
        <tr>
        <th>Tanggal</th>
        <th>Tempat Wisata</th>
        <th>Total Pengunjung</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $harian = $conn->query("SELECT tanggal, tempat_wisata.nama_tempat, SUM(tb_pemesanan.jumlah_tiket) AS total FROM tb_pemesanan JOIN tempat_wisata ON tb_pemesanan.id_tempat = tempat_wisata.id_tempat GROUP BY tanggal, tb_pemesanan.id_tempat ORDER BY tanggal DESC, tempat_wisata.nama_tempat ASC");
    while ($row = $harian->fetch_assoc()): ?>
        <tr>
            <td><?=$row['tanggal']?></td>
            <td><?=$row['nama_tempat']?></td>
            <td><?=$row['total']?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Statistik Bulanan -->
  <h4>🗓️ Statistik Bulanan</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Bulan</th>
        <th>Tempat Wisata</th>
        <th>Total Pengunjung</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $bulanan = $conn->query("SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, tempat_wisata.nama_tempat, SUM(tb_pemesanan.jumlah_tiket) AS total FROM tb_pemesanan JOIN tempat_wisata ON tb_pemesanan.id_tempat = tempat_wisata.id_tempat GROUP BY bulan, tb_pemesanan.id_tempat ORDER BY bulan DESC, tempat_wisata.nama_tempat ASC");
    while ($row = $bulanan->fetch_assoc()) : ?>
        <tr>
            <td><?=$row['bulan']?></td>
            <td><?=$row['nama_tempat']?></td>
            <td><?=$row['total']?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>
</body>
</html>