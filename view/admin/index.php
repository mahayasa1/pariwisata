<?php

session_start();

include_once "../../config/database.php";
if (!isset($_SESSION['username'])) {
    header("Location: ../../controller/auth/login/login_admin.php");
    exit();
}

$total_pengunjung = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_pengunjung")->fetch_assoc()['total'];
$total_pariwisata = mysqli_query($conn, "SELECT COUNT(*) as total FROM tempat_wisata")->fetch_assoc()['total'];
$total_transaksi = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_transaksi")->fetch_assoc()['total'];
$total_booking = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_pemesanan")->fetch_assoc()['total'];
$total_berita = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_berita")->fetch_assoc()['total'];

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<title>Dashboard Admin</title>
</head>
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
            <a class="nav-link active" href="index.php">Home</a>
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
      </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search">
          <button class="btn btn-outline-light me-2" type="submit">Search</button>
          <button class="btn btn-outline-light"><a class="text-decoration-none" href="../../controller/auth/logout.php?role=admin">Logout</a></button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
    <!-- Main Content -->
  <div class="container mt-5">
    <div class="text-center mb-4">
      <h1 class="display-5">Dashboard Admin</h1>
      <p class="text-muted">Statistik data saat ini</p>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-info" role="alert">
          Selamat datang, <?= $_SESSION['username'] ?>! Anda telah login sebagai Admin.
        </div>
      </div>

    <!-- Dashboard Cards -->
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 text-center">
          <div class="card-body">
            <h5 class="card-title">Pengunjung</h5>
            <div class="stat-value text-success"><?= $total_pengunjung?></div>
            <div class="stat-label">Total Pengunjung</div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 text-center">
          <div class="card-body">
            <h5 class="card-title">Destinasi</h5>
            <div class="stat-value text-success"><?= $total_pariwisata?></div>
            <div class="stat-label">Tempat Wisata</div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 text-center">
          <div class="card-body">
            <h5 class="card-title">Laporan Transaksi</h5>
            <div class="stat-value text-warning"><?= $total_transaksi?></div>
            <div class="stat-label">Total Transaksi</div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 text-center">
          <div class="card-body">
            <h5 class="card-title">Laporan Booking</h5>
            <div class="stat-value text-danger"><?= $total_booking?></div>
            <div class="stat-label">Total Booking</div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 text-center">
          <div class="card-body">
            <h5 class="card-title">Berita</h5>
            <div class="stat-value text-primary"><?= $total_berita ?></div>
            <div class="stat-label">Total Berita</div>
          </div>
        </div>
      </div>
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
