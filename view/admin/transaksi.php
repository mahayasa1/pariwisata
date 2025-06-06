<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../controller/auth/login/login_admin.php");
    exit();
}

// Ambil data transaksi lengkap dengan info pemesanan, pengunjung dan tempat
$query = mysqli_query($conn, "
    SELECT t.id_transaksi, t.tanggal_transaksi, t.total_harga, t.status,
            p.id_pemesanan, p.tanggal AS tanggal_pemesanan, p.jumlah_tiket,
            w.nama_tempat, peng.nama AS nama_pengunjung
    FROM tb_transaksi t
    JOIN tb_pemesanan p ON t.id_pemesanan = p.id_pemesanan
    JOIN tb_pengunjung peng ON p.id_pengunjung = peng.id_pengunjung
    JOIN tempat_wisata w ON p.id_tempat = w.id_tempat
");



// Proses update status transaksi jika form disubmit

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transaksi = $_POST['id_transaksi'];

    // Update status ke 'lunas'
    $query = mysqli_query($conn, "UPDATE tb_transaksi SET status='lunas' WHERE id_transaksi = $id_transaksi");

    if ($query) {
        echo "<script>alert('Status berhasil diubah menjadi lunas'); window.location='transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah status'); window.location='transaksi.php';</script>";
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Admin</title>
     <style>
    .table-wrapper {
      max-width: 900px;  /* Sesuaikan lebar sesuai keinginan */
      margin: 50px auto;
    }
    th, td {
      vertical-align: middle !important;
    }
  </style>  
<body>
    <!-- Navbar -->
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
                <a class="nav-link active" href="transaksi.php">Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="booking.php">Booking</a>
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

    <div class="table-wrapper">
        <h2 class="text-center mb-4">Data Transaksi</h2>
        <a href="../../controller/crud_admin/transaksi/add.php" class="btn btn-primary mb-3">Tambah Data Transaksi</a>
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Pengunjung</th>
                    <th>Tempat Wisata</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jumlah Tiket</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_pengunjung'] ?></td>
                    <td><?= $row['nama_tempat'] ?></td>
                    <td><?= $row['tanggal_transaksi'] ?></td>
                    <td><?= $row['jumlah_tiket'] ?></td>
                    <td>Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge bg-<?= $row['status'] == 'lunas' ? 'success' : 'warning' ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>

                        <?php if ($row['status'] == 'belum lunas' || $row['status'] == 'menunggu verifikasi'): ?>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Verifikasi</button>
                            </form>
                        <?php endif; ?>

                    </td>
                    <td>
                        <a href="../../controller./crud_admin/transaksi/update.php?id=<?= $row['id_transaksi'] ?>" class="btn btn-warning btn-sm mb-1">Edit</a><br>
                        <a href="../../controller/crud_admin/transaksi/delete.php?id=<?= $row['id_transaksi'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus transaksi ini?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>