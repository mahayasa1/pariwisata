<?php
require_once '../../../config/database.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_pemesanan WHERE id_pemesanan = $id"));

$pengunjung = mysqli_query($conn, "SELECT * FROM tb_pengunjung");
$tempat = mysqli_query($conn, "SELECT * FROM tempat_wisata");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengunjung = $_POST['id_pengunjung'];
    $id_tempat = $_POST['id_tempat'];
    $tanggal = $_POST['tanggal'];
    $jumlah_tiket = $_POST['jumlah_tiket'];

    $harga = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga_tiket FROM tempat_wisata WHERE id_tempat = $id_tempat"))['harga_tiket'];
    $total_harga = $harga * $jumlah_tiket;

    mysqli_query($conn, "UPDATE tb_pemesanan SET 
        id_pengunjung='$id_pengunjung', 
        id_tempat='$id_tempat', 
        tanggal='$tanggal', 
        jumlah_tiket='$jumlah_tiket', 
        total_harga='$total_harga'
        WHERE id_pemesanan=$id");

    header("Location: ../../../view/admin/booking.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">
<div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
    <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
    <h2>Edit Pemesanan</h2>
    <form method="post">
        <div class="mb-3">
            <label>Pengunjung</label>
            <select name="id_pengunjung" class="form-select" required>
                <?php while ($p = mysqli_fetch_assoc($pengunjung)) : ?>
                    <option value="<?= $p['id_pengunjung'] ?>" <?= $p['id_pengunjung'] == $data['id_pengunjung'] ? 'selected' : '' ?>>
                        <?= $p['nama'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Tempat Wisata</label>
            <select name="id_tempat" class="form-select" required>
                <?php while ($t = mysqli_fetch_assoc($tempat)) : ?>
                    <option value="<?= $t['id_tempat'] ?>" <?= $t['id_tempat'] == $data['id_tempat'] ? 'selected' : '' ?>>
                        <?= $t['nama_tempat'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Jumlah Tiket</label>
            <input type="number" name="jumlah_tiket" class="form-control" value="<?= $data['jumlah_tiket'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
    </div>
</div>
</body>
</html>
