<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'pengunjung') {
    echo "<script>alert('Akses ditolak!'); window.location='../../auth/login_pengunjung.php';</script>";
    exit;
}

$id_pemesanan = $_GET['id'] ?? null;
if (!$id_pemesanan) {
    echo "<script>alert('ID pemesanan tidak valid.'); window.location='index.php';</script>";
    exit;
}

// Ambil data pemesanan & transaksi
$data = mysqli_query($conn, "
    SELECT p.*, t.nama_tempat, tr.tanggal_transaksi, tr.status AS status_transaksi, u.nama
    FROM tb_pemesanan p
    JOIN tempat_wisata t ON p.id_tempat = t.id_tempat
    JOIN tb_pengunjung u ON p.id_pengunjung = u.id_pengunjung
    LEFT JOIN tb_transaksi tr ON tr.id_pemesanan = p.id_pemesanan
    WHERE p.id_pemesanan = $id_pemesanan
");

$pemesanan = mysqli_fetch_assoc($data);

if (!$pemesanan) {
    echo "<script>alert('Data tidak ditemukan.'); window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tiket Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .ticket {
            width: 650px;
            margin: 30px auto;
            padding: 20px;
            border: 3px dashed #198754;
            border-radius: 15px;
            background: white;
            position: relative;
        }
        .ticket::before, .ticket::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            border: 3px solid #198754;
        }
        .ticket::before {
            top: -25px;
            left: 20px;
        }
        .ticket::after {
            bottom: -25px;
            right: 20px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="ticket shadow">
    <h4 class="text-center text-success fw-bold">Tiket Wisata</h4>
    <hr>
    <div class="row">
        <div class="col-8">
            <p><strong>Nama Pengunjung:</strong> <?= $pemesanan['nama'] ?></p>
            <p><strong>Tempat Wisata:</strong> <?= $pemesanan['nama_tempat'] ?></p>
            <p><strong>Tanggal Kunjungan:</strong> <?= $pemesanan['tanggal'] ?></p>
            <p><strong>Jumlah Tiket:</strong> <?= $pemesanan['jumlah_tiket'] ?> tiket</p>
            <p><strong>Total Bayar:</strong> Rp<?= number_format($pemesanan['total_harga'], 2, ',', '.') ?></p>
            <p><strong>Status:</strong>
                <?php
                $status = $pemesanan['status_transaksi'];
                if ($status == 'lunas') echo "<span class='badge bg-success'>Lunas</span>";
                elseif ($status == 'menunggu verifikasi') echo "<span class='badge bg-warning text-dark'>Menunggu Verifikasi</span>";
                else echo "<span class='badge bg-danger'>Belum Lunas</span>";
                ?>
            </p>
        </div>
        <div class="col-4 text-end">
            <small class="text-muted">Kode Tiket: <?= str_pad($pemesanan['id_pemesanan'], 6, '0', STR_PAD_LEFT) ?></small>
        </div>
    </div>
    <hr>
    <p class="text-center text-muted">Tunjukkan tiket ini ke petugas wisata saat masuk.</p>
</div>

<div class="text-center no-print mb-5">
    <button class="btn btn-primary" onclick="window.print()">🖨 Cetak Tiket</button>
    <a href="riwayat_pesanan.php" class="btn btn-secondary">Kembali</a>
</div>

</body>
</html>