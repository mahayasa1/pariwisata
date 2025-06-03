<?php
require_once '../../../config/database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Ambil data berita
$result = mysqli_query($conn, "SELECT * FROM tb_berita WHERE id_berita = $id");
$berita = mysqli_fetch_assoc($result);

// Ambil semua tempat wisata
$tempat = mysqli_query($conn, "SELECT * FROM tempat_wisata");

// Ambil tempat wisata yang terkait dengan berita
$relasi = mysqli_query($conn, "SELECT id_tempat FROM tb_berita_wisata WHERE id_berita = $id");
$relasi_terkait = [];
while ($r = mysqli_fetch_assoc($relasi)) {
    $relasi_terkait[] = $r['id_tempat'];
}

// Ambil gambar berita
$gambar = mysqli_query($conn, "SELECT * FROM tb_gambar WHERE id_berita = $id");

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];

    mysqli_query($conn, "UPDATE tb_berita SET judul='$judul', isi='$isi' WHERE id_berita=$id");

    // Update relasi berita_wisata
    mysqli_query($conn, "DELETE FROM tb_berita_wisata WHERE id_berita = $id");
    if (!empty($_POST['tempat_ids'])) {
        foreach ($_POST['tempat_ids'] as $id_tempat) {
            mysqli_query($conn, "INSERT INTO tb_berita_wisata (id_berita, id_tempat) VALUES ($id, $id_tempat)");
        }
    }

    // Upload gambar baru
    if (!empty($_FILES['gambar']['name'][0])) {
        foreach ($_FILES['gambar']['tmp_name'] as $key => $tmp_name) {
            $filename = uniqid('berita_', true) . '.' . pathinfo($_FILES['gambar']['name'][$key], PATHINFO_EXTENSION);
            $path = '../../../asset/img/berita/' . $filename;
            if (move_uploaded_file($tmp_name, $path)) {
                mysqli_query($conn, "INSERT INTO tb_gambar (id_berita, gambar) VALUES ($id, '$filename')");
            }
        }
    }

    echo "<script>alert('Berita berhasil diperbarui'); location.href='../../../view/admin/berita.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="card p-4 bg-secondary" style="max-width: 700px; width: 100%;">
        <h3 class="mb-3">Edit Berita</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Judul Berita</label>
                <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($berita['judul']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Isi Berita</label>
                <textarea name="isi" class="form-control" rows="6" required><?= htmlspecialchars($berita['isi']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tempat Wisata Terkait</label>
                <?php
                mysqli_data_seek($tempat, 0); // Reset pointer
                while ($t = mysqli_fetch_assoc($tempat)) : ?>
                    <div>
                        <input type="checkbox" name="tempat_ids[]" value="<?= $t['id_tempat'] ?>" <?= in_array($t['id_tempat'], $relasi_terkait) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($t['nama_tempat']) ?>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Berita Saat Ini</label>
                <div class="d-flex flex-wrap gap-2">
                    <?php while ($g = mysqli_fetch_assoc($gambar)) : ?>
                        <div class="border p-1 text-center">
                            <img src="../../../asset/img/berita/<?= $g['gambar'] ?>" width="100" class="img-thumbnail mb-1">
                            <a href="delete_gambar.php?id=<?= $g['id_gambar'] ?>&berita=<?= $id ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Gambar Baru</label>
                <input type="file" name="gambar[]" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="../../../view/admin/berita.php" class="btn btn-light">Kembali</a>
        </form>
    </div>
</div>
</body>
</html>
