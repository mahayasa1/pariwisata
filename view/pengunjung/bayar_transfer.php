<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'pengunjung') {
    echo "<script>alert('Akses ditolak!'); window.location='../../auth/login_pengunjung.php';</script>";
    exit;
}

$id_pemesanan = $_GET['id'] ?? null;
if (!$id_pemesanan) {
    echo "<script>alert('ID Pemesanan tidak valid.'); window.location='index.php';</script>";
    exit;
}

// Ambil detail pemesanan
$query = mysqli_query($conn, "
    SELECT p.*, t.nama_tempat 
    FROM tb_pemesanan p
    JOIN tempat_wisata t ON p.id_tempat = t.id_tempat
    WHERE p.id_pemesanan = $id_pemesanan
");
$pemesanan = mysqli_fetch_assoc($query);

if (!$pemesanan) {
    echo "<script>alert('Pemesanan tidak ditemukan.'); window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Transfer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Instruksi Pembayaran Transfer Bank</h2>
    <div class="card p-4 shadow mt-3">
        <p><strong>Tempat Wisata:</strong> <?= $pemesanan['nama_tempat'] ?></p>
        <p><strong>Jumlah Pembayaran:</strong> Rp<?= number_format($pemesanan['total_harga'], 2, ',', '.') ?></p>
        <hr>
        <h5>Transfer ke rekening berikut:</h5>
        <p><strong>Bank:</strong> BCA</p>
        <p><strong>No. Rekening:</strong> 1234567890</p>
        <p><strong>Atas Nama:</strong> PT Wisata Nusantara</p>
        <hr>
        <form action="upload_bukti.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_pemesanan" value="<?= $id_pemesanan ?>">
            <div class="mb-3">
                <label for="bukti" class="form-label">Upload Bukti Transfer</label>
                <input type="file" name="bukti" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Bukti</button>
            <a href="transaksi.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
</body>
</html>
