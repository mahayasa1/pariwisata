<?php
require_once '../../../config/database.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM tb_transaksi WHERE id_transaksi = '$id'");
$data = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $total_harga = $_POST['total_harga'];
    $status = $_POST['status'];

    $update = mysqli_query($conn, "UPDATE tb_transaksi SET 
        tanggal_transaksi='$tanggal_transaksi', 
        total_harga='$total_harga', 
        status='$status' 
        WHERE id_transaksi='$id'");

    if ($update) {
        header("Location: ../../../view/admin/transaksi.php");
    } else {
        echo "Gagal mengupdate data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">
    <div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
        <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
            <h2>Edit Transaksi</h2>
            <form method="post">
                <div class="mb-3">
                    <label>Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" class="form-control" value="<?= $data['tanggal_transaksi'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>Total Harga</label>
                    <input type="number" name="total_harga" class="form-control" value="<?= $data['total_harga'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="lunas" <?= $data['status'] == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                        <option value="belum lunas" <?= $data['status'] == 'belum lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>