<?php
require_once 'config/database.php';
$query = mysqli_query($conn, "SELECT * FROM tempat_wisata ORDER BY id_tempat DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Berita Tempat Wisata - DIBALI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">DIBALI</a>
  </div>
</nav>

<!-- Container -->
<div class="container mt-4">
  <h3 class="fw-bold mb-4">Berita & Informasi Tempat Wisata</h3>

  <div class="row">
    <!-- Bagian kiri: daftar berita utama -->
    <div class="col-lg-8">
      <?php while($row = mysqli_fetch_assoc($query)): ?>
        <div class="d-flex mb-4">
          <img src="asset/img/destinasi/<?= $row['gambar'] ?>" width="150" height="150" class="me-3" alt="gambar">
          <div>
            <a href="view/berita.php?id=<?= $row['id_tempat'] ?>" class="text-decoration-none fw-bold text-primary">
              <?= $row['nama_tempat'] ?>
            </a>
            <div class="text-muted mb-1">Dipublikasikan: <?= date('d M Y') ?></div>
            <p><?= substr($row['deskripsi'], 0, 150) ?>...</p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Bagian kanan: daftar berita lainnya -->
    <div class="col-lg-4">
      <h5 class="mb-3">Berita Lainnya</h5>
      <?php
      $queryRight = mysqli_query($conn, "SELECT * FROM tempat_wisata ORDER BY id_tempat DESC LIMIT 5, 10");
      while($data = mysqli_fetch_assoc($queryRight)):
      ?>
        <div class="mb-3">
          <a href="view/berita.php?id=<?= $data['id_tempat'] ?>" class="text-decoration-none fw-bold"><?= $data['nama_tempat'] ?></a><br>
          <small class="text-muted"><?= date('d M Y') ?></small>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
