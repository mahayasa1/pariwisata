<?php
require_once '../../config/database.php';
session_start();

$id_pengunjung = $_SESSION['id_pengunjung'];
$query = mysqli_query($conn, "SELECT p.*, t.nama_tempat FROM tb_pemesanan p
JOIN tempat_wisata t ON p.id_tempat = t.id_tempat
WHERE p.id_pengunjung = $id_pengunjung");
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Transaksi Anda</h2>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Tempat</th>
        <th>Tanggal</th>
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
        <td><?= $row['nama_tempat'] ?></td>
        <td><?= $row['tanggal'] ?></td>
        <td><?= $row['jumlah_tiket'] ?></td>
        <td>Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></td>
        <?php
        $cek = mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE id_pemesanan = " . $row['id_pemesanan']);
        $trx = mysqli_fetch_assoc($cek);
        ?>
        <td><?= $trx ? $trx['status'] : 'Belum Bayar' ?></td>
        <td>
          <?php if (!$trx): ?>
            <a href="bayar.php?id=<?= $row['id_pemesanan'] ?>" class="btn btn-primary btn-sm">Bayar</a>
          <?php else: ?>
            <span class="text-success">Lunas</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
