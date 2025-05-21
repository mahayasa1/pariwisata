<?php
require_once 'config/database.php';
$query = mysqli_query($conn, "SELECT * FROM tempat_wisata ORDER BY id_tempat DESC");
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">DIBALI</a>
  </div>
</nav>

<!-- Container -->
<div class="container">
  <h3 class="mb-4 fw-bold">Berita & Informasi Tempat Wisata</h3>

  <div class="row">
    <?php
    $counter = 0;
    while ($row = mysqli_fetch_assoc($query)):
      $counter++;
    ?>
      <div class="col-md-6 mb-4">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="asset/img/destinasi/<?= $row['gambar'] ?>" class="img-fluid rounded-start" alt="<?= $row['nama_tempat'] ?>">
          </div>
          <div class="col-md-8">
            <div class="p-2">
              <h6 class="mb-1 fw-bold">
                <a href="view/berita.php?id=<?= $row['id_tempat'] ?>" class="text-decoration-none"><?= $row['nama_tempat'] ?></a>
              </h6>
              <small class="text-muted d-block mb-1">Dipublikasikan: <?= date('d M Y') ?></small>
              <p class="mb-2"><?= substr(strip_tags($row['deskripsi']), 0, 120) ?>...</p>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>

    <?php if ($counter === 0): ?>
      <div class="col-12">
        <p class="text-muted">Belum ada data tempat wisata.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
