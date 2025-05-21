<?php
require_once '../../config/database.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login/login_pengunjung.php");
    exit();
}
$query = mysqli_query($conn, "SELECT * FROM tempat_wisata");
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Tempat Wisata</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
            <img src="../../asset/img/destinasi/<?= $row['gambar'] ?>" class="img-fluid rounded-start" alt="<?= $row['nama_tempat'] ?>">
          </div>
          <div class="col-md-8">
            <div class="p-2">
              <h6 class="mb-1 fw-bold">
                <a href="berita.php?id=<?= $row['id_tempat'] ?>" class="text-decoration-none"><?= $row['nama_tempat'] ?></a>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
