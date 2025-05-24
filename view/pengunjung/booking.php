<?php
session_start();
require_once '../../config/database.php';

// Cek apakah sudah login dan level pengunjung
if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'pengunjung') {
    echo "<script>alert('Silakan login sebagai pengunjung.'); window.location='../../auth/login_pengunjung.php';</script>";
    exit;
}

$id_pengunjung = $_SESSION['id_pengunjung'];

// Ambil data tempat wisata dari parameter GET
$id_tempat = $_GET['id_tempat'] ?? $_GET['id'] ?? null;
if (!$id_tempat) {
    echo "<script>alert('Tempat wisata tidak ditemukan.'); window.location='../pengunjung/index.php';</script>";
    exit;
}

// Ambil data tempat wisata
$result = mysqli_query($conn, "SELECT * FROM tempat_wisata WHERE id_tempat = $id_tempat");
$tempat = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d');
    $jumlah_tiket = (int) $_POST['jumlah_tiket'];
    $total_harga = $jumlah_tiket * $tempat['harga_tiket'];

    // Simpan ke database
    $query = mysqli_query($conn, "INSERT INTO tb_pemesanan (id_pengunjung, id_tempat, tanggal, jumlah_tiket, total_harga) VALUES ('$id_pengunjung', '$id_tempat', '$tanggal', '$jumlah_tiket', '$total_harga')");

    if ($query) {
        echo "<script>alert('Pemesanan berhasil!'); window.location='transaksi.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memesan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Tempat Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Booking: <?= htmlspecialchars($tempat['nama_tempat']) ?></h2>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Tanggal Kunjungan</label>
            <input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah Tiket</label>
            <input type="number" name="jumlah_tiket" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga Tiket</label>
            <input type="text" class="form-control" value="Rp <?= number_format($tempat['harga_tiket'], 2, ',', '.') ?>" readonly>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Pesan Sekarang</button>
        <a href="../pengunjung/index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
