<?php
session_start(); // harus paling atas sebelum output HTML
require_once '../../config/database.php';


$id_tempat = $_GET['id'];
$tempat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tempat_wisata WHERE id_tempat=$id_tempat"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengunjung = $_SESSION['id_pengunjung'];
    $tanggal = $_POST['tanggal'];
    $jumlah = $_POST['jumlah_tiket'];
    $total = $tempat['harga_tiket'] * $jumlah;

    $query = "INSERT INTO tb_pemesanan (id_pengunjung, id_tempat, tanggal, jumlah_tiket, total_harga)
              VALUES ('$id_pengunjung', '$id_tempat', '$tanggal', '$jumlah', '$total')";

    mysqli_query($conn, $query) or die(mysqli_error($conn));

    header("Location: transaksi.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Booking Tempat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Booking: <?= $tempat['nama_tempat'] ?></h2>
  <form method="post">
    <div class="mb-3">
      <label for="tanggal" class="form-label">Tanggal Kunjungan</label>
      <input type="date" class="form-control" name="tanggal" required>
    </div>
    <div class="mb-3">
      <label for="jumlah_tiket" class="form-label">Jumlah Tiket</label>
      <input type="number" class="form-control" name="jumlah_tiket" min="1" required>
    </div>
    <button type="submit" class="btn btn-success">Booking Sekarang</button>
  </form>
</div>
</body>
</html>
