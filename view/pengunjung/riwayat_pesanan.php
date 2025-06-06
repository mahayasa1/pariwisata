<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'pengunjung') {
    echo "<script>alert('Akses ditolak!'); window.location='../../auth/login_pengunjung.php';</script>";
    exit;
}

// Ambil data pengunjung berdasarkan username login
$username = $_SESSION['username'];
$getUser = mysqli_query($conn, "SELECT * FROM tb_pengunjung WHERE username = '$username'");
$user = mysqli_fetch_assoc($getUser);
$id_pengunjung = $user['id_pengunjung'];

// Ambil riwayat pemesanan
$query = mysqli_query($conn, "
    SELECT 
        tp.id_pemesanan,
        tw.nama_tempat,
        tp.tanggal,
        tp.jumlah_tiket,
        tp.total_harga,
        tt.status,
        tt.tanggal_transaksi
    FROM tb_pemesanan tp
    LEFT JOIN tempat_wisata tw ON tp.id_tempat = tw.id_tempat
    LEFT JOIN tb_transaksi tt ON tp.id_pemesanan = tt.id_pemesanan
    WHERE tp.id_pengunjung = $id_pengunjung
    ORDER BY tp.tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Riwayat Pesanan Anda</h2>
        <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Beranda</a>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tempat Wisata</th>
                    <th>Tanggal Pesan</th>
                    <th>Jumlah Tiket</th>
                    <th>Total Harga</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Transaksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($query) > 0):
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_tempat']) ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['jumlah_tiket'] ?></td>
                    <td>Rp<?= number_format($row['total_harga'], 2, ',', '.') ?></td>
                    <td><?= ucfirst($row['status'] ?? 'Belum Ada') ?></td>
                    <td><?= $row['tanggal_transaksi'] ?? '-' ?></td>
                    <td>
                        <a href="invoice.php?id=<?= $row['id_pemesanan'] ?>" class="btn btn-sm btn-primary" target="_blank">
                            Cetak Invoice
                        </a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="8" class="text-center">Belum ada pesanan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
