<?php
require_once '../../config/database.php';

$id_pemesanan = $_GET['id'];

$pemesanan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_pemesanan WHERE id_pemesanan = $id_pemesanan"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal_transaksi = date('Y-m-d');
    $total_harga = $pemesanan['total_harga'];

    mysqli_query($conn, "INSERT INTO tb_transaksi (id_pemesanan, tanggal_transaksi, total_harga, status)
                         VALUES ('$id_pemesanan', '$tanggal_transaksi', '$total_harga', 'lunas')");

    header("Location: transaksi.php");
}
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Bayar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Pembayaran</h2>
  <p><strong>Total yang harus dibayar:</strong> Rp<?= number_format($pemesanan['total_harga'], 0, ',', '.') ?></p>
  <form method="post">
    <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
  </form>
</div>
</body>
</html>