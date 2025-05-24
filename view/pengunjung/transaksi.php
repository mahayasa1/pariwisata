<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'pengunjung') {
    echo "<script>alert('Akses ditolak!'); window.location='../../auth/login_pengunjung.php';</script>";
    exit;
}


$username = $_SESSION['username'];
$getUser = mysqli_query($conn, "SELECT * FROM tb_pengunjung WHERE username = '$username'");
$user = mysqli_fetch_assoc($getUser);
$id_pengunjung = $user['id_pengunjung'];

// Ambil pemesanan terbaru user
$getPemesanan = mysqli_query($conn, "
    SELECT p.*, t.nama_tempat 
    FROM tb_pemesanan p
    JOIN tempat_wisata t ON p.id_tempat = t.id_tempat
    WHERE p.id_pengunjung = $id_pengunjung 
    ORDER BY p.id_pemesanan DESC LIMIT 1
");

$pemesanan = mysqli_fetch_assoc($getPemesanan);

if (!$pemesanan) {
    echo "<script>alert('Tidak ada pemesanan yang ditemukan!'); window.location='index.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $id_pemesanan = $pemesanan['id_pemesanan'];
    $tanggal_transaksi = date('Y-m-d');
    $total_harga = $pemesanan['total_harga'];
    $status = 'belum lunas';

    $insert = mysqli_query($conn, "INSERT INTO tb_transaksi 
        (id_pemesanan, tanggal_transaksi, total_harga, status) 
        VALUES 
        ($id_pemesanan, '$tanggal_transaksi', $total_harga, '$status')
    ");

    if ($insert) {
        echo "<script>alert('Transaksi berhasil disimpan. Silakan selesaikan pembayaran.'); window.location='riwayat_pesanan.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan transaksi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Transaksi Pembayaran</h2>
    <div class="card shadow p-4 mt-4">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Tempat Wisata</label>
                <input type="text" class="form-control" value="<?= $pemesanan['nama_tempat'] ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Pemesanan</label>
                <input type="text" class="form-control" value="<?= $pemesanan['tanggal'] ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Tiket</label>
                <input type="text" class="form-control" value="<?= $pemesanan['jumlah_tiket'] ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Total Harga</label>
                <input type="text" class="form-control" value="Rp<?= number_format($pemesanan['total_harga'], 2, ',', '.') ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Metode --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
</body>
</html>
