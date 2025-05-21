<?php
require_once '../../config/database.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login/login_pengunjung.php");
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM tempat_wisata WHERE id_tempat = $id");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $data['nama_tempat'] ?> - DIBALI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="berita.php">DIBALI</a>
  </div>
</nav> -->

<!-- Content -->
<div class="container">
  <div class="row">
    <div class="col-12 mb-4">
      <h3 class="fw-bold"><?= $data['nama_tempat'] ?></h3>
      <small class="text-muted">Dipublikasikan: <?= date('d M Y') ?></small>
    </div>

    <div class="col-12 mb-3">
      <img src="../../asset/img/destinasi/<?= $data['gambar'] ?>" class="img-fluid" alt="Gambar Tempat Wisata">
    </div>

    <div class="col-12">
      <p><?= nl2br($data['deskripsi']) ?></p>
      <a href="booking.php?id=<?=$data['id_tempat']?>" class="btn btn-primary mt-3">Booking Sekarang</a>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
