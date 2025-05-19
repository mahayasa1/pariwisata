<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: auth/login/login_admin.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM tempat_wisata WHERE id_tempat = '$id'");
    $row = mysqli_fetch_assoc($query);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_tempat = $_POST['nama_tempat'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];
    $fasilitas = $_POST['fasilitas'];
    $harga_tiket = $_POST['harga_tiket'];
    $jam_buka = $_POST['jam_buka'];
    $jam_tutup = $_POST['jam_tutup'];

    $gambar_lama = $row['gambar'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];
    $upload_dir = "../../../asset/img/destinasi/";
    $path = $upload_dir . basename($gambar);

    if (!empty($gambar)) {
        if (file_exists($upload_dir . $gambar_lama)) {
            unlink($upload_dir . $gambar_lama);
        }
        if(move_uploaded_file($tmp, $path)){
            $gambar_final = $gambar;
        } else {
            echo "Error uploading file.";
            $gambar_final = $gambar_lama;
        }
        
    } else {
        $gambar_final = $gambar_lama;
    }


    $query = "UPDATE tempat_wisata SET nama_tempat='$nama_tempat', alamat='$alamat', deskripsi='$deskripsi', gambar='$gambar_final', fasilitas='$fasilitas', 
            harga_tiket='$harga_tiket', jam_buka='$jam_buka', jam_tutup='$jam_tutup' WHERE id_tempat='$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: ../../../view/admin/destinasi.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Destinasi</title>
</head>
<body class="bg-dark">
     <div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
        <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4">Edit Destinasi</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="nama_tempat" class="form-label">Nama Destinasi</label>
                    <input type="text" class="form-control" id="nama_tempat" name="nama_tempat" value="<?=$row['nama_tempat']?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?=$row['alamat']?>" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" required><?=$row['deskripsi']?></textarea>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Destinasi</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                    <img src="../../../asset/img/destinasi/<?=$row['gambar']?>" alt="<?=$row['nama_tempat']?>" class="img-thumbnail mt-2" style="max-width: 100%;">
                <div class="mb-3">
                    <label for="fasilitas" class="form-label">Fasilitas</label>
                    <textarea class="form-control" id="fasilitas" name="fasilitas" required><?=$row['fasilitas']?></textarea>
                </div>
                <div class="mb-3">
                    <label for="harga_tiket" class="form-label">Harga Tiket</label>
                    <input type="number" class="form-control" id="harga_tiket" name="harga_tiket" value="<?=$row['harga_tiket']?>" required>
                </div>
                <div class="mb-3">
                    <label for="jam_buka" class="form-label">Jam Buka</label>
                    <input type="time" class="form-control" id="jam_buka" name="jam_buka" value="<?=$row['jam_buka']?>" required>
                </div>
                <div class="mb-3">
                    <label for="jam_tutup" class="form-label">Jam Tutup</label>
                    <input type="time" class="form-control" id="jam_tutup" name="jam_tutup" value="<?=$row['jam_tutup']?>" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Update Destinasi</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
