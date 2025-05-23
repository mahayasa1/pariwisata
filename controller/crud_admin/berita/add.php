<?php
require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    
    mysqli_query($conn, "INSERT INTO tb_berita (judul, isi) VALUES ('$judul', '$isi')");
    $id_berita = mysqli_insert_id($conn);

    foreach ($_FILES['gambar']['tmp_name'] as $key => $tmp_name) {
    $originalName = $_FILES['gambar']['name'][$key];
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);

    // Buat nama unik
    $uniqueName = uniqid('img_', true) . '.' . $ext;

    $target_path = '../../../asset/img/berita/' . $uniqueName;

    if (move_uploaded_file($tmp_name, $target_path)) {
        mysqli_query($conn, "INSERT INTO tb_gambar (id_berita, gambar) VALUES ($id_berita, '$uniqueName')");
    }
}


    echo "<script>alert('Berita berhasil ditambahkan'); location.href='../../../view/admin/berita.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah berita</title>
</head>
<body class="bg-dark">
<div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
    <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
<form method="post" enctype="multipart/form-data" action="">
    <h3 class="text-center mb-4">Tambah Berita</h3>
  <div class="mb-3">
    <label for="judul" class="form-label">Judul Berita</label>
    <input type="text" name="judul" id="judul" class="form-control" required>
  </div>
  <div class="mb-3">
    <label for="isi" class="form-label">Isi Berita</label>
    <textarea name="isi" id="isi" rows="5" class="form-control" required></textarea>
  </div>
  <div class="mb-3">
    <label for="gambar" class="form-label">Upload Gambar (bisa banyak)</label>
    <input type="file" name="gambar[]" id="gambar" class="form-control" multiple required>
  </div>
  <button type="submit" class="btn btn-primary">Simpan Berita</button>
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
