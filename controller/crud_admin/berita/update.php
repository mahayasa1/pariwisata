<?php
require_once '../../../config/database.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM tb_berita WHERE id_berita = $id");
$berita = mysqli_fetch_assoc($result);

// Ambil semua gambar yang terkait
$gambarQuery = mysqli_query($conn, "SELECT * FROM tb_gambar WHERE id_berita = $id");

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];

    mysqli_query($conn, "UPDATE tb_berita SET judul='$judul', isi='$isi' WHERE id_berita=$id");

    // Upload gambar baru jika ada
    if (!empty($_FILES['gambar']['name'][0])) {
        foreach ($_FILES['gambar']['tmp_name'] as $key => $tmp_name) {
            $originalName = $_FILES['gambar']['name'][$key];
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            $uniqueName = uniqid('img_', true) . '.' . $ext;
            $target_path = '../../../asset/img/berita/' . $uniqueName;

            if (move_uploaded_file($tmp_name, $target_path)) {
                mysqli_query($conn, "INSERT INTO tb_gambar (id_berita, gambar) VALUES ($id, '$uniqueName')");
            }
        }
    }

    echo "<script>alert('Berita berhasil diperbarui'); location.href='../../../view/admin/berita.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">
<div class="container d-flex justify-content-center align-items-center min-vh-100 mt-4">
    <div class="card p-4 bg-secondary text-light shadow-sm" style="max-width: 500px; width: 100%;">
        <h3 class="mb-4">Edit Berita</h3>
        <form method="post" enctype="multipart/form-data" action="">
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($berita['judul']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Isi</label>
                <textarea name="isi" class="form-control" rows="6" required><?= htmlspecialchars($berita['isi']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label>
                <div class="d-flex flex-wrap gap-2">
                    <?php while ($g = mysqli_fetch_assoc($gambarQuery)) : ?>
                        <div class="border p-1 text-center">
                            <img src="../../../asset/img/berita/<?= $g['gambar'] ?>" width="100" class="img-thumbnail mb-1">
                            <a href="delete_gambar.php?id=<?= $g['id_gambar'] ?>&berita=<?= $id ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Tambah Gambar Baru (opsional)</label>
                <input type="file" name="gambar[]" class="form-control" multiple>
            </div>
            <button type="submit" class="btn btn-success">Update Berita</button>
            <a href="../../../view/admin/berita.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
