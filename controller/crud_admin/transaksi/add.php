<?php
require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pemesanan = $_POST['id_pemesanan'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $total_harga = $_POST['total_harga'];
    $status = $_POST['status'];

    $query = mysqli_query($conn, "INSERT INTO tb_transaksi (id_pemesanan, tanggal_transaksi, total_harga, status) 
        VALUES ('$id_pemesanan', '$tanggal_transaksi', '$total_harga', '$status')");

    if ($query) {
        header("Location: ../../../view/admin/transaksi.php");
    } else {
        echo "Gagal menambah data.";
    }
}

$pemesanan = mysqli_query($conn, "SELECT p.id_pemesanan, pg.nama, w.nama_tempat FROM tb_pemesanan p 
    JOIN tb_pengunjung pg ON p.id_pengunjung = pg.id_pengunjung 
    JOIN tempat_wisata w ON p.id_tempat = w.id_tempat");
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Transaksi</title>
</head>
<body class="bg-dark">
<div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
    <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label>ID Pemesanan</label>
            <select name="id_pemesanan" class="form-control" required>
                <option value="">-- Pilih Pemesanan --</option>
                <?php while ($data = $pemesanan->fetch_assoc()): ?>
                    <option value="<?= $data['id_pemesanan'] ?>">
                        <?= $data['nama'] ?> - <?= $data['nama_tempat'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Total Harga</label>
            <input type="number" name="total_harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="lunas">Lunas</option>
                <option value="belum lunas">Belum Lunas</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="../../../view/admin/transaksi.php" class="btn btn-secondary">Kembali</a>
    </form>
    </div>
</div>
</body>
</html>
