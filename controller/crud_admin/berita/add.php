<?php
require_once '../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date('Y-m-d H:i:s');
    $tempat_ids = $_POST['tempat_ids'] ?? [];

    mysqli_query($conn, "INSERT INTO tb_berita (judul, isi, tanggal) VALUES ('$judul', '$isi', '$tanggal')");
    $id_berita = mysqli_insert_id($conn);

    // Gambar upload
    foreach ($_FILES['gambar']['tmp_name'] as $i => $tmp) {
        if ($_FILES['gambar']['error'][$i] === 0) {
            $name = uniqid() . '_' . $_FILES['gambar']['name'][$i];
            move_uploaded_file($tmp, "../../../asset/img/berita/$name");
            mysqli_query($conn, "INSERT INTO tb_gambar (id_berita, gambar) VALUES ($id_berita, '$name')");
        }
    }

    // Relasi tempat wisata
    foreach ($tempat_ids as $id_tempat) {
        mysqli_query($conn, "INSERT INTO tb_berita_wisata (id_berita, id_tempat) VALUES ($id_berita, $id_tempat)");
    }

    header("Location: ../../../view/admin/berita.php");
    exit;
}

$tempat = mysqli_query($conn, "SELECT * FROM tempat_wisata");
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
        <form method="post" enctype="multipart/form-data">
            <h3 class="text-center mb-4">Tambah Berita</h3>
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="isi" class="form-label">Isi</label>
                <textarea name="isi" class="form-control" rows="6" required></textarea>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Gambar</label>
                <input type="file" name="gambar[]" multiple class="form-control">
            </div>
            <div class="mb-3">
                <label>Destinasi Terkait</label>
                <?php while($row = mysqli_fetch_assoc($tempat)): ?>
                    <div>
                        <input type="checkbox" name="tempat_ids[]" value="<?= $row['id_tempat'] ?>">
                        <?= htmlspecialchars($row['nama_tempat']) ?>
                    </div>
                    <?php endwhile; ?>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="berita_index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>   
    </div>
</body>
</html>