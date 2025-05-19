<?php
require_once '../../../config/database.php';

$pengunjung = mysqli_query($conn, "SELECT * FROM tb_pengunjung");
$tempat = mysqli_query($conn, "SELECT * FROM tempat_wisata");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengunjung = $_POST['id_pengunjung'];
    $id_tempat = $_POST['id_tempat'];
    $tanggal = $_POST['tanggal'];
    $jumlah_tiket = $_POST['jumlah_tiket'];

    $harga = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga_tiket FROM tempat_wisata WHERE id_tempat = $id_tempat"))['harga_tiket'];
    $total_harga = $harga * $jumlah_tiket;

    mysqli_query($conn, "INSERT INTO tb_pemesanan (id_pengunjung, id_tempat, tanggal, jumlah_tiket, total_harga) 
                        VALUES ('$id_pengunjung', '$id_tempat', '$tanggal', '$jumlah_tiket', '$total_harga')");

    header("Location: ../../../view/admin/booking.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Pemesanan</title>
</head>
<body class="bg-dark">
    <div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
        <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4">Tambah Pemesanan</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Pengunjung</label>
                <select name="id_pengunjung" class="form-select" required>
                    <option value="">-- Pilih Pengunjung --</option>
                    <?php while ($p = mysqli_fetch_assoc($pengunjung)) : ?>
                        <option value="<?= $p['id_pengunjung'] ?>"><?= $p['nama'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Tempat Wisata</label>
                <select name="id_tempat" class="form-select" required>
                    <option value="">-- Pilih Tempat --</option>
                    <?php while ($t = mysqli_fetch_assoc($tempat)) : ?>
                        <option value="<?= $t['id_tempat'] ?>"><?= $t['nama_tempat'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Jumlah Tiket</label>
                <input type="number" name="jumlah_tiket" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
        </div>
    </div>
</body>
</html>
