<?php
require_once 'config/database.php';

// Ambil 1 berita terbaru sebagai headline
$beritaUtama = mysqli_query($conn, "SELECT * FROM tb_berita ORDER BY id_berita DESC LIMIT 1");
$utama = mysqli_fetch_assoc($beritaUtama);

// Ambil 5 berita terbaru untuk sidebar
$beritaSidebar = mysqli_query($conn, "SELECT * FROM tb_berita ORDER BY id_berita DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Berita & Informasi Tempat Wisata - DIBALI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">DIBALI</a>
  </div>
</nav>

<div class="container mt-4">
  <h3 class="fw-bold mb-4">Berita & Informasi Tempat Wisata</h3>
  <div class="row">
    
    <!-- Kolom Kiri: Berita utama -->
    <div class="col-lg-8">
      <div class="mb-5">
        <?php if ($utama): ?>
          <?php
          $gambarUtamaQuery = mysqli_query($conn, "SELECT gambar FROM tb_gambar WHERE id_berita = {$utama['id_berita']} LIMIT 1");
          $gambarUtamaData = mysqli_fetch_assoc($gambarUtamaQuery);
          $gambarUtama = $gambarUtamaData ? $gambarUtamaData['gambar'] : 'default.jpg';
          ?>
          <h4 class="fw-bold"><?= htmlspecialchars($utama['judul']) ?></h4>
          <img src="asset/img/berita/<?= htmlspecialchars($gambarUtama) ?>" class="img-fluid rounded mb-3" alt="Gambar Berita Utama">
          <p><?= nl2br(htmlspecialchars(substr($utama['isi'], 0, 500))) ?>...</p>
          <a href="view/berita.php?type=berita&id=<?= $utama['id_berita'] ?>" class="btn btn-primary mt-3">Lihat Selengkapnya</a>
        <?php else: ?>
          <p>Belum ada berita untuk ditampilkan.</p>
        <?php endif; ?>
      </div>
    </div>
    <!-- Kolom Kanan: Berita lainnya -->
    <div class="col-lg-4">
      <h5 class="mb-3">Berita Lainnya</h5>
      <?php while ($data = mysqli_fetch_assoc($beritaSidebar)): ?>
        <?php
        $gambarQuery = mysqli_query($conn, "SELECT gambar FROM tb_gambar WHERE id_berita = {$data['id_berita']} LIMIT 1");
        $gambarData = mysqli_fetch_assoc($gambarQuery);
        $gambar = $gambarData ? $gambarData['gambar'] : 'default.jpg';
        ?>
        <div class="d-flex mb-3 border-bottom pb-2">
          <img src="asset/img/berita/<?= htmlspecialchars($gambar) ?>" width="80" height="80" class="me-2 rounded" alt="Gambar Berita">
          <div>
            <a href="view/berita.php?type=berita&id=<?= $data['id_berita'] ?>" class="text-decoration-none fw-bold text-primary">
              <?= htmlspecialchars($data['judul']) ?>
            </a>
            <div class="text-muted small">Dipublikasikan: <?= date('d M Y', strtotime($data['tanggal'])) ?></div>
            <p class="mb-0"><?= htmlspecialchars(substr($data['isi'], 0, 80)) ?>...</p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
