<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../controller/auth/login/login_admin.php");
    exit();
}
require_once '../../config/database.php';

$query = mysqli_query($conn, "SELECT p.*, pg.nama AS nama_pengunjung, tw.nama_tempat 
                            FROM tb_pemesanan p
                            JOIN tb_pengunjung pg ON p.id_pengunjung = pg.id_pengunjung
                            JOIN tempat_wisata tw ON p.id_tempat = tw.id_tempat");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <li><a class="dropdown-item" href="sponsorship.php">Sponsorship</a></li>
            </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transaksi.php">Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="booking.php">Booking</a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="berita.php">Berita</a>
            </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search">
                <button class="btn btn-outline-light me-2" type="submit">Search</button>
                <button class="btn btn-outline-light"><a class="text-decoration-none" href="../../controller/auth/logout.php?role=admin">Logout</a></button>
            </form>
            </div>
        </div>
    </nav>
<div class="container mt-5">
    <h2 class="text-center">Data Pemesanan</h2>
    <a href="../../controller/crud_admin/booking/add.php" class="btn btn-primary mb-3">Tambah Pemesanan</a>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Pengunjung</th>
            <th>Tempat Wisata</th>
            <th>Tanggal</th>
            <th>Jumlah Tiket</th>
            <th>Total Harga</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_pengunjung'] ?></td>
                <td><?= $row['nama_tempat'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['jumlah_tiket'] ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td>
                    <a href="../../controller/crud_admin/booking/update.php?id=<?= $row['id_pemesanan'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="../../controller/crud_admin/booking/delete.php?id=<?= $row['id_pemesanan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
