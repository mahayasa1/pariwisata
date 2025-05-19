<?php
require_once '../../config/database.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: auth/login/login_pengunjung.php");
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
<div class="container mt-4">
  <h2 class="mb-4 text-center">Daftar Tempat Wisata</h2>
  <div class="row">
    <?php while ($row = mysqli_fetch_assoc($query)): ?>
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="../../asset/img/destinasi/<?= $row['gambar'] ?>" class="card-img-top" height="auto">
          <div class="card-body">
            <h5 class="card-title"><?= $row['nama_tempat'] ?></h5>
            <p class="card-text"><?= substr($row['deskripsi'], 0, 100) ?>...</p>
            <p><strong>Harga Tiket:</strong> Rp<?= number_format($row['harga_tiket'], 0, ',', '.') ?></p>
            <a href="booking.php?id=<?= $row['id_tempat'] ?>" class="btn btn-primary">Booking</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>
